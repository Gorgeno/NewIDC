<?php

namespace App\Http\Middleware;

use App;
use Closure;

class Lang
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
        // 首先判断用户有没有登录和设置语言，如果没有则采用cookie中储存的语言
        if (($user=$request->user()) && $user->lang) {
            App::setLocale($user->lang);
        } else {
            App::setLocale($request->cookie('language',config('app.locale')));
        }
        return $next($request);
    }
}
