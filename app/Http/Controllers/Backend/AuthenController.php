<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenController extends Controller
{
    public function __construct()
    {

    }

    public function index(){

        return view('Backend.auth.login');
    }

    public function login(AuthRequest $request){

        $credentials = [
            'email' => $request->input('email'),
            'password' => $request->input('password')
        ];

       if(Auth::attempt($credentials)){
            return redirect()->route('dashboard.index')->with('success', 'Login successfull!');
       }

       return redirect()->route('auth.admin')->with('error', 'Login Failed!');

    }

    public function logout(Request $request){
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('auth.admin');
    }
}
