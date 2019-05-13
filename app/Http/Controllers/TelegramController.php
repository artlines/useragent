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
            $chat_id = $result["message"]["chat"]["id"]; //Уникальный идентификатор пользователя
            $text = $result["message"]["text"]; //Текст сообщения
            $first_name = $result['message']['chat']['first_name'];
            $last_name = $result['message']['chat']['last_name'];
            $username = $result["message"]["from"]["username"];

            $user = Tguser::where('chat_id', $chat_id)->first();
            if (!$user) {
                $user = Tguser::create([
                    'chat_id' => $chat_id,
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'user_name' => $username,
                ]);
                $au = User::create([
                    'name' => $chat_id,
                ]);
            }
            $reply = null;
            if ($text) {
                if (strpos($text, '/start') !== false) {

                    $code = Str::random(7);
                    $user->code = $code;
                    $user->save();
                    $reply = "Ваш код для входа " . $code;
                    if (!$user->phone) {
                        $inline_keyboard = [[array('request_contact' => true)]];
                        $keyboard = array("inline_keyboard" => $inline_keyboard);
                        $replyMarkup = json_encode($keyboard);
                        //$reply .= $replyMarkup;
                        //$sm['']=$reply_markup;
                        //$sm=['chat_id'] => $chat_id;
                        //Telegram::sendMessage($sm);
                    }
                }

                $sm = ['chat_id' => $chat_id, 'text' => $reply];
                if (isset($replyMarkup)) {
                    $sm['reply_markup'] = $replyMarkup;
                }
                /*
                        if(array_key_exists('inline_keyboard',$ans)) {
                            $keyboard=$ans['inline_keyboard'];
                            $replyMarkup = json_encode($keyboard);
                            $sm['reply_markup'] = $replyMarkup;
                        }
                        else if(array_key_exists('keyboard',$ans)){
                            $keyboard=$ans['keyboard'];
                            $reply_markup = $telegram->replyKeyboardMarkup([ 'keyboard' => $keyboard, 'resize_keyboard' => true, 'one_time_keyboard' => false ]);
                            $sm['reply_markup']=$reply_markup;
                        }
                        */
                Telegram::sendMessage($sm);

            }
            Log::debug($result);
        }
    }
}
