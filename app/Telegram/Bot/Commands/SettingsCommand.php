<?php


namespace App\Telegram\Bot\Commands;

use App\Site;
use App\Telegram\Bot\Dialogs\ConfirmPhoneNumberDialog;
use Telegram\Bot\Actions;
use Telegram\Bot\Keyboard\Keyboard;

class SettingsCommand extends Command
{
    /**
     * @var string Command Name
     */
    protected $name = 'settings';

    /**
     * @var string Command Description
     */
    protected $description = 'Настройки оповещений';

    /**
     * {@inheritdoc}
     */
    public function handle()
    {
        $this->replyWithChatAction([ 'action' => Actions::TYPING ]);

        # Создаём или получаем пользователя и обновляем его последнюю команду
        $this->getTelegramUserFromChat($this->name);
        $sites = $this->getUserFromChat()->sites;

        if (!count($sites))
        {
            return $this->replyWithMessage([
                'text' => 'Вы пока не добавили ни одного сайта'
            ]);
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
            'inline_keyboard' => $buttons
        ]);

        return $this->replyWithMessage([
            'text' => 'Список сайтов',
            'reply_markup' => $replyMarkup
        ]);
    }
}