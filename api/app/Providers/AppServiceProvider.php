<?php

namespace App\Providers;

use App\ChatMessage;
use App\Observers\ChatMessageObserver;
use App\Observers\WebsiteUserObserver;
use App\WebsiteUser;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
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
        Schema::defaultStringLength(191);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Carbon::setLocale('pl');
        WebsiteUser::observe(WebsiteUserObserver::class);
        ChatMessage::observe(ChatMessageObserver::class);
    }
}
