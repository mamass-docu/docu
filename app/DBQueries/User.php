<?php

namespace App\DBQueries;

use Illuminate\Support\Facades\DB;
use DB as ODB;

trait User
{
    private $user_joins = [
        'INNER JOIN departments ON departments.department_id = users.department_id'
    ];

    public function store_user($req)
    {
        
        $this->forgetCache('users');
    }

    public function update_user($req, $user_id, $image_name)
    {   
        DB::table('users')
            ->where('user_id','=', $user_id)
            ->update([
                'name' => $req->name,
                'email' => $req->email,
                'image_name' => $image_name,
            ]);
            
        $this->forgetCache('users');
    }

    public function update_user_password($password)
    {
        DB::table('users')
            ->where('user_id','=', $GLOBALS['user']->user_id)
            ->update([
                'password' => $password
            ]);
            
        $this->forgetCache('users');
    }

    public function destroy_user($user_id)
    {
        DB::table('users')
            ->where('user_id' ,'=', $user_id)
            ->delete();
            
        $this->forgetCache('users');
    }

    public function get_user($columns, $join = [], $where)
    {
        return cache()->remember('users-'.$columns.'-'.$where, 60*60*24*365*4, function() use ($columns, $join, $where) {
            $joinQuery = '';

            foreach ($join as $on)
                $joinQuery .= $this->user_joins[$on];

            $sql = 'SELECT '.$columns.' FROM `users`'. $joinQuery .' WHERE '.$where;

            return ODB::select($sql);
        });
    }

    public function first_user($columns, $join = [], $where)
    {
        $joinQuery = ' ';

        foreach ($join as $on)
            $joinQuery .= $this->user_joins[$on];

        $sql = 'SELECT '.$columns.' FROM `users`'. $joinQuery .' WHERE '.$where .' LIMIT 1';

        return ODB::select($sql) ? ODB::select($sql)[0] : null;
    }

    public function get_selected_user($user_id)
    {
        $sql = 'SELECT `user_id`, `name`, `role`, `image_name`, `email`, users.department_id, `department_name` FROM `users` INNER JOIN departments ON users.department_id = departments.department_id WHERE `user_id` = ' . $user_id[0];
        for ($i = 1; $i< count($user_id); $i++)
            $sql .= ' OR `user_id` = ' . $user_id[$i];

        return ODB::select($sql);
    }

    public function update_selected_user($req)
    {
        foreach ($req->user_id as $i => $id)
        {
            // $image_name = $this->move_image_to_the_server_user($req);

            DB::table('users')
                ->where('user_id','=', $id)
                ->update([
                    'name' => $req->name[$i],
                    'role' => $req->role[$i],
                    'department_id' => $this->first_department('department_id', '`department_name` = "'.$req->department_name[$i].'"')->department_id,
                    // 'image_name' => $image_name,
                ]);
        }
            
        $this->forgetCache('users');
    }

    public function destroy_selected_user($user_id)
    {
        $sql = 'DELETE FROM `users` WHERE `user_id` = ' . $user_id[0];
        for ($i = 1; $i< count($user_id); $i++)
            $sql .= ' OR `user_id` = ' . $user_id[$i];

        ODB::delete($sql);
            
        $this->forgetCache('users');
    }
}