<?php

namespace App\Services;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

trait JobService
{
    public function setAction($job_id, $type)
    {
        $update = $type == 'cancel'
            ? array_merge(self::setJobDate('pause', true), 
                self::setJobDate('start', true),
                self::setJobDate('continue', true),
                [ 'attending_mis_personnel_id' => null ])
            : ($type == 'start' 
            ? array_merge(self::setJobDate($type), 
                [ 'attending_mis_personnel_id' => $GLOBALS['user']->user_id ])
            : self::setJobDate($type));
            
        $this->update_job_progress($job_id, $update);
    }

    public function setJobDate($type, $null = false)
    {
        return [
            $type . '_service_date' => $null ? null : date('Y-m-d'),
            $type . '_service_time' => $null ? null : date('h:i:s'),
        ];
    }

    public function getJobIndexData()
    {
        $jobs = $this->get_ordered(null, '`verified_by_client_date` IS NULL AND `client_id` = ' . $GLOBALS['user']->user_id, 'asset_name, departments.*, jobs.*');
        $mis = $this->get_user('user_id, name', [], '`role` = "mis_office_personnel"');
        $requested_jobs = [];
        $job_to_verify = [];
        
        foreach ($jobs as $i => $job)
        {
            if ($job->end_service_date)
            {
                foreach ($mis as $user)
                {
                    if ($user->user_id == $job->attending_mis_personnel_id)
                        $job->name = $user->name;
                }
                array_push($job_to_verify, $job);
            }
            else
                array_push($requested_jobs, $job);
        }

        return [
            'requested_jobs' => $requested_jobs,
            'job_to_verify' => $job_to_verify,
        ];
    }

    public function getProcessingJobIndexData()
    {
        $jobs = $this->get_ordered('`client_id`', 
            '`end_service_date` IS NULL AND (`attending_mis_personnel_id` IS NULL OR `attending_mis_personnel_id` = ' . $GLOBALS['user']->user_id .')',
            'jobs.*, name, asset_name, priority');
        $high_priority_jobs = [];
        $medium_priority_jobs = [];
        $low_priority_jobs = [];
        $paused_job = [];
        $processing_job = [];
        
        foreach ($jobs as $job)
        {
            if (!$job->attending_mis_personnel_id)
            {
                if ($job->priority == 'High')
                    array_push($high_priority_jobs, $job);
                else if ($job->priority == 'Medium')
                    array_push($medium_priority_jobs, $job);
                else
                    array_push($low_priority_jobs, $job);
            }
            else
            {
                if ($job->pause_service_date && !$job->continue_service_date)
                    $paused_job = $job;
                else
                    $processing_job = $job;
            }
        }

        return [
            'high_priority_jobs' => $high_priority_jobs,
            'medium_priority_jobs' => $medium_priority_jobs,
            'low_priority_jobs' => $low_priority_jobs,
            'paused_job' => $paused_job,
            'processing_job' => $processing_job,
        ];
    }

    public function getPriorityStartLetter($serviceable_asset_id)
    {
        $firstLetter = Str::substr($this->first_asset('priority', [0], 'asset_id = "'.$serviceable_asset_id.'"')->priority, 0, 1);

        $job_no = $this->get_job_no($firstLetter);

        if ($job_no)
        {
            $job_no = $job_no->job_no;
            if (Str::of($job_no)->contains($firstLetter))
                $job_no++;
            else
                $job_no = null;
        }

        return  $job_no ?? $firstLetter.'0001';
    }
}