<?php

namespace App\Services;

use Illuminate\Support\Facades\File;
use App\DBQueries\LoginInfo;

trait UserService
{
    public function move_image_to_the_server_user($req)
    {
        $image_name = $GLOBALS['user']->image_name;
        if ($req->file('user_image')) 
        {
            $image_path = 'images/users/'.$GLOBALS['user']->image_name;
            if(File::exists(public_path($image_path)))
                File::delete($image_path);

            $image_name = time().file('user_image')->getClientOriginalName();
            $image_destination_path = public_path('images/users');
            $req->user_image->move($image_destination_path, $image_name);
        }
        return $image_name;
    }

    public function update_other_device_login_status($password)
    {  
        foreach (LoginInfo::get_other_user_login_sessions_device($GLOBALS['user']->user_id) as $item)
            if (cache($item->login_information_id.'-is-active') )
                cache()->forget($item->login_information_id.'-is-active');

        session()->put('authenticated_user_password', $password);
    }
}