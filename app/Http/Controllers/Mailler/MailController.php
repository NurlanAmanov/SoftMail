<?php

namespace App\Http\Controllers\Mailler;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Email;
use App\Models\EmailRecipient;
use App\Models\EmailTemplate;
use App\Jobs\SendBrevoEmail;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class MailController extends Controller
{
    protected string $senderName;
    protected string $senderEmail;

    public function __construct()
    {
        $this->senderName  = (string) env('BREVO_SENDER_NAME', 'Soft Tech');
        $this->senderEmail = (string) env('BREVO_SENDER_EMAIL', 'no-reply@example.com');
    }

    public function form()
    {
        $contacts       = Contact::orderBy('email')->get(['id', 'email']);
        $recipientsList = $contacts->pluck('email')->implode(', ');
        $templates      = EmailTemplate::latest()->get();

        return view('frontend.pages.mail.sendmail', compact(
            'contacts',
            'recipientsList',
            'templates'
        ));
    }

    private function parseRecipients(string $raw): array
    {
        $raw   = str_replace(["\r\n", "\n", "\r", ";"], ',', $raw);
        $parts = array_map('trim', explode(',', $raw));
        $parts = array_filter($parts, fn($e) => filter_var($e, FILTER_VALIDATE_EMAIL));
        return array_values(array_unique($parts));
    }

    public function send(Request $req)
    {
        $v = $req->validate([
            'subject'    => 'required|string|max:255',
            'template'   => 'required|exists:email_templates,id',
            'recipients' => 'required|string',
            'body_html'  => 'nullable|string',
            'attachment' => 'nullable|file|max:10240|mimes:pdf,doc,docx,xls,xlsx,png,jpg,jpeg',
        ]);

        $recipients = $this->parseRecipients($v['recipients']);
        if (empty($recipients)) {
            return back()->withErrors(['recipients' => 'Düzgün email ünvanları daxil et.']);
        }

        // ── Attachment: faylı base64-ə çevir (Brevo tələb edir) ──────
        $attachmentData = null;
        if ($req->hasFile('attachment')) {
            $file           = $req->file('attachment');
            $attachmentData = [
                'name'    => $file->getClientOriginalName(),
                'content' => base64_encode(file_get_contents($file->getRealPath())),
            ];
        }

        $dbTemplate   = EmailTemplate::findOrFail($v['template']);
        $placeholders = $dbTemplate->json_structure ?? [];

        $html = $dbTemplate->html_content;
        foreach ($placeholders as $key) {
            if ($key === 'CONTENT') {
                // CONTENT placeholder-ini Quill HTML-i ilə əvəz et
                $value = $v['body_html'] ?? '';
            } else {
                $value = $req->input(strtolower($key), '');
            }
            $html = str_replace('[[' . $key . ']]', $value, $html);
        }

        $email = Email::create([
            'subject'      => $v['subject'],
            'title'        => $req->input('title', ''),
            'html'         => $html,
            'button_text'  => $req->input('button_text', ''),
            'button_url'   => $req->input('button_url', ''),
            'sender_name'  => $this->senderName,
            'sender_email' => $this->senderEmail,
        ]);

        foreach ($recipients as $index => $addr) {
            $row = EmailRecipient::create([
                'email_id'        => $email->id,
                'recipient_email' => $addr,
                'status'          => 'queued',
            ]);

            $payload = [
                'sender'      => ['name' => $this->senderName, 'email' => $this->senderEmail],
                'to'          => [['email' => $addr]],
                'subject'     => $v['subject'],
                'htmlContent' => $html,
            ];

            if ($attachmentData) {
                $payload['attachment'] = [$attachmentData];
            }

            SendBrevoEmail::dispatch([
                'recipient_id' => $row->id,
                'payload'      => $payload,
            ])->delay(now()->addSeconds($index * 10));
        }

        $msg = 'Kampaniya növbəyə alındı. Cəmi ' . count($recipients) . ' ünvan işlənilir.';
        if ($attachmentData) {
            $msg .= ' Əlavə fayl: ' . $attachmentData['name'];
        }

        return back()->with('message', $msg);
    }

    public function report()
    {
        $emails = Email::with('recipients')->latest()->paginate(15);
        return view('frontend.pages.mail.openmails', compact('emails'));
    }

    public function syncEvents(Request $request)
    {
        $http = new Client(['base_uri' => 'https://api.brevo.com/v3/']);
        try {
            $res  = $http->get('smtp/events', [
                'headers' => ['accept' => 'application/json', 'api-key' => env('BREVO_API_KEY')],
                'query'   => array_filter([
                    'event' => $request->get('event'),
                    'limit' => $request->get('limit', 100),
                ]),
            ]);
            foreach (json_decode($res->getBody(), true)['events'] ?? [] as $e) {
                $this->processEvent($e);
            }
            return back()->with('synced', true);
        } catch (\Exception $e) {
            return back()->withErrors(['sync' => 'Sinxronizasiya xətası: ' . $e->getMessage()]);
        }
    }

    public function webhook(Request $request)
    {
        $events = $request->all();
        if (isset($events['event'])) $events = [$events];
        foreach ($events as $e) $this->processEvent($e);
        return response()->json(['ok' => true]);
    }

    private function processEvent(array $e)
    {
        $event     = $e['event']                         ?? null;
        $messageId = $e['messageId'] ?? $e['message-id'] ?? null;
        $email     = $e['email']                         ?? null;

        if (!$event || (!$messageId && !$email)) return;

        $row = EmailRecipient::when($messageId, fn($q) => $q->where('brevo_message_id', $messageId))
            ->when(!$messageId && $email, fn($q) => $q->where('recipient_email', $email))
            ->latest()->first();

        if ($row) $this->updateRecipientStatus($row, $event, $e);
    }

    private function updateRecipientStatus($row, string $event, array $data)
    {
        match ($event) {
            'delivered'  => [$row->status = 'delivered', $row->delivered_at = now()],
            'opened'     => [$row->status = 'opened', $row->open_count = ($row->open_count ?? 0) + 1, $row->opened_at = $row->opened_at ?: now()],
            'click'      => [$row->status = 'clicked', $row->clicked_at = $row->clicked_at ?: now()],
            'hardBounce',
            'softBounce' => [$row->status = 'bounced'],
            'blocked'    => [$row->status = 'blocked'],
            default      => null,
        };
        $row->last_response = $data;
        $row->save();
    }
}
