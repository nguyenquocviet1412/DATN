<?php

namespace App\Helpers;

use App\Models\Log;
use Illuminate\Support\Facades\Auth;

class LogHelper
{
    public static function logAction($action, $details = null)
    {
        $employee = Auth::guard('employee')->user(); // Lấy nhân viên đang đăng nhập

        Log::create([
            'id_employee' => $employee ? $employee->id : null,
            'action' => $action,
            'ip_address' => request()->ip(),
            'details' => $details
        ]);
    }
}
