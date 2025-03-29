<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserControllerClient extends Controller
{
    // Hiển thị trang chỉnh sửa thông tin người dùng
    public function editProfile()
    {
        $user = Auth::user();
        return view('home.UserEditProfile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'gender' => 'required|in:Male,Female,Other',  // Chỉ chấp nhận Nam hoặc Nữ
        ]);

        $user->fullname = $request->input('name');
        $user->address = $request->input('address');
        $user->phone = $request->input('phone');
        $user->gender = $request->input('gender');  // Đây phải là 'Nam' hoặc 'Nữ'
        $user->save();

        return redirect()->back()->with('success', 'Cập nhật thông tin thành công.');
    }

    // Hiển thị trang đổi mật khẩu
    public function showChangePasswordForm()
    {
        return view('home.ChangePassword');
    }

    // Đổi mật khẩu người dùng
    public function changePassword(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        // Kiểm tra xem mật khẩu hiện tại có đúng không
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Mật khẩu hiện tại không đúng.']);
        }

        // Kiểm tra xem mật khẩu mới có trùng với mật khẩu hiện tại không
        if (Hash::check($request->new_password, $user->password)) {
            return back()->withErrors(['new_password' => 'Mật khẩu mới không được trùng với mật khẩu hiện tại.']);
        }

        // Cập nhật mật khẩu mới
        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->route('user.change-password')->with('success', 'Mật khẩu đã được thay đổi thành công.');
    }

    // Hiển thị thông tin người dùng
    public function show()
    {
        $user = Auth::user();
        return view('home.UserProfile', compact('user'));
    }
}
