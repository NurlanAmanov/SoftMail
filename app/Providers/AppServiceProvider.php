<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
     if (Schema::hasTable('settings')) {
        $settings = \App\Models\Setting::whereIn('key', [
            'brevo_api_key', 
            'brevo_sender_name', 
            'brevo_sender_email'
        ])->get()->pluck('value', 'key');

        if ($settings->count() > 0) {
            config([
                'services.brevo.key' => $settings->get('brevo_api_key'),
                'mail.from.address'  => $settings->get('brevo_sender_email'),
                'mail.from.name'     => $settings->get('brevo_sender_name'),
            ]);
        }
    }
    }
}
