<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\NotificationService;
use DB;

class NotificationController
{
    use NotificationService;
    
    function get_count()
    {
        return response()->json(cache($GLOBALS['user']->user_id . '-notification'));
    }

    function get_notif()
    {
        // $data = $req->input('data');
        $data = cache($GLOBALS['user']->user_id . '-notification');

        $this->create_or_reset_notif($GLOBALS['user']->user_id, $GLOBALS['user']->role);
        
        if ($GLOBALS['user']->role == 'admin')
        {
            return response()->json($this->get_job(true, 
                array_merge($data['new_job_request'], $data['verified_by_client'])
            ));
        }
        else if ($GLOBALS['user']->role == 'mis_office_personnel')
        {
            return response()->json($this->get_job(true, 
                array_merge($data['new_job_request'], $data['verified_by_client'])
            ));
        }
        else if ($GLOBALS['user']->role == 'employee')
        {
            return response()->json($this->get_job(false, 
                array_merge($data['job_request_progress'], $data['job_request_to_verify'])
            ));
        }
        else
        {
            return response()->json($this->get_job(true, 
                array_merge($data['new_job_request'], $data['verified_by_client'])
            ));
        }
    }

    function get_admin_notif(Request $req)
    {
        $jobs = array_merge($req->input('data')['new_job_request'], $req->input('data')['verified_by_client']);
            
        return response()->json(
            $this->get_job(true, $jobs)
        );
    }

    function get_employee_notif(Request $req)
    {
        $jobs = array_merge($req->input('data')['new_job_request'], $req->input('data')['verified_by_client']);
            
        return response()->json(
            $this->get_job(true, $jobs)
        );
    }

    function get_supply_notif(Request $req)
    {
        $jobs = array_merge($req->input('data')['new_job_request'], $req->input('data')['verified_by_client']);
            
        return response()->json(
            $this->get_job(true, $jobs)
        );
    }

    function get_job($client, $jobs)
    {
        $user = $client ? 'client_id' : 'attending_mis_personnel_id';
        $cond = 'job_id = '.$jobs[0];

        for ($i = 1; $i < count($jobs); $i++)
            $cond .= ' OR job_id = '.$jobs[$i];

        $sql = 'SELECT job_id, asset_name, name, priority FROM `jobs`
            INNER JOIN assets ON assets.asset_id = `serviceable_asset_id`
            INNER JOIN users ON users.user_id = '. $user .'
            INNER JOIN departments ON assets.deployed_office_id = departments.department_id
            WHERE '.$cond;
            
        return DB::select($sql);
    }
}
