<?php

use Illuminate\Support\Facades\DB;

if(!function_exists('User'))
{
    function User($select = ['*'])
    {
        return DB::table('users')
            ->where('user_id', '=' ,session('authenticated_user') ?? '')
            ->select($select)
            ->first();
    }
}