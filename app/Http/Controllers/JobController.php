<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\DBQueries\Job;
use App\Services\JobService;
use App\Http\Requests\Job\StoreRequest;
use App\Http\Requests\Job\MassUpdateRequest;


class JobController extends BaseController
{
    use Job, JobService;
   
    public function admin_index()
    {
        return view('admin.job.index', [
            'jobs' => $this->get_job('jobs.*, name', [1], '1'),
        ]);
    }

    public function index()
    {
        return view($GLOBALS['user']->role . '.job.index', $this->getJobIndexData());
    }

    public function create()
    {
        // abort_if(!$this->allow('create asset'), 403);

        $data = [
            'assets' => $this->get_asset('asset_id', [], '1'),
        ];

        if ($GLOBALS['user']->role == 'admin')
            $data = array_merge($data, [
                'users' => $this->get_user('name', [], '`role` != "admin" AND `role` != "mis_office_personnel"'),
            ]);

        return view($GLOBALS['user']->role . '.job.create', $data);
    }

    public function store(StoreRequest $req)
    {
        // abort_if(!$this->allow('create asset'), 403);

        $this->store_job($req, $this->getPriorityStartLetter($req->serviceable_asset_id));

        return back()->with([
            'success' => 'Successfully inserted.'
        ]);
    }

    public function show($job_id)
    {
        abort_if(!$this->allow('read asset', $job_id), 403);

        // return view($GLOBALS['user']->role . '.user.profile', [
        //     'login_sessions' => LoginInfo::get_other_user_login_sessions_query(),
        // ]);
    }

    public function edit($job_id)
    {
        $job = $this->first_job('jobs.*, name, asset_name, departments.*', [0,1,3], '`job_id` = "'. $job_id.'"');
        abort_if(!$this->allow('update job', $job->client_id) && $GLOBALS['user']->role != 'admin', 403);

        $data = [
            'job' => $job,
            'assets' => $this->get_asset('asset_id', [], '1'),
        ];

        if ($GLOBALS['user']->role == 'admin')
            $data = array_merge($data, [
                'users' => $this->get_user('name', [], '`role` != "admin" AND `role` != "mis_office_personnel"'),
            ]);

        return view($GLOBALS['user']->role . '.job.edit', $data);
    }

    public function update(StoreRequest $req, $job_id)
    {
        $job = $this->first_job('jobs.*, name, asset_name, departments.*', [0,1,3], '`job_id` = "'. $job_id.'"');
        abort_if(!$this->allow('update job', $job->client_id) && $GLOBALS['user']->role != 'admin', 403);

        $this->update_job($job_id, $req);

        return back()->with([
                'success' => 'Successfully updated.'
            ]);
    }

    public function destroy($job_id)
    {
        $job = $this->first_job('jobs.*, name, asset_name, departments.*', [0,1,3], '`job_id` = "'. $job_id.'"');
        abort_if(!$this->allow('destroy job', $job->client_id), 403);

        $this->destroy_job($job_id);

        return back()->with([
                'success' => 'Successfully deleted.'
            ]);
    }

    function massEdit(Request $req)
    {   
        return view($GLOBALS['user']->role . '.job.massEdit', [
            'jobs' => $this->get_selected_job($req->job_id),
            'assets' => $this->get_asset('asset_id', [], '1'),
            'users' => $this->get_user('name', [], '`role` != "admin" AND `role` != "mis_office_personnel"'),
        ]);
    }

    function massUpdate(MassUpdateRequest $req)
    {
        $this->update_selected_job($req);

        return redirect()->route('admin.job.index')->with([
            'success' => 'Successfully updated.'
        ]);
    }

    function massDelete(Request $req)
    {
        $this->destroy_selected_job($req->job_id);
        
        return back()->with([
            'success' => 'Successfully deleted.',
        ]);
    }

    function verify($job_id)
    {
        $this->update_job_progress($job_id, [
            'verified_by_client_date' => date('Y-m-d'),
            'verified_by_client_time' => date('h:i:s'),
        ]);

        return back()->with([
            'success' => 'Successfully verified.'
        ]);
    }
}
