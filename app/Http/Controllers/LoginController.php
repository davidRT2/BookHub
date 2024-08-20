<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    //
    public function showLoginForm()
    {
        return view('authentication.login');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        // Attempt to log the user in
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            // Authentication passed
            if (Auth::user()->role === 'Admin') {
                return redirect()->intended('dashboard');
            } elseif (Auth::user()->role === 'User') {
                return redirect()->intended('dashboard');
            }
        }
        // Authentication failed
        return redirect()->back()->withErrors(['email' => 'Invalid credentials'])->withInput();
    }

    /**
     * Log the user out of the application.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
