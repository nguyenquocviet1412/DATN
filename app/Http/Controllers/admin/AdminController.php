<?php

namespace App\Http\Controllers\admin;

use App\Helpers\LogHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    //
    public function index(){
        // Ghi log
        LogHelper::logAction('hiển thị trang dashboard');
        return view('admin.product');
    }
}
