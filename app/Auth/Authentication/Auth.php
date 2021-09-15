<?php

namespace App\Auth\Authentication;

use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;
use App\DBQueries\LoginInfo;
use App\AuthenticationTool\User as UserBrowser;
use App\DBQueries\Auth as AuthQuery;

class Auth
{
    public static function login($email, $remember = false)
    {
        $user = AuthQuery::first_user('`email` = "'. $email .'"', 'user_id, password');

        LoginInfo::save_device($user->user_id);
        
        self::saveUserToSession($user);
        
        cache()->forget(UserBrowser::getKey().'-failed-attempts');
        cache()->forget(UserBrowser::getKey().'-not-allowed');

        $GLOBALS['user'] = User();
        $GLOBALS['login-info'] = LoginInfo::get_device($GLOBALS['user']->user_id);
        $GLOBALS['remembered-login-info'] = LoginInfo::get_remembered_user_device();

        if($remember)
            self::saveRememberTokenToCookieAndDatabase();
    }

    public static function logout()
    {
        LoginInfo::set_user_remember_token_device(0);

        Cookie::queue('MAMASS_remember','', -1);
        
        session()->invalidate();
    }





    private static function saveRememberTokenToCookieAndDatabase()
    {
        $remember_token = self::generateRememberToken();

        Cookie::queue('MAMASS_remember',$remember_token, 60*24*365*4);

        LoginInfo::set_user_remember_token_device($remember_token);
    }

    private static function saveUserToSession($user)
    {
        cache()->put(LoginInfo::get_device($user->user_id, ['login_information_id'])->login_information_id.'-is-active', true, 15*60);
        session()->put('authenticated_user', $user->user_id);
        session()->put('authenticated_user_password', $user->password);
    }
    

    private static function generateRememberToken()
    {
        $generated_token = Str::random(rand(30,60));
        
        if(LoginInfo::first_device('remember_token', '=', $generated_token, ['user_id']))
            self::generateRememberToken();
        
        return $generated_token;
    }
}