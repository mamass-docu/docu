<?php

namespace App\Auth\Gate;

use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use App\Auth\Permission;

trait Gate
{
    public function allow($permission, $user_id = null)
    {
        $permission = Str::of($permission)->explode(' ');

        if ($user_id)
            return $GLOBALS['user']->user_id == $user_id;

        if (!Arr::has(Permission::lists, $GLOBALS['user']->role) || 
            !Arr::has(Permission::lists, $GLOBALS['user']->role.'.'.$permission[1]) )
            return false;
         
        if (Arr::has(Permission::lists, $GLOBALS['user']->role.'.'.$permission[1].'.*') )
            return !in_array($permission[0], Permission::lists[$GLOBALS['user']->role][$permission[1]]['*']);
        
        if (in_array('*', Permission::lists[$GLOBALS['user']->role][$permission[1]]) || 
            in_array($permission[0], Permission::lists[$GLOBALS['user']->role][$permission[1]]) )
            return true;

        return false;
    }
}