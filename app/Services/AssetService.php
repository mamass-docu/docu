<?php

namespace App\Services;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

trait AssetService
{
    // public static function move_image_to_the_server($req, $store = true)
    // {
    //     if ($store)
    //     $image_name = $this->user->image_name;
    //     if ($req->file('asset_image')) 
    //     {
    //         $image_path = 'images/assets/'.$this->user->image_name;
    //         if(File::exists(public_path($image_path)))
    //             File::delete($image_path);

    //         $image_name = time().file('asset_image')->getClientOriginalName();
    //         $image_destination_path = public_path('images/assets');
    //         $req->user_image->move($image_destination_path, $image_name);
    //     }
    //     return $image_name;
    // }
    public function generate_qr_code_value()
    {
        $randValue = Str::random(15);
        if ($this->first_asset('asset_id', [], '`asset_id` = "'. $randValue.'"') )
            self::generate_qr_code_value();
    
        return $randValue;
    }
}