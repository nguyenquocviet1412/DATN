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
    // Xác thực dữ liệu đầu vào
    $request->validate([
        'email' => 'required|email',
        'password' => 'required|min:6'
    ]);

    // Lấy thông tin đăng nhập
    $credentials = $request->only('email', 'password');
    $remember = $request->has('remember');

    // Tìm tài khoản nhân viên theo email (kể cả đã bị xóa mềm)
    $employee = \App\Models\Employee::withTrashed()->where('email', $request->email)->first();

    if (!$employee) {
        return back()->with('error', 'Email hoặc mật khẩu không chính xác.');
    }

    // Kiểm tra nếu tài khoản bị xóa mềm hoặc bị vô hiệu hóa (status != active)
    if ($employee->trashed() || $employee->status !== 'active') {
        return back()->with('error', 'Tài khoản của bạn đã bị vô hiệu hóa hoặc bị xóa.');
    }

    // Thực hiện đăng nhập
    if (Auth::guard('employee')->attempt($credentials, $remember)) {
        // Lưu thông tin nhân viên vào session
        session(['employee' => Auth::guard('employee')->user()]);

        // Ghi log
        LogHelper::logAction('Đăng nhập vào hệ thống');

        return redirect()->route('admin.dashboard')->with('success', 'Đăng nhập thành công!');
    }

    return back()->with('error', 'Email hoặc mật khẩu không chính xác.');
}

    public function logout()
    {
        // Xóa session
        session()->forget('employee');

        // Đăng xuất tài khoản
        Auth::guard('employee')->logout();

        // Ghi log
        LogHelper::logAction('Đăng xuất khỏi hệ thống');

        // Chuyển hướng về trang đăng nhập kèm thông báo
        return redirect()->route('admin.login')->with('logout_success', true);
    }
}
