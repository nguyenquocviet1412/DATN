<?php

namespace App\Http\Controllers\admin;

use App\Helpers\LogHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Employee;

class EmployeeAuthController extends Controller
{
    public function getLogin()
    {
        return view('admin.employee_login');
    }

    public function postLogin(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('employee')->attempt($credentials)) {
            $employee = Auth::guard('employee')->user();

            // Lưu toàn bộ thông tin của nhân viên vào session
            session(['employee' => $employee]);
            // Ghi log
            LogHelper::logAction('đăng nhập vào hệ thống');
            return redirect()->route('admin.dashboard');
        }
        return back()->with('message', 'Email hoặc mật khẩu không chính xác.');
    }

    //Đăng xuất tài khoản quản trị viên
    public function logout()
{
    // Xóa session
    session()->forget('employee');

    // Đăng xuất tài khoản
    Auth::guard('employee')->logout();
    // Ghi log
    LogHelper::logAction('đăng xuất khỏi hệ thống');
    // Chuyển hướng về trang đăng nhập kèm thông báo
    return redirect()->route('admin.login')->with('logout_success', true);
}
}
