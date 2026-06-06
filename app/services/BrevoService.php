<?php

namespace App\Services;

use GuzzleHttp\Client;

class BrevoService
{
    protected Client $http;
    protected string $apiKey;

    public function __construct()
    {
        $this->http = new Client([
            'base_uri' => 'https://api.brevo.com/v3/', // Brevo API əsas URI
            'timeout'  => 10,
        ]);
        $this->apiKey = env('BREVO_API_KEY'); // API açarını .env faylından çəkirik
    }

    /**
     * Göndərilən e-poçtların hadisələrini çəkmək
     */
    public function getEvents(array $params = []): array
    {
        try {
            $response = $this->http->get('smtp/events', [
                'headers' => [
                    'accept' => 'application/json',
                    'api-key' => $this->apiKey, // API açarını başlıqda göndəririk
                ],
                'query' => $params, // Parametrləri query olaraq göndəririk
            ]);

            // JSON cavabını array olaraq geri qaytarırıq
            return json_decode((string) $response->getBody(), true);
        } catch (\Exception $e) {
            // Əgər səhv baş verərsə, onu tuturuq və error mesajı qaytarırıq
            return ['error' => $e->getMessage()];
        }
    }

    /**
     * Göndərilmiş e-poçt statistikalarını çəkmək
     */
    public function getEmailStatistics(array $params = []): array
    {
        try {
            $response = $this->http->get('smtp/statistics', [
                'headers' => [
                    'accept' => 'application/json',
                    'api-key' => $this->apiKey,
                ],
                'query' => $params,
            ]);

            return json_decode((string) $response->getBody(), true);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    /**
     * Bir istifadəçiyə e-poçt göndərmək
     */
    public function sendToOne(string $subject, string $html, string $toEmail): array
    {
        $payload = [
            'sender'      => ['name' => env('BREVO_SENDER_NAME'), 'email' => env('BREVO_SENDER_EMAIL')],
            'to'          => [['email' => $toEmail]],
            'subject'     => $subject,
            'htmlContent' => $html,
        ];

        $res = $this->http->post('smtp/email', [
            'headers' => [
                'accept'       => 'application/json',
                'api-key'      => $this->apiKey,
                'content-type' => 'application/json',
            ],
            'json' => $payload,
        ]);

        return json_decode((string) $res->getBody(), true);
    }
}
