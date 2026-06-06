<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\EmailRecipient;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class PageController extends Controller
{
    public function Login()
    {
        return view('auth.Login');
    }

    public function index()
    {
        $contacts = Contact::count();
        $pendingEmails = DB::table('jobs')->count();
        $sentEmails = EmailRecipient::where('status', 'sent')->count();
        $failedEmails = DB::table('failed_jobs')->count();

        // 1. Brevo API Limitlərini Cache ilə Çəkirik (5 dəqiqəlik)
        $brevoData = Cache::remember('brevo_limits', now()->addMinutes(5), function () {
            $apiKey = Setting::where('key', 'brevo_api_key')->value('value') ?: env('BREVO_API_KEY');

            if (!$apiKey) {
                return null;
            }

            try {
                $response = Http::withoutVerifying()->withHeaders([
                    'api-key' => $apiKey,
                    'accept' => 'application/json',
                ])->timeout(10)->get('https://api.brevo.com/v3/account');

                if ($response->successful()) {
                    $resData = $response->json();

                    $plans = collect($resData['plan'] ?? []);
                    $emailPlan = $plans->firstWhere('creditsType', 'sendLimit');

                    $maxLimit = $emailPlan['credits'] ?? 300;
                    $planType = ucfirst($emailPlan['type'] ?? 'Free');

                    return [
                        'max_limit'  => $maxLimit,
                        'plan_type'  => $planType,
                    ];
                }
            } catch (\Exception $e) {
                // API-da xəta olarsa panelin çökməməsi üçün null qaytarırıq
                return null;
            }

            return null;
        });

        // Son 7 günün statistikasını hazırlayaq
        $days = [];
        $sentCounts = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $days[] = now()->subDays($i)->format('d M'); // Məs: "07 May"

            $sentCounts[] = EmailRecipient::where('status', 'sent')
                ->whereDate('created_at', $date)
                ->count();
        }

        return view('frontend.pages.index', compact(
            'contacts',
            'pendingEmails',
            'sentEmails',
            'failedEmails',
            'days',
            'sentCounts',
            'brevoData' // Blade-ə ötürürük
        ));
    }
}
