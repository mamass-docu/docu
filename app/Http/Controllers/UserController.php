<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\DBQueries\Department;
use App\Services\UserService;
use App\DBQueries\LoginInfo;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\User\UpdateRequest;
use App\Http\Requests\User\StoreRequest;
use App\Http\Requests\User\UpdatePasswordRequest;
use App\Http\Requests\User\MassUpdateRequest;

class UserController extends BaseController
{
    use Department, UserService;

    public function index()
    {
        abort_if(!$this->allow('read user'), 404);
        
        return view($GLOBALS['user']->role . '.user.index', [
            'users' => $this->get_user('user_id, name, role, image_name, department_name', [0], '`role` != "admin"'),
        ]);
    }

    public function create()
    {
        abort_if(!$this->allow('create user'), 403);
       
    }

    public function store(StoreRequest $req)
    {
  
    // echo $req->try[0];
    }

    public function show($user_id)
    {
        abort_if(!$this->allow('show user', $user_id), 403);

        return view($GLOBALS['user']->role . '.user.profile', [
            'login_sessions' => LoginInfo::get_other_user_login_sessions_device($GLOBALS['user']->user_id),
        ]);
    }

    public function edit($user_id)
    {
        abort_if($GLOBALS['user']->role != 'admin', 404);

       return view($GLOBALS['user']->role . '.user.edit',[
           'user' => $this->first_user('user_id, name, email, image_name, departments.*', [0], '`user_id` = '. $user_id),
       ]);
    }

    public function update(UpdateRequest $req, $user_id)
    {
        $image_name = $this->move_image_to_the_server_user($req);

        $this->update_user($req, $user_id, $image_name);

        return back()->with([
                'success' => 'Successfully updated.'
            ]);
    }

    public function update_password(UpdatePasswordRequest $req, $user_id)
    {
        $this->update_password_user($password);

        session()->put('authenticated_user_password', $password);
        
        return back()->with([
                'success' => 'Successfully updated.'
            ]);
    }

    public function loggout_all_other_sessions($user_id)
    {
        abort_if(!$this->allow('logout user',$user_id), 403);
        
        LoginInfo::reset_other_user_remember_token_device($GLOBALS['user']->user_id);

        $password = Hash::make('1');

        $this->update_user_password($password);

        $this->update_other_device_login_status($password);

        return back()->with([
                'success' => 'Successfully log out other sessions',
            ]);
    }

    public function destroy($user_id)
    {
        abort_if(!$this->allow('destroy user',$user_id) && $GLOBALS['user']->role != 'admin', 403);
        
        $this->destroy_user($user_id);
        
        LoginInfo::destroy_device($user_id);
        
        if ($GLOBALS['user']->user_id == $user_id)
            return redirect()->route('auth.login.view');
        
        return back()->with([
            'success' => 'Successfully deleted.',
        ]);
    }

    function massEdit(Request $req)
    {
        return view('admin.user.massEdit', [
            'users' => $this->get_selected_user($req->user_id),
            'departments' => $this->get_department('*', '1'),
        ]);
    }

    function massUpdate(MassUpdateRequest $req)
    {
        $this->update_selected_user($req);

        return redirect()->route('user.index')->with([
            'success' => 'Successfully updated.'
        ]);
    }

    function massDelete(Request $req)
    {
        $this->destroy_selected_user($req->user_id);
        
        return back()->with([
            'success' => 'Successfully deleted.',
        ]);
    }
}
