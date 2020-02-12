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
use Telegram\Bot\Keyboard\Keyboard;
use TrueBV\Punycode;

class TelegramBotController extends Controller
{
    /**
     * Cache time for callback answer in seconds.
     */
    private const CALLBACK_CACHE_TIME = 0;

    /**
     * Действия команды - /settings
     */
    private const CALLBACK_SETTINGS_ACTIONS = array(
        'visits' => array(
            'key' => 'v',
            'title' => 'Посещения'
        ),
        'start_of_input' => array(
            'key' => 'soi',
            'title' => 'Начало ввода'
        ),
        'form_submission' => array(
            'key' => 'fs',
            'title' => 'Отправка форм'
        ),
        'clicks_on_phone' => array(
            'key' => 'cop',
            'title' => 'Клики по телефону'
        ),
        'clicks_on_whatsapp' => array(
            'key' => 'cow',
            'title' => 'Клики по WhatsApp'
        ),
        'whatsapp_id' => array(
            'key' => 'wi',
            'title' => 'WhatsApp #Id'
        ),
        'notifications' => array(
            'key' => 'non',
            'title' => 'Уведомления'
        ),
        'delete' => array(
            'key' => 'del',
            'title' => 'Удалить сайт'
        ),
        'back_to_sites' => array(
            'key' => 'bts',
            'title' => 'Назад к списку сайтов'
        )
    );

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
                $callbackQuery = $update->getCallbackQuery();
                $callbackQueryId = $callbackQuery->getId();
                $callbackData = $callbackQuery->getData();
                $chatId = $callbackQuery->getMessage()->getChat()->id;
                $messageId = $callbackQuery->getMessage()->message_id;

                $callbackJson = json_decode($callbackData, true);

                if (json_last_error() != JSON_ERROR_NONE)
                {
                    if (strpos($callbackData, 'sites@') !== false)
                    {
                        Telegram::answerCallbackQuery([
                            "callback_query_id" => $callbackQueryId,
                            "cache_time" => 1
                        ]);
                        return;
                    }
                    Log::error('TelegramBotController webHook() error.');
                    Log::error('CallbackQuery Error. Chat Id: ' . $chatId . ' Message Id: ' . $messageId);
                    Log::error('JSON decode error. Error msg: ' . json_last_error_msg() . ' Callback Data: ' . $callbackData);

                    Telegram::answerCallbackQuery([
                        "callback_query_id" => $callbackQueryId,
                        "text" => "Невозможно обработать это действие, повторите попытку или обратитесь в поддержку",
                        "cache_time" => self::CALLBACK_CACHE_TIME
                    ]);
                    return;
                }

                if (!isset($callbackJson['c']))
                {
                    Log::error('TelegramBotController webHook() error.');
                    Log::error('CallbackQuery Error. Chat Id: ' . $chatId . ' Message Id: ' . $messageId);
                    Log::error('Error msg: empty callback command. Callback Data: ' . $callbackData);
                    Telegram::answerCallbackQuery([
                        "callback_query_id" => $callbackQueryId,
                        "text" => "Невозможно обработать это действие, повторите попытку или обратитесь в поддержку",
                        "cache_time" => self::CALLBACK_CACHE_TIME
                    ]);
                    return;
                }

                switch ($callbackJson['c'])
                {
                    case 'st': # Command => Settings
                        $this->onCallbackSettings($callbackQueryId, $callbackData, $callbackJson, $chatId, $messageId);
                        break;
                    case 'st_a': # Command => Settings -> Action
                        $this->onCallbackSettingsAction($callbackQueryId, $callbackData, $callbackJson, $chatId, $messageId);
                        break;
                }
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

                                $user = User::where([
                                    'name' => $chatId
                                ])->first();

                                if (empty($user))
                                {
                                    $msg = ($chatId < 0 ?
                                            "Этот чат еще не зарегистрирован." :
                                            "Вы еще не зарегистрированы.") . "\nПожалуйста, зарегистрируйтесь через команду - /start";
                                    Telegram::sendMessage([
                                        "chat_id" => $chatId,
                                        "text" => $msg
                                    ]);
                                    $telegramUser->last_command = '';
                                    $telegramUser->save();
                                    return;
                                }

                                $site = Site::where([
                                    'user_id' => $user->id,
                                    'url' => $host
                                ])->first();

