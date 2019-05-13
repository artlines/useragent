<?php

namespace App\Providers;

use App\Observers\TelegramUserObserver;
use App\Tguser;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Tguser::observe(TelegramUserObserver::class);
    }
}
