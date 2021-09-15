<?php

namespace App\AuthenticationTool;

use Illuminate\Support\Str;

class User
{
    public static function browser()
    {
        $user_agent =Str::lower($_SERVER['HTTP_USER_AGENT']);

        return Str::contains($user_agent, 'edg') 
            ? 'Microsoft Edge'
            : (Str::contains($user_agent, 'fire') 
            ? 'Mozila Firefox'
            : (Str::contains($user_agent, 'opr')
            ?'Opera Mini'
            : (Str::contains($user_agent, 'chrom')
            ? 'Google Chrome'
            : 'Internet Explorer' )));
    }   

    public static function device()
    {
        $user_agent =Str::lower($_SERVER['HTTP_USER_AGENT']);

        return (Str::contains($user_agent, 'android') || Str::contains($user_agent, 'mobile') )
            ? 'Mobile'
            : 'Desktop';
    }

    public static function ip()
    {
        return $_SERVER['REMOTE_ADDR'];
    }

    public static function getKey()
    {
        return self::ip().'-'.self::device().'-'.self::browser();
    }
}