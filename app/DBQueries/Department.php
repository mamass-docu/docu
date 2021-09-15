<?php

namespace App\DBQueries;

use Illuminate\Support\Facades\DB;
use DB as ODB;

trait Department
{
    public function store_department($req)
    {  
        DB::table('departments')
            ->insert([
                'department_name' => $req->department_name,
                'priority' => $req->priority,
            ]);
            
        $this->forgetCache('departments');   
    }

    public function update_department($req, $department_id)
    {   
        DB::table('departments')
            ->where('department_id','=', $department_id)
            ->update([
                'department_name' => $req->department_name,
                'priority' => $req->priority,
            ]);
            
        $this->forgetCache('departments');   
    }

    public function destroy_department($department_id)
    {
        DB::table('departments')
            ->where('department_id' ,'=', $department_id)
            ->delete();
            
        $this->forgetCache('departments');   
    }

    public function get_department($columns, $where)
    {
        return cache()->remember('departments-'.$columns.'-'.$where, 60*60*24*365*4, function() use ($columns, $where) {
            $sql = 'SELECT '.$columns.' FROM `departments` WHERE '.$where;

            return ODB::select($sql);
        });
    }

    public function first_department($columns, $where)
    {
        $sql = 'SELECT '.$columns.' FROM `departments` WHERE '.$where.' LIMIT 1';

        return ODB::select($sql) ? ODB::select($sql)[0] : null;
    }

    public function get_selected_department($department_id)
    {
        $sql = 'SELECT * FROM `departments` WHERE `department_id` = ' . $department_id[0];
        for ($i = 1; $i< count($department_id); $i++)
            $sql .= ' OR `department_id` = ' . $department_id[$i];

        return ODB::select($sql);
    }

    public function update_selected_department($req)
    {
        foreach ($req->department_id as $i => $id)
        {
            DB::table('departments')
                ->where('department_id','=', $id)
                ->update([
                    'department_name' => $req->department_name[$i],
                    'priority' => $req->priority[$i],
                ]);
        }
            
        $this->forgetCache('departments');
    }

    public function destroy_selected_department($department_id)
    {
        $sql = 'DELETE FROM `departments` WHERE `department_id` = ' . $department_id[0];
        for ($i = 1; $i< count($department_id); $i++)
            $sql .= ' OR `department_id` = ' . $department_id[$i];

        ODB::delete($sql);
            
        $this->forgetCache('departments');
    }
}