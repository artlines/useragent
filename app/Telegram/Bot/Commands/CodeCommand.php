<?php

namespace App\Telegram\Bot\Commands;

use App\User;
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

        $chatId = $this->getChatFromUpdate()->getId();

        $user = User::whereName($chatId)->first();

        if (empty($user))
        {
            $msg = ($chatId < 0 ?
                    "Этот чат еще не зарегистрирован." :
                    "Вы еще не зарегистрированы.") . "\nПожалуйста, зарегистрируйтесь через команду - /start";
            return $this->replyWithMessage([
                "text" => $msg
            ]);
        }

        return $this->replyWithMessage([
            "text" => "Пожалуйста, пришлите ссылку на ваш сайт или страницу сайта."
        ]);
    }
}