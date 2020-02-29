<?php

namespace App\Telegram\Bot\Commands;

use App\Site;
use App\Telegram\Bot\Dialogs\ConfirmPhoneNumberDialog;
use Telegram\Bot\Actions;
use Telegram\Bot\Keyboard\Keyboard;

class SitesCommand extends Command
{

    protected $name = 'sites';

    protected $description = "Список сайтов";


    public function handle()
    {
        $this->replyWithChatAction([ 'action' => Actions::TYPING ]);

        # Создаём или получаем пользователя и обновляем его последнюю команду
        $telegramUser = $this->getTelegramUserFromChat($this->name);
        if (empty($telegramUser->owner_id))
        {
            return $this->replyWithMessage([
                "text" => "Пожалуйста, подтвердите ваш телефон!\nЗапустив команду - /start"
            ]);
        }

        $sites = $this->getUserFromChat()->sites;

        if (!count($sites))
        {
            return $this->replyWithMessage([
                'text' => 'Вы пока не добавили ни одного сайта'
            ]);
        }

        $buttons = $sites->map(function (Site $site){
            return [Keyboard::button([
                'text' => $site->url,
                'callback_data' => 'sites@' . $site->id
            ])];
        });

        $replyMarkup = Keyboard::make([
           'inline_keyboard' => $buttons
        ]);

        return $this->replyWithMessage([
            'text' => 'Список сайтов',
            'reply_markup' => $replyMarkup
        ]);
    }
}
