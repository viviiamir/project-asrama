<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;

class TelegramService
{
    private ?string $token;
    private ?string $api;

    public function __construct()
    {
        $this->token = config('services.telegram.token');
        $this->api   = $this->token ? "https://api.telegram.org/bot{$this->token}" : null;
    }

    public function sendMessage(int|string $chatId, string $text): array
    {
        if (!$this->api) {
            return ['ok' => false, 'body' => 'Telegram token not set'];
        }

        $res = Http::asForm()->post("{$this->api}/sendMessage", [
            'chat_id' => $chatId,
            'text' => $text,
            'parse_mode' => 'HTML'
        ]);

        return ['ok' => $res->ok(), 'body' => $res->json()];
    }

    public function sendPhoto(int|string $chatId, string $photoUrl, string $caption = ''): array
    {
        if (!$this->api) {
            return ['ok' => false, 'body' => 'Telegram token not set'];
        }

        $res = Http::asForm()->post("{$this->api}/sendPhoto", [
            'chat_id' => $chatId,
            'photo' => $photoUrl,
            'caption' => $caption,
            'parse_mode' => 'HTML'
        ]);

        return ['ok' => $res->ok(), 'body' => $res->json()];
    }
}
