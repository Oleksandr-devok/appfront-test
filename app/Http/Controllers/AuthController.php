<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function show()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        if (Auth::attempt($request->except('_token'))) {
            return redirect()->route('admin.products.index');
        }

        return redirect()->back()->with('error', 'Invalid login credentials');
    }

    public function logout()
    {
        Auth::logout();
        
        return redirect()->route('login');
    }

}
