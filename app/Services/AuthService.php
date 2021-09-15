<?php

namespace App\Services;

use Illuminate\Support\Facades\File;
use App\AuthenticationTool\User;

class AuthService
{
    public static function proccessFailedAttempts()
    {  
        $key = User::getKey().'-not-allowed';
        $failed_attempts = self::getFailedAttempts();

        $failed_attempts % 25 == 0
            ? cache()->put($key, now()->addYears(1), now()->addYears(1))
            : ($failed_attempts % 20 == 0
            ? cache()->put($key, now()->addMonths(1), now()->addMonths(1))
            : ($failed_attempts % 15 == 0
            ? cache()->put($key, now()->addDays(1), now()->addDays(1))
            : ($failed_attempts % 10 == 0
            ? cache()->put($key, now()->addMinutes(30), now()->addMinutes(30))
            : ($failed_attempts % 5 == 0
            ? cache()->put($key, now()->addMinutes(2), now()->addMinutes(2))
            : 1))));
    }

    public static function incrementFailedAttempt()
    {
        self::getFailedAttempts()
            ? cache()->put(User::getKey().'-failed-attempts', self::getFailedAttempts() + 1, 365*24*60*60)
            : cache()->put(User::getKey().'-failed-attempts',1,  365*24*60*60);
    }

    public static function getFailedAttempts()
    {
        return cache(User::getKey().'-failed-attempts');
    }

    public static function getNotAllowedAttempts()
    {
        return cache(User::getKey().'-not-allowed');
    }
}