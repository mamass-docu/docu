<?php

namespace App\DBQueries;

use DB;

class Auth
{
    public static function first_user($cond, $columns)
    {
        $result = DB::select('SELECT ' . $columns . ' FROM `users` WHERE ' . $cond .' LIMIT 1');
        
        return $result ? $result[0] : null;
    }
}