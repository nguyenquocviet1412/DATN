<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        // Thêm thông báo lỗi khi bị chuyển hướng
        Session::flash('warning', 'Bạn cần đăng nhập để truy cập trang này.');
        return $request->expectsJson() ? null : route('login');
    }

}
