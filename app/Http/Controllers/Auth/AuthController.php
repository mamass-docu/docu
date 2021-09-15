<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Auth\Authentication\Auth;
use App\Services\AuthService;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Rules\ValidateLoginUserPassword;
use App\AuthenticationTool\User;

class AuthController
{
    use ValidatesRequests;

    function view_login()
    {
        return view('auth.login');
    }

    function login(Request $req)
    {
        if (cache(User::getKey().'-not-allowed')) 
            return back();

        AuthService::incrementFailedAttempt();
        AuthService::proccessFailedAttempts();

        $req->validate([
            'email'=>'required|exists:Users',
            'password'=>['required', new ValidateLoginUserPassword($req->email)],
        ]);
        
        $req->remember
            ?Auth::login($req->email, true)
            :Auth::login($req->email);

        return redirect()->route('home')->with([
            'success' => 'Successfully logged in.'
        ]);
    }

    function logout(Request $req)
    {
        Auth::logout();
        return redirect()->route('auth.login.view');
    }
}
