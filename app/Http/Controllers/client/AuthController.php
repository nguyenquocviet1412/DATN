<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function getLogin()
    {
        return view('home.login');
    }

    public function postLogin(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('web')->attempt($credentials)) {
            return redirect()->route('/');
        }

        return back()->with('message', 'Email hoặc mật khẩu không chính xác.');
    }

    public function getRegister()
    {
        return view('home.register');
    }

    public function postRegister(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:5|confirmed',
        ]);

        $data['password'] = bcrypt($data['password']);
        User::create($data);

        return redirect()->route('login')->with('message', 'Đăng ký thành công.');
    }

    public function logout()
    {
        Auth::guard('web')->logout();
        return redirect()->route('login');
    }
}
