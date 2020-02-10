<?php

namespace App\Telegram\Bot\Commands;

use App\TelegramUser;
use Telegram\Bot\Actions;

class CodeCommand extends Command
{

    protected $name         = 'code';

    protected $description  = 'Получить код для установки на сайт';

    public function handle()
    {
        $this->replyWithChatAction([ 'action' => Actions::TYPING ]);

        # Создаём или получаем пользователя и обновляем его последнюю команду
        $this->getTelegramUserFromChat($this->name);

        return $this->replyWithMessage([
            'text' => 'Пожалуйста, пришлите ссылку на ваш сайт или страницу сайта.'
        ]);
    }
}