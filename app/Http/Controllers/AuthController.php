<?php

namespace App\Http\Controllers;

use App\Support\Roles;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (session('role') && Roles::user(session('role'))) {
            return redirect(Roles::user(session('role'))['home']);
        }
        return view('auth.login', ['users' => Roles::users()]);
    }

    public function login(Request $request)
    {
        $role = $request->input('role');
        if (! Roles::user($role)) {
            return redirect('/login');
        }
        session(['role' => $role]);
        return redirect(Roles::user($role)['home']);
    }

    public function switchRole()
    {
        session()->forget('role');
        return redirect('/login');
    }

    public function logout()
    {
        session()->forget('role');
        return redirect('/login');
    }
}
