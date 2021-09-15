<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DBQueries\Department;
use App\Services\CacheRememberService;
use App\Http\Requests\Department\StoreRequest;
use App\Http\Requests\Department\MassUpdateRequest;

class DepartmentController
{
    use Department, CacheRememberService;

    public function index(Request $req)
    {
        return view('admin.department.index', [
            'departments' => $this->get_department('*','1'),
        ]);
    }

    public function create()
    {
        return view('admin.department.create');
    }

    public function store(StoreRequest $req)
    {
        $this->store_department($req);

        return back()->with([
            'success' => 'Sucessfully saved.'
        ]);
    }

    public function show($department_id)
    {
        // return view($GLOBALS['user']->role . '.user.profile', [
        //     'login_sessions' => LoginInfo::get_other_user_login_sessions_query(),
        // ]);
    }

    public function edit($department_id)
    {
        return view('admin.department.edit', [
            'department' => $this->first_department('*', 'department_id = '. $department_id),
        ]);
    }

    public function update(StoreRequest $req, $department_id)
    {
        $this->update_department($req, $department_id);

        return back()->with([
                'success' => 'Successfully updated.'
            ]);
    }

    public function destroy($department_id)
    {
        $this->destroy_department($department_id);

        return back()->with([
                'success' => 'Successfully deleted.'
            ]);
    }

    function massEdit(Request $req)
    {
        return view('admin.department.massEdit', [
            'departments' => $this->get_selected_department($req->department_id),
        ]);
    }

    function massUpdate(MassUpdateRequest $req)
    {
        $this->update_selected_department($req);
        
        return redirect()->route($GLOBALS['user']->role.'.department.index')->with([
            'success' => 'Successfully updated.'
        ]);
    }

    function massDelete(Request $req)
    {
        $this->destroy_selected_department($req->department_id);

        return back()->with([
            'success' => 'Successfully deleted.'
        ]);
    }
}
