<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Auth;
class LoginController extends Controller
{
    public function login(){
        return view('admin.auth.login');
    }

    public function postLogin(LoginRequest  $request){

        $remember_me = $request -> has('remember_me') ? true : false;

        if(auth()->guard('admin')->attempt(['email' => $request->input('email'), 'password'=>$request-> input('password')], $remember_me))
            return redirect()->route('admin.dashboard');
        else
            return redirect()->back()-> with(['error' =>'الإيميل أو الباسورد غير صحيح']);
    }

    public function logout(){
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }
}
