<?php

namespace App\DBQueries;

use Illuminate\Support\Facades\DB;
use DB as ODB;
// use App\Services\UserServices;

trait Asset
{
    private $asset_joins = [
        ' INNER JOIN departments ON departments.department_id = deployed_office_id ',
        ' INNER JOIN users ON person_in_charge_id = users.user_id ',
    ];

    public function store_asset($req)
    {
        DB::table('assets')
            ->insert($this->user_input($req));

        $this->forgetCache('assets');
    }

    public function update_asset($req, $asset_id)
    {  
        DB::table('assets')
            ->where('asset_id', $asset_id)
            ->update($this->user_input($req));
            
        $this->forgetCache('assets');
    }

    public function destroy_asset($asset_id)
    {
        DB::table('assets')
            ->where('asset_id' ,'=', $asset_id)
            ->delete();
            
        $this->forgetCache('assets');
    }

    public function get_asset($columns, $join = [], $where)
    {
        return cache()->remember('assets-'.$columns.'-'.$where, 60*60*24*365*4, function() use ($columns, $join, $where) {
            $joinQuery = '';
            foreach ($join as $on)
                $joinQuery .= $this->asset_joins[$on];

            $sql = 'SELECT '.$columns.' FROM `assets`'. $joinQuery .' WHERE '.$where;

            return ODB::select($sql);
        });
    }

    public function first_asset($columns, $join = [], $where)
    {
        $joinQuery = '';

        foreach ($join as $on)
            $joinQuery .= $this->asset_joins[$on];

        $sql = 'SELECT '.$columns.' FROM `assets` '. $joinQuery .' WHERE '.$where. ' LIMIT 1';

        return ODB::select($sql) ? ODB::select($sql)[0] : null;
    }

    public function get_selected_asset($asset_id)
    {
        $sql = 'SELECT assets.*, users.user_id, departments.*, users.name FROM `assets` 
            INNER JOIN users ON users.user_id = assets.person_in_charge_id
            INNER JOIN departments ON assets.deployed_office_id = departments.department_id
            WHERE `asset_id` = "' . $asset_id[0] .'"';
        for ($i = 1; $i< count($asset_id); $i++)
            $sql .= ' OR `asset_id` = "' . $asset_id[$i] .'"';
        
        return ODB::select($sql);
    }

    public function update_selected_asset($req)
    {
        $ict = 0;
        $com = 0;

        foreach ($req->asset_id as $i => $id)
        {
            // $image_name = $this->move_image_to_the_server_user($req);

            $update = [
                'asset_name' => $req->asset_name[$i],
                'person_in_charge_id' => $this->first_user('user_id', [], 'name = "'.$req->name[$i].'"')->user_id,
                'deployed_office_id' => $this->first_department('department_id', 'department_name = "'.$req->department_name[$i].'"')->department_id,
                'serviceable' => $req->serviceable[$i],
                'asset_image_name' => 'a.jpg',
                'precurement_date' => $req->precurement_date[$i],
            ];

            if ($req->type[$i] == 'ICT')
            {
                $update = array_merge($update, [
                    'brand' => $req->brand[$ict],
                    'model' => $req->model[$ict],
                ]);
                $ict++;
            }
            else 
            {
                $update = array_merge($update, [
                    'processor' => $req->processor[$com],
                    'memory' => $req->memory[$com],
                    'video_card' => $req->video_card[$com],
                    'lan_card' => $req->lan_card[$com],
                    'sound_card' => $req->sound_card[$com],
                    'hard_drive' => $req->hard_drive[$com],
                    'optical_drive' => $req->optical_drive[$com],
                    'monitor' => $req->monitor[$com],
                    'mouse' => $req->mouse[$com],
                    'keyboard' => $req->keyboard[$com],
                    'avr' => $req->avr[$com],
                ]);
                $com++;
            }
            
            DB::table('assets')
            ->where('asset_id', $id)
            ->update($update);
        }
            
        $this->forgetCache('assets');
    }

    public function destroy_selected_asset($asset_id)
    {
        $sql = 'DELETE FROM `assets` WHERE `asset_id` = ' . $asset_id[0];
        for ($i = 1; $i< count($asset_id); $i++)
            $sql .= ' OR `asset_id` = "' . $asset_id[$i].'"';

        ODB::delete($sql);
            
        $this->forgetCache('assets');
    }

    private function user_input($req)
    {
        return [
            'asset_id' => $req->asset_id,
            'asset_name' => $req->asset_name,
            'person_in_charge_id' => $this->first_user('user_id', [], 'name = "'.$req->name.'"')->user_id,
            'deployed_office_id' => $this->first_department('department_id', 'department_name = "'.$req->department_name.'"')->department_id,
            'brand' => $req->brand,
            'model' => $req->model,
            'processor' => $req->processor,
            'memory' => $req->memory,
            'video_card' => $req->video_card,
            'lan_card' => $req->lan_card,
            'sound_card' => $req->sound_card,
            'hard_drive' => $req->hard_drive,
            'optical_drive' => $req->optical_drive,
            'monitor' => $req->monitor,
            'mouse' => $req->mouse,
            'keyboard' => $req->keyboard,
            'avr' => $req->avr,
            'type' => $req->type,
            'serviceable' => $req->serviceable,
            'asset_image_name' => 'a.jpg',
            'precurement_date' => $req->precurement_date,
        ];
    }
}