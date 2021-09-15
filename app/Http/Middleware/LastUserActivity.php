<?php

namespace App\Http\Middleware;

use Closure;

use App\DBQueries\LoginInfo;

class LastUserActivity
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
        // LoginInfo::set_last_active_at_device();

        if (!$GLOBALS['remembered-login-info'])
            cache()->put($GLOBALS['login-info']->login_information_id.'-is-active', true, now()->addMinutes(15));

        return $next($request);
    }
}
