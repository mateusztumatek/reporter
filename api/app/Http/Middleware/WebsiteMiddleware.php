<?php

namespace App\Http\Middleware;

use App\Website;
use Closure;

class WebsiteMiddleware
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
        if($request->hasHeader('website_hash')){
            $website = Website::where('hash', $request->header('website_hash'))->first();
            $request->request->set('website', $website);
        }
        return $next($request);
    }
}
