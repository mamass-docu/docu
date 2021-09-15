<?php

namespace App\Services;

trait NotificationService
{
    public function add_mis_id_in_list($user_id)
    {
        $data = cache('mis_office_personnel_id_lists') ?? [];
        if (!in_array($user_id, $data))  
        {
            $data = array_merge($data, [$user_id]);
            cache(['mis_office_personnel_id_lists' => $data], 60*60*24*365*4);
        }
    }

    public function create_or_reset_notif($user_id, $role)
    {
        $notif = [
            'admin' => [

            ],
            'employee' => [
                'job_request_progress' => [],
                'job_request_to_verify' => [],
            ],
            'mis_office_personnel' => [
                'new_job_request' => [],
                'verified_by_client' => [],
            ],
            'supply_office_personnel' => [

            ],
        ];
        
        cache([$user_id . '-notification' => $notif[$role] ], 60*60*24*365);

        return $notif[$role];
    }

    public function set_notif_for_new_job_request($job_id)
    {
        foreach (cache('mis_office_personnel_id_lists') ?? [] as $mis_id)
            self::set_notification('new_job_request', $job_id, $mis_id);
    }

    public function set_notification($key, $value, $user_id)
    {
        $data = cache($user_id . '-notification');
        
        if (!$data)
        {
            $user = $this->first_user('user_id, role', [], 'user_id = '.$user_id);
            
            if ($user)
                $data = $this->create_or_reset_notif($user->user_id, $user->role);
        }

        if (!in_array($value, $data[$key]) && $data)  
        {
            array_push($data[$key], $value);
            cache([$user_id . '-notification' => $data], 60*60*24*365);
        }
    }

    public function remove_user_from_lists($user_id)
    {
        $data = cache('mis_office_personnel_id_lists');
        if (in_array($user_id, $data))
        {
            unset($data[array_search($user_id, $data)]);

            cache(['mis_office_personnel_id_lists' => $data], 60*60*24*365);
        }
        cache()->forget($user_id . '-notification');
    }
}