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
    // Xác thực dữ liệu đầu vào
    $request->validate([
        'email' => 'required|email',
        'password' => 'required|min:6'
    ]);

    // Lấy thông tin đăng nhập
    $credentials = $request->only('email', 'password');
    $remember = $request->has('remember'); // Kiểm tra checkbox Remember Me

    // Tìm tài khoản theo email
    $user = User::withTrashed()->where('email', $request->email)->first();

    if (!$user) {
        return back()->with('error', 'Email hoặc mật khẩu không chính xác.');
    }

    // Kiểm tra nếu tài khoản bị xóa (có deleted_at) hoặc bị vô hiệu hóa (status = inactive)
    if ($user->trashed() || $user->status !== 'active') {
        return back()->with('error', 'Tài khoản của bạn đã bị vô hiệu hóa hoặc bị xóa.');
    }

    // Thực hiện đăng nhập
    if (Auth::guard('web')->attempt($credentials, $remember)) {
        return redirect()->route('home.index')->with('success', 'Đăng nhập thành công!');
    }

    return back()->with('error', 'Email hoặc mật khẩu không chính xác.');
}


    public function logoutUser()
    {
        Auth::guard('web')->logout();
        return redirect()->route('login')->with('success', 'Bạn đã đăng xuất thành công!');
    }

    public function getRegister()
    {
        return view('home.register');
    }

    public function postRegister(Request $request)
{
    $data = $request->validate([
        'fullname' => 'required|min:3',
        'birthday' => 'date',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:5|confirmed',
        'phone' => 'required|digits:10|unique:users,phone',
        'address' => 'required|string|max:255',
        'gender' => 'required|in:male,female,other',
    ]);

    $data['password'] = bcrypt($data['password']);
    $data['role'] = 'user'; // Mặc định user
    $data['status'] = 'active'; // Tài khoản đang hoạt động

    $user = User::create($data);

    return redirect()->route('login')->with('message', 'Đăng ký thành công.');
}

}
