<?php
namespace App\Http\Controllers\Brevo;

use App\Http\Controllers\Controller;
use App\Services\BrevoService;
use Illuminate\Http\Request;

class BrevoController extends Controller
{
    protected $brevoService;

    public function __construct(BrevoService $brevoService)
    {
        $this->brevoService = $brevoService;
    }

    // Göndərilən e-poçtların statistikasını göstərmək
    public function showEmailStatistics()
    {
        // Brevo API vasitəsilə statistikaları çəkirik
        $statistics = $this->brevoService->getEmailStatistics();

        // Debugging üçün cavabı yoxlaya bilərsiniz
        dd($statistics);

        // Statistikadan istədiyimiz məlumatları çıxarırıq
        $emails_sent = $statistics['sent'] ?? 'No data'; // Göndərilən e-poçt sayı
        $limit = $statistics['limit'] ?? 'No data';     // Göndərmə limiti
        $another_variable = $statistics['another_variable'] ?? 'No data'; // Əlavə bir dəyişən

        // E-poçt statistikalarını Blade şablonuna compact() ilə göndəririk
        return view('frontend.pages.index', compact('emails_sent', 'limit', 'another_variable'));
    }
}

