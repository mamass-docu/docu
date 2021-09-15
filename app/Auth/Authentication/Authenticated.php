<?php

use App\DBQueries\LoginInfo;

if(!function_exists('Authenticated'))
{
    function Authenticated()
    {
        // $user = User(['user_id', 'password']);
        
        if($GLOBALS['user'])
        {
            if ($GLOBALS['login-info']->user_id && 
                session('authenticated_user_password') == $GLOBALS['user']->password)
                return true;
        }
        
        return false;
    }   
}
