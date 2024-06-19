<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('admin_login');
    }

    public function login(Request $request){
        $credentials = $request->only('user_name', 'password');
        
        // Check if username and password fields are provided
        if (!isset($credentials['user_name']) || !isset($credentials['password'])) {
            return redirect()->back()->with('error', 'Both username and password fields are required.');
        }
    
        // Attempt authentication
        if (!Auth::attempt($credentials)) {
            // Authentication failed
            return redirect()->back()->with('error', 'Invalid credentials. Please try again.');
        }
    
        // Authentication passed
        return redirect()->route('main.dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/admin-login');
    }
}
