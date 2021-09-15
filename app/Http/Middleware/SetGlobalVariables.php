<?php

namespace App\Http\Middleware;

use Closure;

// use App\Auth\Authentication\Auth;
// use Illuminate\Support\Str;
use App\DBQueries\LoginInfo;

class SetGlobalVariables
{
    // public $user;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // if (!Str::contains($_SERVER['REQUEST_URI'], 'get_notification') )
        //     session()->regenerate(true);

        // $user = LoginInfo::get_remembered_user_device();
 
        // if ($user && !Authenticated())
        // {
        //     Auth::login($user->email);
        //     return redirect()->route('home');
        // }
        
        $GLOBALS['user'] = User();
        if ($GLOBALS['user'])
            $GLOBALS['login-info'] = LoginInfo::get_device($GLOBALS['user']->user_id);
        $GLOBALS['remembered-login-info'] = LoginInfo::get_remembered_user_device();

        return $next($request);
    }
}
