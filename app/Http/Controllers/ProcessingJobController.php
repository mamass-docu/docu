<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\DBQueries\Job;
use App\Services\JobService;

class ProcessingJobController extends BaseController
{
    use JobService, Job;

    public function index()
    {
        return view('mis_office_personnel.job.index', $this->getProcessingJobIndexData());
    }

    public function action(Request $req)
    {
        $job_id = $req->action == 'start' ? $req->new_job_id : $req->current_job_id; 

        $this->setAction($job_id, $req->action);

        $this->set_notification('job_request_progress', $job_id, $req->action == 'start' ? $req->new_user_id : $req->current_user_id);

        return back()->with([
            'success' => 'Successfully '.$req->action.' job.',
        ]);
    }

    public function show($job_id, $user_id)
    {
        return view('mis_office_personnel.job.done', [
            'job_id' => $job_id,
            'user_id' => $user_id,
        ]);
    }

    public function done(Request $req)
    {
        $this->update_job_progress($req->job_id, array_merge($this->setJobDate('end') ,[
            'problems_found' => $req->problems_found,
            'solution_applied' => $req->solution_applied,
            'recommendation' => $req->recommendation,
            'remarks' => $req->remarks,
        ]));
        
        $this->set_notification('job_request_to_verify', $req->job_id, $req->user_id);

        return redirect()->route('mis_office_personnel.job.index');
    }
}
