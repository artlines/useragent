<?php


namespace App\Telegram\Bot\Commands;

use App\TelegramUser;
use App\User;
use Cache;
use Telegram;
use Telegram\Bot\Commands\Command as BaseCommand;
use Telegram\Bot\Keyboard\Keyboard;


abstract class Command extends BaseCommand
{
    /**
     * Get or create TelegramUser model from chat
     *
     * @param string|null $command - Название последней команды
     * @return TelegramUser
     */
    protected function getTelegramUserFromChat($command = null)
    {

        $chat = $this->getChatFromUpdate();

        $telegramUser = TelegramUser::firstOrNew([
            'chat_id' => $chat->getId(),
        ]);

        if (empty($command))
            $command = '';

        if (!$telegramUser->id) {
            $telegramUser = $telegramUser->fill([
                'first_name' => $chat->getFirstName(),
                'last_name' => $chat->getLastName(),
                'user_name' => $chat->getUserName(),
                'last_command' => $command
            ]);

            $telegramUser->save();
        }
        else if (!empty($command))
        {
            $telegramUser->fill([ 'last_command' => $command ]);
            $telegramUser->save();
        }

        return $telegramUser;
    }

    /**
     * Get or create user model from chat
     *
     * @return User|\Illuminate\Database\Eloquent\Model
     */
    protected function getUserFromChat()
    {
        return User::firstOrCreate([
            'name' => $this->getChatFromUpdate()->getId()
        ]);
    }


    /**
     * Get chat object from update
     *
     * @return \Illuminate\Support\Collection|\Telegram\Bot\Objects\Chat
     */
    protected function getChatFromUpdate()
    {
        return $this->getUpdate()->getChat();
    }


    /**
     * Get full username
     *
     * @return string
     */
    protected function getFullUserNameFromChat()
    {
        $update = $this->getChatFromUpdate();

        return trim(
            $update->getFirstName() . " " .  $update->getLastName()
        );
    }


    /**
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    protected function sendVerifyPhoneMessage()
    {
        $requestPhoneButton = Keyboard::button([
            'text' => 'Подтвердить номер телефона',
            'request_contact' => true,
        ]);


        $response = $this->replyWithMessage([
           "text" => "Для работы с сервисом, необходимо подтвердить номер телефона.\n\nЭто нужно для того что бы мы могли отсеять спам аккаунты.",
            "reply_markup" => Keyboard::make([
                "keyboard" => [[$requestPhoneButton]],
                "one_time_keyboard" => true,
                "resize_keyboard" => true
            ])
        ]);

        if ($response instanceof Telegram\Bot\Objects\Message) {
            Cache::set(
                "tg.phone_verify.{$this->getChatFromUpdate()->getId()}",
                $response->messageId
            );
        }

    }

}