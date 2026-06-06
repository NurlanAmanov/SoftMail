<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use GuzzleHttp\Client;
use App\Models\EmailRecipient;

class SendBrevoEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $details;

    /**
     * İşin neçə dəfə təkrar cəhd ediləcəyi.
     */
    public $tries = 3;

    /**
     * Xəta baş verərsə, neçə saniyə gözləyib təkrar yoxlayacağı.
     */
    public $backoff = 60;

    /**
     * İşin maksimum icra müddəti (saniyə ilə).
     */
    public $timeout = 120;

    public function __construct($details)
    {
        $this->details = $details;
    }

    public function handle()
    {
        // Əgər iş artıq çox yoxlanılıbsa, dayan
        if ($this->attempts() > $this->tries) {
            return;
        }

            $client = new Client([
    'base_uri' => 'https://api.brevo.com/v3/',
    'verify'   => false, // SSL yoxlamasını söndürürük ki, o xətanı verməsin
]);
        $row = EmailRecipient::find($this->details['recipient_id']);

        if (!$row) {
            return;
        }

        try {
            $res = $client->post('smtp/email', [
                'headers' => [
                    'accept'       => 'application/json',
                    'api-key'      => env('BREVO_API_KEY'),
                    'content-type' => 'application/json',
                ],
                'json' => $this->details['payload'],
                'connect_timeout' => 10,
                'timeout' => 30,
            ]);

            $body = json_decode((string) $res->getBody(), true);
            
            $row->update([
                'status'           => 'sent',
                'brevo_message_id' => $body['messageId'] ?? null,
                'last_response'    => $body,
            ]);

        } catch (\Throwable $e) {
            // Xətanı bazaya yazırıq
            $row->update([
                'status'        => 'error',
                'last_response' => [
                    'error' => $e->getMessage(),
                    'attempt' => $this->attempts()
                ],
            ]);

            
            $this->fail($e);
        }
    }
}