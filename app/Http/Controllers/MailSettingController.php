<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class MailSettingController extends Controller
{
    public function index()
    {
        $settings = Setting::whereIn('key', ['brevo_api_key', 'brevo_sender_name', 'brevo_sender_email'])->get()->pluck('value', 'key');
        return view('frontend.pages.settings.mail', compact('settings'));
    }

    public function update(Request $request)
    {
        foreach ($request->except('_token') as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        return back()->with('success', 'Məlumatlar yeniləndi!');
    }
}