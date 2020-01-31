<?php

namespace App\Providers;

use App\User;
use App\WebsiteUser;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Auth::viaRequest('custom-broadcast', function (Request $request) {
            if($request->user('api')) return $request->user('api');
            if($request->headers->has('website_user_hash')) return WebsiteUser::where('session_hash', $request->headers->get('website_user_hash'))->first();
            return false;
        });

        Passport::routes();
    }
}
