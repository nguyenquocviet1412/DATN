<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    public function voucherIndex(){
        //Lấy danh sách voucher
        $vouchers = Voucher::query()->get();
        return view('admin.voucher',compact('vouchers'));
    }
    // Hiển thị form thêm mới voucher
    public function voucherCreate(){
        return view('admin.voucher_create');
    }
    // Xử lý lưu voucher vào database
    public function voucherStore(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:vouchers|max:255',
            'discount_type' => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:0',
            'min_order_value' => 'nullable|numeric|min:0',
            'max_discount' => 'nullable|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'usage_limit' => 'nullable|integer|min:1',
            'status' => 'required|boolean',
        ]);

        Voucher::create($request->all());

        return redirect()->route('voucher.index')->with('success', 'Voucher đã được tạo thành công.');
    }

    //chuyển đến trang sửa voucher
    public function voucherEdit($id){
        $voucher = Voucher::query()->find($id);
        return view('admin.voucher_edit',compact('voucher'));
    }

}
