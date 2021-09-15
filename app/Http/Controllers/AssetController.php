<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\DBQueries\Department;
use App\Services\AssetService;
use App\Http\Requests\Asset\StoreRequest;
use App\Http\Requests\Asset\MassUpdateRequest;

class AssetController extends BaseController
{
    use Department, AssetService;

    public function index()
    {
        abort_if(!$this->allow('read asset'), 403);

        return view($GLOBALS['user']->role . '.asset.index', [
            'assets' => $this->get_asset('assets.*, name, departments.*', [0, 1], '1'),
        ]);
    }

    public function create()
    {
        abort_if(!$this->allow('create asset'), 403);

        return view($GLOBALS['user']->role . '.asset.create', [
            'asset_id' => old('asset_id') ?? $this->generate_qr_code_value(),
            'users' => $this->get_user('name', [], '`role` != "admin"'),
            'departments' => $this->get_department('*', '1'),
        ]);
    }

    public function store(StoreRequest $req)
    {
        abort_if(!$this->allow('create asset'), 403);

        $this->store_asset($req);

        return back()->with([
            'success' => 'Sucessfully saved.'
        ]);
    }

    public function show($asset_id)
    {
        abort_if(!$this->allow('read asset', $asset_id), 403);

        // return view($GLOBALS['user']->role . '.user.profile', [
        //     'login_sessions' => LoginInfo::get_other_user_login_sessions_query(),
        // ]);
    }

    public function edit($asset_id)
    {
        abort_if(!$this->allow('update asset'), 403);
       
        return view($GLOBALS['user']->role . '.asset.edit', [
            'users' => $this->get_user('name', [], '`role` != "admin"'),
            'asset' => $this->first_asset('assets.*, departments.*, name', [0,1], '`asset_id` = '. $asset_id),
            'departments' => $this->get_department('*', '1'),
        ]);
    }

    public function update(StoreRequest $req, $asset_id)
    {
        abort_if(!$this->allow('update asset'), 403);

        $this->update_asset($req, $asset_id);

        return back()->with([
                'success' => 'Successfully updated.'
            ]);
    }

    public function destroy($asset_id)
    {
        abort_if(!$this->allow('destroy asset', $asset_id), 403);

        $this->destroy_asset($asset_id);

        return back()->with([
                'success' => 'Successfully deleted.'
            ]);
    }

    function massEdit(Request $req)
    {
        return view($GLOBALS['user']->role . '.asset.massEdit', [
            'assets' => $this->get_selected_asset($req->asset_id),
            'type' => $req->type,
            'users' => $this->get_user('name', [], '`role` != "admin"'),
            'departments' => $this->get_department('*', '1'),
        ]);
    }

    function massUpdate(MassUpdateRequest $req)
    {
        $this->update_selected_asset($req);
        
        return redirect()->route($GLOBALS['user']->role.'.asset.index')->with([
            'success' => 'Successfully updated.'
        ]);
    }

    function massDelete(Request $req)
    {
        $this->destroy_selected_asset($req->asset_id);

        return back()->with([
            'success' => 'Successfully deleted.'
        ]);
    }
}
