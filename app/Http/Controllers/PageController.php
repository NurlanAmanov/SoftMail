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
                $response = Http::withHeaders([
                    'api-key' => $apiKey,
                    'accept' => 'application/json',
                ])->timeout(3)->get('https://api.brevo.com/v3/account');

                if ($response->successful()) {
                    $resData = $response->json();

                    // Kredit və ya email planını tapırıq
                    $creditsPlan = collect($resData['plan'])->firstWhere('type', 'credits')
                        ?? collect($resData['plan'])->firstWhere('type', 'emails');

                    $maxLimit = $creditsPlan['credits'] ?? 300; // Default pulsuz plan limiti
                    $usedLimit = $creditsPlan['creditsUsed'] ?? 0;
                    $remaining = $maxLimit - $usedLimit;
                    $percentage = $maxLimit > 0 ? ($usedLimit / $maxLimit) * 100 : 0;

                    return [
                        'max_limit'   => $maxLimit,
                        'used_limit'  => $usedLimit,
                        'remaining'   => $remaining,
                        'percentage'  => round($percentage, 1),
                        'plan_type'   => $creditsPlan['planType'] ?? 'Free'
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
