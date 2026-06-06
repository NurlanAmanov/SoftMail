<?php

namespace App\Http\Controllers\Mailler;

use App\Http\Controllers\Controller;
use App\Models\EmailRecipient;
use Illuminate\Http\Request;

class MailWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $data = $request->all();

        // Burada Brevo eventləri gəlir: delivered, opened, click, bounce...
        // $data['event'] → "delivered", "opened", "click"
        // $data['email'] → kimə göndərilib
        // $data['message-id'] → Brevo mesaj ID

        if (!empty($data['email']) && !empty($data['event'])) {
            EmailRecipient::where('recipient_email', $data['email'])
                ->update([
                    'status' => $data['event'], // məsələn "opened"
                    'last_response' => $data,
                ]);
        }

        return response()->json(['ok' => true]);
    }
}

