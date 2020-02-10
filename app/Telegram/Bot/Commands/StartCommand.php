<?php

namespace App\Telegram\Bot\Commands;

use App\User;
use Telegram\Bot\Actions;

class StartCommand extends Command
{
    protected $name = 'start';

    protected $description = 'Запустить бота, авторизоваться';

    public function handle()
    {
        $this->replyWithChatAction([ 'action' => Actions::TYPING ]);

        # Создаём или получаем пользователя и обновляем его последнюю команду
        $this->getTelegramUserFromChat($this->name);

        $user = User::whereName($this->getChatFromUpdate()->getId())->first();

        if (empty($user))
        {
            $this->getUserFromChat();
            $this->replyWithMessage([
                "Добро пожаловать, {$this->getFullUserNameFromChat()}!\n"
            ]);
        }

        /*if (empty($user->phone))
        {
            return $this->sendVerifyPhoneMessage();
        }*/

        return $this->replyWithMessage([
            "text" => "Бот уже запущен, ваш ID {$user->id}.\nДля входа на сайт используйте команду /login\n\nДля получения справки по командам бота используйте команду /help",
            "parse_mode" => "markdown"
        ]);
    }



}