                                if (!empty($site))
                                {
                                    $message = "Вот код для размещения на вашем сайте - " . $host . "\n\n";
                                    $message .= "`<script src=\"" . $app_url . "/cdn/fpinit.js\"></script><script>FpInit('" . $site->id . "_" . $site->code . "')</script>`";
                                    $message .= "\n\nДобавьте его перед закрывающим тегом *</body>*\n";
                                    $message .= "Для настройки типов оповещений запустите команду - /settings";

                                    Telegram::sendMessage([
                                        "chat_id" => $chatId,
                                        "text" => $message,
                                        "parse_mode" => "markdown"
                                    ]);

                                    $site->update([ 'deleted' => false ]);
                                }
                                else
                                {
                                    $rand_code = Str::random(12);
                                    $site = new Site();
                                    $site->user_id = $user->id;
                                    $site->url = $parsed_url['host'];
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

    private function onCallbackSettings($callbackQueryId, $callbackData, $callbackJson, $chatId, $messageId)
    {
        if (!isset($callbackJson['sid']) || !isset($callbackJson['uid']) || empty($chatId) || empty($messageId))
        {
            Log::error('TelegramBotController onCallbackSettings() error.');
            Log::error('CallbackQuery Error. Chat Id: ' . $chatId);
            Log::error('Error msg: empty website id. Callback Data: ' . $callbackData);
            Telegram::answerCallbackQuery([
                "callback_query_id" => $callbackQueryId,
                "text" => "Невозможно обработать это действие, повторите попытку или обратитесь в поддержку",
                "cache_time" => self::CALLBACK_CACHE_TIME
            ]);
            return;
        }

        $siteId = $callbackJson['sid'];
        $userId = $callbackJson['uid'];

        $this->sendSiteInfoInlineButtons($callbackQueryId, $callbackData, $callbackJson, $siteId, $userId, $chatId, $messageId);

        /*$site = Site::where([ 'id' => $siteId, 'user_id' => $userId, 'deleted' => false ])->first();

        if (empty($site))
        {
            Log::error('TelegramBotController onCallbackSettings() error.');
            Log::error('CallbackQuery Error. Chat Id: ' . $chatId . ' Message Id: ' . $messageId);
            Log::error('Error msg: not found website in database. Callback Data: ' . $callbackData);
            Telegram::answerCallbackQuery([
                "callback_query_id" => $callbackQueryId,
                "text" => "Невозможно обработать это действие, повторите попытку или обратитесь в поддержку",
                "cache_time" => self::CALLBACK_CACHE_TIME
            ]);
            return;
        }

        $buttons = array();
        foreach (self::CALLBACK_SETTINGS_ACTIONS as $action => $action_value)
        {
            if ($action == 'notifications')
            {
                $allEnabled = ($site->visits && $site->start_of_input &&
                    $site->form_submission && $site->clicks_on_phone &&
                    $site->clicks_on_whatsapp && $site->whatsapp_id);
                if ($allEnabled)
                {
                    $text = '❌ Остановить все оповещения';
                    $action_value['key'] = 'noff';
                }
                else
                {
                    $text = '✅ Запустить все оповещения';
                    $action_value['key'] = 'non';
                }
            }
            else if ($action == 'back_to_sites')
            {
                $text = '⬅ ' . $action_value['title'];
            }
            else
            {
                $text = ($site->$action ? '✅' : '❌') . ' ' . $action_value['title'];
            }
            array_push($buttons, array(
                Keyboard::button([
                    "text" => $text,
                    "callback_data" => json_encode(array(
                        "c" => $callbackJson['c'] . "_a", # Command
                        "a" => $action_value['key'], # Action
                        "sid" => $site->id,
                        "uid" => $site->user_id,
                    ))])
            ));
        }

        $replyMarkup = Keyboard::make([
            "inline_keyboard" => $buttons
        ]);

        Telegram::answerCallbackQuery([
            "callback_query_id" => $callbackQueryId,
            "cache_time" => self::CALLBACK_CACHE_TIME
        ]);

        Telegram::editMessageText([
            "chat_id" => $chatId,
            "message_id" => $messageId,
            "text" => "Настройки оповещений сайта - " . $site->url,
            "reply_markup" => $replyMarkup
        ]);*/
    }

    private function onCallbackSettingsAction($callbackQueryId, $callbackData, $callbackJson, $chatId, $messageId)
    {
        if (!isset($callbackJson['sid']) || !isset($callbackJson['uid']) || empty($chatId) || empty($messageId))
        {
            Log::error('TelegramBotController onCallbackSettingsAction() error.');
            Log::error('CallbackQuery Error. Chat Id: ' . $chatId . ' Message Id: ' . $messageId);
            Log::error('Error msg: empty website id. Callback Data: ' . $callbackData);
            Telegram::answerCallbackQuery([
                "callback_query_id" => $callbackQueryId,
                "text" => "Невозможно обработать это действие, повторите попытку или обратитесь в поддержку",
                "cache_time" => self::CALLBACK_CACHE_TIME
            ]);
            return;
        }

        $siteId = $callbackJson['sid'];
        $userId = $callbackJson['uid'];
        $action = $callbackJson['a'];
        $originalActionKey = $this->getActionKey($callbackJson['a']);

        switch($action)
        {
            case 'v': # Visits
            case 'soi': # Start of input
            case 'fs': # Fors submission
            case 'cop': # Clicks on phone links
            case 'cow': # Clicks on WhatsApp links
            case 'wi': # WhatsApp #Id
            case 'non': # Enabled all notifications
            case 'noff': # Disabled all notifications
                $this->sendSiteInfoInlineButtons($callbackQueryId, $callbackData, $callbackJson, $siteId, $userId, $chatId, $messageId, $originalActionKey, 'Настройки успешно обновлены');
                break;
            case 'del': # Delete site
                $this->onCallbackSettingsActionDelete($callbackQueryId, $callbackData, $siteId, $userId, $chatId, $messageId);
                break;
            case 'del_yes': # Delete confirmation site
                $this->onCallbackSettingsActionDeleteConfirm($callbackQueryId, $callbackData, $siteId, $userId, $chatId, $messageId);
                break;
            case 'del_no': # Cancel delete site
                $this->sendSiteInfoInlineButtons($callbackQueryId, $callbackData, $callbackJson, $siteId, $userId, $chatId, $messageId);
                break;
            case 'bts': # Back to sites list
                $this->onCallbackSettingsActionBackToSites($callbackQueryId, $userId, $chatId, $messageId);
                break;
        }
    }

    private function onCallbackSettingsActionDelete($callbackQueryId, $callbackData, $siteId, $userId, $chatId, $messageId)
    {
        if (empty($siteId))
        {
            Log::error('TelegramBotController onCallbackSettingsActionDelete() error.');
            Log::error('CallbackQuery Error. Chat Id: ' . $chatId . ' Message Id: ' . $messageId);
            Log::error('Error msg: empty website id. Callback Data: ' . $callbackData);
            Telegram::answerCallbackQuery([
                "callback_query_id" => $callbackQueryId,
                "text" => "Невозможно обработать это действие, повторите попытку или обратитесь в поддержку",
                "cache_time" => self::CALLBACK_CACHE_TIME
            ]);
            return;
        }

        $buttons = array(
            array(
                Keyboard::button([
                    "text" => "✅ Да",
                    "callback_data" => json_encode(array(
                        "c" => "st_a", # Command
                        "a" => 'del_yes', # Action
                        "sid" => $siteId,
                        "uid" => $userId,
                    ))])
            ),
            array(
                Keyboard::button([
                    "text" => "❌ Отмена",
                    "callback_data" => json_encode(array(
                        "c" => "st_a", # Command
                        "a" => 'del_no', # Action
                        "sid" => $siteId,
                        "uid" => $userId,
                    ))])
            )
        );

        $replyMarkup = Keyboard::make([
            "inline_keyboard" => $buttons
        ]);

        Telegram::answerCallbackQuery([
            "callback_query_id" => $callbackQueryId,
            "cache_time" => self::CALLBACK_CACHE_TIME
        ]);

        Telegram::editMessageText([
            "chat_id" => $chatId,
            "message_id" => $messageId,
            "text" => "Вы уверены?",
            "reply_markup" => $replyMarkup
        ]);
    }

    private function onCallbackSettingsActionDeleteConfirm($callbackQueryId, $callbackData, $siteId, $userId, $chatId, $messageId)
    {
        if (empty($siteId))
        {
            Log::error('TelegramBotController onCallbackSettingsActionDelete() error.');
            Log::error('CallbackQuery Error. Chat Id: ' . $chatId . ' Message Id: ' . $messageId);
            Log::error('Error msg: empty website id. Callback Data: ' . $callbackData);
            Telegram::answerCallbackQuery([
                "callback_query_id" => $callbackQueryId,
                "text" => "Невозможно обработать это действие, повторите попытку или обратитесь в поддержку",
                "cache_time" => self::CALLBACK_CACHE_TIME
            ]);
            return;
        }

        Site::where([ 'id' => $siteId, 'user_id' => $userId ])->update([ 'deleted' => true ]);

        $this->onCallbackSettingsActionBackToSites($callbackQueryId, $userId, $chatId, $messageId, 'Сайт успешно удалён');
    }

    private function onCallbackSettingsActionBackToSites($callbackQueryId, $userId, $chatId, $messageId, $answerCallbackMessage = null)
    {
        $answerCallbackData = array(
            "callback_query_id" => $callbackQueryId,
            "cache_time" => self::CALLBACK_CACHE_TIME
        );

        if (!empty($answerCallbackMessage))
            $answerCallbackData['text'] = $answerCallbackMessage;

        $sites = Site::where([ 'user_id' => $userId, 'deleted' => false ])->get();

        if (!count($sites))
        {
            Telegram::answerCallbackQuery($answerCallbackData);
            Telegram::editMessageText([
                "chat_id" => $chatId,
                "message_id" => $messageId,
                "text" => "Похоже вы удалили все свои сайты.\nДобавьте новый сайт с помощью команды - /code",
            ]);
            return;
        }

        $buttons = $sites->map(function (Site $site) {
            return [Keyboard::button([
                'text' => $site->url,
                'callback_data' => json_encode(array(
                    'c' => 'st', # Command => Settings
                    'sid' => $site->id,
                    'uid' => $site->user_id,
                ))
            ])];
        });

        $replyMarkup = Keyboard::make([
            "inline_keyboard" => $buttons
        ]);

        Telegram::answerCallbackQuery($answerCallbackData);

        Telegram::editMessageText([
            "chat_id" => $chatId,
            "message_id" => $messageId,
            "text" => 'Список сайтов',
            "reply_markup" => $replyMarkup
        ]);
    }

    private function sendSiteInfoInlineButtons($callbackQueryId, $callbackData, $callbackJson, $siteId, $userId, $chatId, $messageId, $updateField = null, $answerCallbackMessage = null)
    {
        $site = Site::where([ 'id' => $siteId, 'user_id' => $userId, 'deleted' => false ])->first();

        if (empty($site))
        {
            Log::error('TelegramBotController onCallbackSettings() error.');
            Log::error('CallbackQuery Error. Chat Id: ' . $chatId . ' Message Id: ' . $messageId);
            Log::error('Error msg: not found website in database. Callback Data: ' . $callbackData);
            Telegram::answerCallbackQuery([
                "callback_query_id" => $callbackQueryId,
                "text" => "Невозможно обработать это действие, повторите попытку или обратитесь в поддержку",
                "cache_time" => self::CALLBACK_CACHE_TIME
            ]);
            return;
        }

        # Обновляем поле, если нужно
        if (!empty($updateField))
        {
            try
            {
                if (strpos($updateField, 'notifications_') !== false)
                {
                    $fieldState = ($updateField == 'notifications_on');
                    $site->visits = $fieldState;
                    $site->start_of_input = $fieldState;
                    $site->form_submission = $fieldState;
                    $site->clicks_on_phone = $fieldState;
                    $site->clicks_on_whatsapp = $fieldState;
                    $site->whatsapp_id = $fieldState;
                }
                else
                {
                    $site->$updateField = !$site->$updateField;
                }
                $site->save();
            }
            catch (Exception $ex)
            {
                Log::error('TelegramBotController sendSiteInfoInlineButtons() error.');
                Log::error('Update website field error. Site: ' . $site->url . ' Field: ' . $updateField);
            }
        }
        $answerCallbackData = array(
            "callback_query_id" => $callbackQueryId,
            "cache_time" => self::CALLBACK_CACHE_TIME
        );

        if (!empty($answerCallbackMessage))
            $answerCallbackData['text'] = $answerCallbackMessage;

        $buttons = array();
        foreach (self::CALLBACK_SETTINGS_ACTIONS as $action => $action_value)
        {
            if ($action == 'notifications')
            {
                $allEnabled = ($site->visits && $site->start_of_input &&
                    $site->form_submission && $site->clicks_on_phone &&
                    $site->clicks_on_whatsapp && $site->whatsapp_id);
                if ($allEnabled)
                {
                    $text = '❌ Остановить все оповещения';
                    $action_value['key'] = 'noff';
                }
                else
                {
                    $text = '✅ Запустить все оповещения';
                    $action_value['key'] = 'non';
                }
            }
            else if ($action == 'back_to_sites')
            {
                $text = '⬅ ' . $action_value['title'];
            }
            else if ($action == 'delete')
            {
                $text = '🗑 ' . $action_value['title'];
            }
            else
            {
                $text = ($site->$action ? '✅' : '❌') . ' ' . $action_value['title'];
            }
            array_push($buttons, array(
                Keyboard::button([
                    "text" => $text,
                    "callback_data" => json_encode(array(
                        "c" => "st_a", # Command
                        "a" => $action_value['key'], # Action
                        "sid" => $site->id,
                        "uid" => $site->user_id,
                    ))])
            ));
        }

        $replyMarkup = Keyboard::make([
            "inline_keyboard" => $buttons
        ]);

        Telegram::answerCallbackQuery($answerCallbackData);

        Telegram::editMessageText([
            "chat_id" => $chatId,
            "message_id" => $messageId,
            "text" => "Настройки оповещений сайта - " . $site->url,
            "reply_markup" => $replyMarkup
        ]);
    }

    private function getActionKey($action_min_key)
    {
        if (($action_min_key == 'non') || ($action_min_key == 'noff'))
            return 'notifications_' . str_replace('no', 'o', $action_min_key);
        $result = '';
        foreach (self::CALLBACK_SETTINGS_ACTIONS as $action_key => $action) {
            if ($action['key'] == $action_min_key)
            {
                $result = $action_key;
                break;
            }
        }
        return $result;
    }
}