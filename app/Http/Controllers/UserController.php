<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function loginGet()
    {  
       
        return view('admin.user.login');
    }

    public function loginPost(Request $request)
    {
        $request->rememberMe ? $remember = true : $remember = false;
        if(Auth::attempt(['login' => $request->login, 'password' => $request->password], $remember)) {
            return response()->json(['success'=> true]);
        }

        return response()->json(['failure'=>true]);
    }

    public function logout()
    {
        Auth::logout();
        return to_route('user.login-get');
    }
}