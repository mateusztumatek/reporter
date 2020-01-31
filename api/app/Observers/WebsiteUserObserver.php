<?php

namespace App\Observers;

use App\Chat;
use App\WebsiteUser;
use Illuminate\Support\Str;

class WebsiteUserObserver
{
    /**
     * Handle the website user "created" event.
     *
     * @param  \App\WebsiteUser  $websiteUser
     * @return void
     */
    public function created(WebsiteUser $websiteUser)
    {
        Chat::create([
            'website_id' => $websiteUser->website_id,
            'website_user_id' => $websiteUser->id,
            'hash' => md5(Str::random(60))
        ]);
    }

    /**
     * Handle the website user "updated" event.
     *
     * @param  \App\WebsiteUser  $websiteUser
     * @return void
     */
    public function updated(WebsiteUser $websiteUser)
    {
        //
    }

    /**
     * Handle the website user "deleted" event.
     *
     * @param  \App\WebsiteUser  $websiteUser
     * @return void
     */
    public function deleted(WebsiteUser $websiteUser)
    {
        //
    }

    /**
     * Handle the website user "restored" event.
     *
     * @param  \App\WebsiteUser  $websiteUser
     * @return void
     */
    public function restored(WebsiteUser $websiteUser)
    {
        //
    }

    /**
     * Handle the website user "force deleted" event.
     *
     * @param  \App\WebsiteUser  $websiteUser
     * @return void
     */
    public function forceDeleted(WebsiteUser $websiteUser)
    {
        //
    }
}
