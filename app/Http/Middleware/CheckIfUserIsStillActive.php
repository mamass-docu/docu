<?php

namespace App\Http\Middleware;

use Closure;

use App\DBQueries\LoginInfo;
use App\Auth\Authentication\Auth;

class CheckIfUserIsStillActive
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
        if (!$GLOBALS['remembered-login-info'] && !cache($GLOBALS['login-info']->login_information_id.'-is-active'))
        {
            Auth::logout();
            return redirect()->route('auth.login.view');
        }
   
        return $next($request);
    }
}
