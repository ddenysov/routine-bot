<?php

namespace App\Controller;


use Longman\TelegramBot\Exception\TelegramException;
use Longman\TelegramBot\Telegram;

class WebHookController
{
    /**
     * Index
     */
    public function index()
    {
        $bot_api_key  = '2118172018:AAE3BGPeOkqTw3624TSj9kMi-Y-o40FnkxI';
        $bot_username = 'ATLAS_DAILY_BOT';

        try {
            // Create Telegram API object
            $telegram = new Telegram($bot_api_key, $bot_username);

            // Handle telegram webhook request
            $telegram->handle();
        } catch (TelegramException $e) {
            // Silence is golden!
            // log telegram errors
            // echo $e->getMessage();
        }
    }
}
