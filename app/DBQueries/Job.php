<?php

namespace App\DBQueries;

use Illuminate\Support\Facades\DB;
use DB as ODB;

trait Job
{
    private $job_joins = [
        ' INNER JOIN assets ON assets.asset_id = `serviceable_asset_id` ',
        ' INNER JOIN users ON users.user_id = client_id ',
        ' INNER JOIN users ON users.user_id = attending_mis_personnel_id ',
        ' INNER JOIN departments ON assets.deployed_office_id = departments.department_id ',
    ];

    public function store_job($req,$job_no)
    {   
        DB::table('jobs')
            ->insert(array_merge($this->job_input($req), ['job_no' => $job_no]));
            
        $this->forgetCache('jobs');
    }

    public function update_job($job_id, $req)
    {   
        DB::table('jobs')
            ->where('job_id','=', $job_id)
            ->update($this->job_input($req));
            
        $this->forgetCache('jobs');
    }

    public function update_job_progress($job_id, $update)
    {   
        DB::table('jobs')
            ->where('job_id','=', $job_id)
            ->update($update);
            
        $this->forgetCache('jobs');
    }

    public function destroy_job($job_id)
    {
        DB::table('jobs')
            ->where('job_id' ,'=', $job_id)
            ->delete();
            
        $this->forgetCache('jobs');
    }

    public function get_job($columns, $join = [], $where)
    {
        return cache()->remember('jobs-'.$columns.'-'.$where, 60*60*24*365*4, function() use ($columns, $join, $where) {
            $joinQuery = ' ';

            foreach ($join as $on)
                $joinQuery .= $this->job_joins[$on];

            $sql = 'SELECT '.$columns.' FROM `jobs`'. $joinQuery .' WHERE '.$where;

            return ODB::select($sql);
        });
    }

    public function first_job($columns, $join = [], $where)
    {
        info($where.'-'.$columns);
        $joinQuery = ' ';

        foreach ($join as $on)
            $joinQuery .= $this->job_joins[$on];

        $sql = 'SELECT '.$columns.' FROM `jobs`'. $joinQuery .' WHERE '.$where .' LIMIT 1';

        return ODB::select($sql) ? ODB::select($sql)[0] : null;
    }

    public function get_ordered($joinUser, $where, $columns)
    {
        $join = '';
        if ($joinUser)
            $join = 'INNER JOIN users ON users.user_id = '. $joinUser;
       
        return ODB::select('SELECT '.$columns.' FROM `jobs` 
            INNER JOIN assets ON assets.asset_id = `serviceable_asset_id` '. $join .'
            INNER JOIN departments ON assets.deployed_office_id = departments.department_id
            WHERE '.$where.' ORDER BY date(`request_date`), `request_time` ASC');
    }

    public function get_selected_job($job_id)
    {
        $sql = 'SELECT jobs.*, name FROM `jobs` 
            INNER JOIN users ON users.user_id = client_id
            WHERE `job_id` = ' . $job_id[0];

        for ($i = 1; $i< count($job_id); $i++)
            $sql .= ' OR `job_id` = ' . $job_id[$i];

        return ODB::select($sql);
    }

    public function update_selected_job($req)
    {
        foreach ($req->job_id as $i => $id)
        {
            DB::table('jobs')
                ->where('job_id','=', $id)
                ->update([
                    'serviceable_asset_id' => $req->serviceable_asset_id[$i],
                    'client_id' => $this->first_user('user_id', [], 'name = "'.$req->name[$i].'"')->user_id,
                    'service_type' => $req->service_type[$i],
                    'request_date' => $req->request_date[$i],
                    'request_time' => $req->request_time[$i],
                    'client_contact_no' => $req->client_contact_no[$i],
                    'client_request_problem' => $req->client_request_problem[$i],
                ]);
        }
            
        $this->forgetCache('jobs');
    }

    public function destroy_selected_job($job_id)
    {
        $sql = 'DELETE FROM `jobs` WHERE `job_id` = ' . $job_id[0];
        for ($i = 1; $i< count($job_id); $i++)
            $sql .= ' OR `job_id` = ' . $job_id[$i];

        ODB::delete($sql);
            
        $this->forgetCache('jobs');
    }

    public function get_job_no($startLetter)
    {
        $max = ODB::select('SELECT MAX(`job_no`) as job_no FROM `jobs` WHERE `job_no` LIKE "'.$startLetter.'%"');
info($max);
        return $max ? $max[0] : null;
    }

    private function job_input($req)
    {
        return [
            'serviceable_asset_id' => $req->serviceable_asset_id,
            'client_id' => $GLOBALS['user']->role == 'admin' 
                ? $this->first_user('user_id', [], 'name = "'.$req->name.'"')->user_id
                : $GLOBALS['user']->user_id,
            'service_type' => $req->service_type,
            'request_date' => $GLOBALS['user']->role == 'admin' ? $req->request_date : date('Y-m-d'),
            'request_time' => $GLOBALS['user']->role == 'admin' ? $req->request_time : date('h:i:s'),
            'client_contact_no' => $req->client_contact_no,
            'client_request_problem' => $req->client_request_problem,
        ];
    }
}