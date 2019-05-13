<?php

namespace App\Observers;

use Telegram;
use App\Tguser;

class TelegramUserObserver
{

    private const ADMIN_CHAT_ID = '2550885'; //Rushan chat bot id

    /**
     * Handle the telegram user "created" event.
     *
     * @param  \App\Tguser $telegramUser
     * @return void
     */
    public function created(Tguser $telegramUser)
    {
        $sm = [
            'chat_id' => self::ADMIN_CHAT_ID,
            'text' => "Регистрация нового пользователя: \n" . implode("\n", $telegramUser->toArray()),
        ];

        Telegram::sendMessage($sm);
    }

    /**
     * Handle the telegram user "updated" event.
     *
     * @param  \App\Tguser $telegramUser
     * @return void
     */
    public function updated(Tguser $telegramUser)
    {
        //
    }

    /**
     * Handle the telegram user "deleted" event.
     *
     * @param  \App\Tguser $telegramUser
     * @return void
     */
    public function deleted(Tguser $telegramUser)
    {
        //
    }

    /**
     * Handle the telegram user "restored" event.
     *
     * @param  \App\Tguser $telegramUser
     * @return void
     */
    public function restored(Tguser $telegramUser)
    {
        //
    }

    /**
     * Handle the telegram user "force deleted" event.
     *
     * @param  \App\Tguser $telegramUser
     * @return void
     */
    public function forceDeleted(Tguser $telegramUser)
    {
        //
    }
}
