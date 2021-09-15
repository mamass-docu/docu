<?php

namespace App\Services;

trait CacheRememberService
{
    public function forgetCache($forget)
    {
        $cache_remembered_list = [
            'users' => [   
                'users-name-`role` != "admin"',
                'users-name-`role` != "admin" AND `role` != "mis_office_personnel"',
                'users-user_id, name, role, image_name, department_name-`role` != "admin"',
                'users-user_id, name-`role` = "mis_office_personnel"',
                'assets-assets.*, name, departments.*-1',
                'jobs-jobs.*, name-1',
            ],
            'assets' => [
                'assets-asset_id-1',
                'assets-assets.*, name, departments.*-1',
                'jobs-jobs.*, name-1',
            ],
            'jobs' => [
                'jobs-jobs.*, name-1',
            ],
            'departments' => [
                'departments-*-1',
                'users-user_id, name, role, image_name, department_name-`role` != "admin"',
                'assets-assets.*, name, departments.*-1',
                'jobs-jobs.*, name-1',
            ],
        ];

        foreach ($cache_remembered_list[$forget] as $key)
            cache()->forget($key);
    }
}