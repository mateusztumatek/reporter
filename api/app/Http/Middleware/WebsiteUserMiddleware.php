<?php

namespace App\Http\Middleware;

use App\WebsiteUser;
use Carbon\Carbon;
use Closure;
use Illuminate\Support\Facades\Cache;
class WebsiteUserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($request->header('website_user_hash')){
            $website_user = WebsiteUser::where('session_hash', $request->header('website_user_hash'))->first();
            if($website_user){
                $request->request->set('website_user', $website_user);
                Cache::put('user_online'.$website_user->id, 1, Carbon::now()->addMinutes(3));
            }else{
                WebsiteUser::createUser($request);
            }
        }else{
            WebsiteUser::createUser($request);
        }
        return $next($request);
    }
}
