<?php

namespace App\Http\Controllers;

use App\DBQueries\Asset;
use App\DBQueries\User;
use App\Auth\Gate\Gate;
use  App\Services\NotificationService;
use App\Services\CacheRememberService;

class BaseController
{
    use Gate, User, Asset, NotificationService, CacheRememberService;

    // public function __construct()
    // {
    //     $this->user = User(['user_id', 'name', 'role', 'email', 'image_name']);
    // }
}
