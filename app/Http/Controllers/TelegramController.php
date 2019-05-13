<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Telegram;
use Illuminate\Support\Facades\Log;
use App\Tguser;
use Illuminate\Support\Str;
use App\User;

class TelegramController extends Controller
{
    public function webHook()
    {
        Log::debug('WebHook');
        $result = Telegram::getWebhookUpdates();
        Log::debug($result);
        if (isset($result["message"])) {
            $chat_id = $result["message"]["chat"]["id"];
            $text = $result["message"]["text"] ?? '';
            $first_name = $result['message']['chat']['first_name'] ?? '';
            $last_name = $result['message']['chat']['last_name'] ?? '';
            $username = $result["message"]["chat"]["username"] ?? '';

            $user = Tguser::where('chat_id', $chat_id)->first();
            if (!$user) {
                $user = Tguser::create([
                    'chat_id' => $chat_id,
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'user_name' => $username,
                ]);
                User::create([
                    'name' => $chat_id,
                ]);
            }

            if ($text) {
                if (mb_stripos($text, '/start') !== false) {

                    $code = Str::random(7);
                    $user->first_name = $first_name;
                    $user->username = $username;
                    $user->last_name = $last_name;
                    $user->code = $code;
                    $user->save();

                    $reply = "Ваш код для входа " . $code;
                    $sm['text'] = $reply;
                    $sm['chat_id'] = $chat_id;
                    Telegram::sendMessage($sm);
                }
            }
        }
    }
}
