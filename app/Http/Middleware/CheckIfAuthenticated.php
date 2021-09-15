<?php

namespace App\Http\Middleware;

use Closure;

use App\DBQueries\LoginInfo;
use App\Auth\Authentication\Auth;

class CheckIfAuthenticated
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
        if(!Authenticated())
        {
            $user = $GLOBALS['remembered-login-info'];
 
            if ($user)
            {
                Auth::login($user->email);
                return redirect()->route('home');
            }
            return redirect()->route('auth.login.view');
        }

        return $next($request);
    }
}
