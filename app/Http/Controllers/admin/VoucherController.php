<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    public function voucherIndex(){
        return view('admin.voucher');
    }
    public function voucherCreate(){
        return view('admin.voucher_create');
    }
}
