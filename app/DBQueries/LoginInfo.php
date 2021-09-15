<?php

namespace App\DBQueries;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cookie;
use App\AuthenticationTool\User;

class LoginInfo
{
    public static function get_device($user_id, $columns = ['*'])
    {
        return DB::table('login_informations')
            ->where('user_id' ,'=', $user_id)
            ->where('ip_address', '=', User::ip())
            ->where('device', '=', User::device())
            ->where('browser', '=', User::browser())
            ->select($columns)
            ->first();
    }
    
    public static function first_device($column, $operator, $value, $columns = ['login_informations.*'])
    {
        return DB::table('login_informations')
            ->where($column, $operator, $value)
            ->select($columns)
            ->first();
    }

    public static function get_other_user_login_sessions_device($user_id)
    {
        return DB::table('login_informations')
            ->where('login_information_id', '!=', self::get_device($user_id, ['login_information_id'])->login_information_id)
            ->where('user_id' ,'=', $user_id)
            ->get();
    }

    public static function save_device($user_id)
    {
        if (!self::get_device($user_id, ['login_information_id']))
            DB::table('login_informations')
            ->insert([
                'user_id' => $user_id,
                'remember_token' => 0,
                'ip_address' => User::ip(),
                'device' => User::device(),
                'browser' => User::browser(),
                'last_active_at' => now()
            ]);
    } 

    public static function set_last_active_at_device()
    {
        DB::table('login_informations')
            ->where('login_information_id', '=', $GLOBALS['login-info']->login_information_id ?? '')
            ->update([
                'last_active_at' => now()
            ]);
    }

    public static function destroy_device($id, $delete_by_user_id = true)
    {
        $delete_by_user_id
            ? DB::table('login_informations')
                ->where('user_id' ,'=', $id)
                ->delete()
            : DB::table('login_informations')
                ->where('login_information_id' ,'=', $id)
                ->delete();
    }

    public static function reset_other_user_remember_token_device($user_id)
    {
        DB::table('login_informations')
            ->where('login_information_id', '!=', self::get_device($user_id, ['login_information_id'])->login_information_id)
            ->where('user_id' ,'=', $user_id)
            ->update([
                'remember_token' => 0,
            ]);
    }

    public static function set_user_remember_token_device($token)
    {
        DB::table('login_informations')
            ->where('login_information_id', '=', $GLOBALS['login-info']->login_information_id)
            ->update([
                'remember_token' => $token,
            ]);
    }

    public static function get_remembered_user_device()
    {
        return DB::table('login_informations')
            ->join('users', 'login_informations.user_id', '=', 'users.user_id')
            ->where('remember_token', '=', Cookie::get('MAMASS_remember') ?? '')
            ->select('email', 'users.user_id')
            ->first();
    }
}