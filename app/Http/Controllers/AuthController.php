<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function getLogin()
    {
        return view('login');
    }

    public function postLogin(Request $request)
    {

        $request->validate([
            'nip' => 'required|exists:users,nip',
            'password' => 'required'
        ]);

        $remember_token = ($request->has('remember_token')) ? true : false;

        if (Auth::attempt($request->only('nip', 'password'), $remember_token)) {
            return redirect()->intended('hr/dashboard');
        }

        return redirect()->back()->withInput()->withErrors(['password' => 'Wrong Password.',]);
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
