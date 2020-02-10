<?php


namespace App\Http\Controllers;


use App\Services\Helpers;
use App\Site;
use App\TelegramUser;
use App\User;
use Carbon\Carbon;
use Config;
use Exception;
use Log;
use Str;
use Telegram;
use TrueBV\Punycode;

class TelegramBotController extends Controller
{

    public function webHook()
    {
        try
        {
            /**
             * @var $update Telegram\Bot\Objects\Update
             */
            $update = Telegram::commandsHandler(true);

            if ($update->has('callback_query'))
            {
                /**
                 * @var $callbackQuery Telegram\Bot\Objects\CallbackQuery
                 */
                $callbackQuery = $update->get('callback_query');
            }
            else if ($update->has('message'))
            {
                $text = '';
                $chatId = 0;
                $userId = 0;
                try
                {
                    $text = trim($update->getMessage()->text);
                    if ((strlen($text) > 0) &&
                        ($text[0] !== '/') &&
                        (strpos($text, '.') != false) &&
                        (strpos($text,' ') === false))
                    {
                        $chatId = $update->getMessage()->getChat()->id;
                        $userId = $update->getMessage()->get('from')->id;
                        # Ищем пользователя по Id чата, с последней командой = 'code' и временем последнего обновления менее 5 минут
                        $telegramUser = TelegramUser::where([
                            'chat_id' => $chatId,
                            'last_command' => 'code'
                        ])->where('updated_at', '>', Carbon::now()->subMinutes(5))->first();

                        # Если пользователь найден, значит можно осуществлять проверку его сообщения
                        if (!empty($telegramUser))
                        {
                            $inputs = array('site' => $text);
                            $parsed_url = parse_url($text);
                            if (!isset($parsed_url['scheme'])) {
                                $parsed_url['scheme'] = 'http';
                                $parsed_url = parse_url(Helpers::unparse_url($parsed_url));
                            }
                            $host = (isset($parsed_url['host']) ? $parsed_url['host'] : '');
                            if (isset($parsed_url['host'])) {
                                $punycode = new Punycode();
                                $parsed_url['host'] = $punycode->encode($parsed_url['host']);
                                $inputs['site'] = Helpers::unparse_url($parsed_url);
                            }
                            $validator = \Validator::make( $inputs, [
                                'site' => 'required|string|site'
                            ]);
                            if ($validator->fails())
                            {
                                Telegram::sendMessage([
                                    "chat_id" => $chatId,
                                    "text" => "К сожалению, не удалось определить ваш текст как ссылку.\nПопробуйте вставить только домен."
                                ]);
                            }
                            else if (!empty($host))
                            {
                                $app_url = Config::get('app.url');
                                if (empty($app_url))
                                    $app_url = 'https://user-agent.cc';

                                $site = Site::where([ 'url' => $host ])->first();

                                if (!empty($site))
                                {
                                    $message = "Такой сайт уже добавлен в ваш список.\n";
                                    $message .= "Вот код для размещения на вашем сайте - " . $host . "\n\n";
                                    $message .= "`<script src=\"" . $app_url . "/cdn/fpinit.js\"></script><script>FpInit('" . $site->id . "_" . $site->code . "')</script>`";
                                    $message .= "\n\nДобавьте его перед закрывающим тегом *</body>*\n";
                                    $message .= "Для настройки типов оповещений запустите команду - /settings";

                                    Telegram::sendMessage([
                                        "chat_id" => $chatId,
                                        "text" => $message,
                                        "parse_mode" => "markdown"
                                    ]);
                                }
                                else
                                {
                                    $user = User::where([
                                        'name' => $userId
                                    ])->first();

                                    $rand_code = Str::random(12);
                                    if ($user instanceof User)
                                    {
                                        $site = new Site();
                                        $site->user_id = $user->id;
                                        $site->url = $host;
                                        $site->code = $rand_code;
                                        $site->save();

                                        $message = "Вот код для размещения на вашем сайте - " . $host . "\n\n";
                                        $message .= "`<script src=\"" . $app_url . "/cdn/fpinit.js\"></script><script>FpInit('" . $site->id . "_" . $rand_code . "')</script>`";
                                        $message .= "\n\nДобавьте его перед закрывающим тегом *</body>*\n";
                                        $message .= "Для настройки типов оповещений запустите команду - /settings";


                                        Telegram::sendMessage([
                                            "chat_id" => $chatId,
                                            "text" => $message,
                                            "parse_mode" => "markdown"
                                        ]);
                                    }
                                    else
                                    {
                                        Telegram::sendMessage([
                                            "chat_id" => $chatId,
                                            "text" => "Вы еще не зарегистрированы.\nПожалуйста, зарегистрируйтесь через команду - /login"
                                        ]);
                                    }
                                }

                                $telegramUser->last_command = '';
                                $telegramUser->save();
                            }
                        }
                    }
                }
                catch (Exception $ex)
                {
                    Log::error('Error Message: ' . $ex->getMessage());
                    Log::error('Send Data: ', ['user_id' => $userId, 'chat_id' => $chatId, 'text_from_chat' => $text]);
                    Log::error('Stack Trace: ' . $ex->getTraceAsString());
                }
            }
        }
        catch (Exception $ex)
        {
            Log::error('TelegramBotController webHook() exception.');
            Log::error('Error Message: ' . $ex->getMessage());
            Log::error('Stack Trace: ' . $ex->getTraceAsString());
        }




//        if($update->has('message')){
//
//            $message = $update->getMessage();
//
//            if($message->replyToMessage && $message->contact){
//
//                $cacheKey = "tg.phone_verify.{$this->getChatFromUpdate()->getId()}";
//                if(Cache::get($cacheKey) == $message->replyToMessage->messageId){
//
//                    $user = User::whereName($message->replyToMessage->contact->userId)->first();
//                    $user->phone = $message->replyToMessage->contact->phoneNumber;
//                    if($user->save()){
//                        Telegram::sendMessage([
//                            'chat_id' => $message->replyToMessage->contact->userId,
//                            'text' => 'Телефонный номер успешно подтвержден.'
//                        ]);
//                    }
//
//
//                }
//            }
//        }

    }
}