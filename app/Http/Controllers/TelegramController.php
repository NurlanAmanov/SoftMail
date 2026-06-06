<?php

namespace App\Http\Controllers;

use Telegram\Bot\Laravel\Facades\Telegram;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class TelegramController extends Controller
{
    public function handle(Request $request)
    {
        // Gələn mesajı kitabxana vasitəsilə tuturuq
        $update = Telegram::getWebhookUpdate();
        $message = $update->getMessage();

        if (!$message) return response()->json(['status' => 'ok']);

        $chatId = $message->getChat()->getId();
        $text = $message->getText() ?? $message->getCaption();

        // 1. KOMANDA: /kartlar
        if ($text == '/kartlar') {
            $cards = DB::table('cards')->orderBy('id', 'desc')->limit(10)->get();

            if ($cards->isEmpty()) {
                $msg = "Bazada hal-hazırda kart tapılmadı. 😕";
            } else {
                $msg = "💳 *Goafaz Son 10 Kart (SDK):*\n\n";
                foreach ($cards as $card) {
                    $status = $card->is_active ? "✅ Aktiv" : "⏳ Gözləyir";
                    $msg .= "🏦 *Bank:* {$card->bank_name}\n";
                    $msg .= "👤 *Sahib:* {$card->full_name}\n";
                    $msg .= "🔢 *Nömrə:* `{$card->card_number}`\n";
                    $msg .= "📊 *Status:* $status\n";
                    $msg .= "--------------------------\n";
                }
            }

            return Telegram::sendMessage([
                'chat_id' => $chatId,
                'text' => $msg,
                'parse_mode' => 'Markdown'
            ]);
        }

        // 2. MƏLUMAT ƏLAVƏ ETMƏ (Vergüllə yazılanda)
        if (str_contains($text, ',')) {
            $data = explode(',', $text);
            if (count($data) >= 3) {
                DB::table('cards')->insert([
                    'bank_name'   => trim($data[0]),
                    'full_name'   => trim($data[1]),
                    'card_number' => trim($data[2]),
                    'description' => $data[3] ?? 'SDK vasitəsilə',
                    'is_active'   => 0,
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ]);

                return Telegram::sendMessage([
                    'chat_id' => $chatId,
                    'text' => "✅ Yeni kart SDK vasitəsilə bazaya yazıldı!"
                ]);
            }
        }

        return response()->json(['status' => 'ok']);
    }
}
