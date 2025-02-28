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

    //Xóa voucher
    public function voucherDelete($id)
{
    $voucher = Voucher::find($id);

    if (!$voucher) {
        return redirect()->route('voucher.index')->with('error', 'Voucher không tồn tại!');
    }

    // Kiểm tra nếu voucher có dữ liệu liên kết
    if ($voucher->userVouchers()->exists() || $voucher->orders()->exists()) {
        return redirect()->route('voucher.index')->with('error', 'Không thể xóa! Voucher này đang tồn tại dữ liệu ở nơi khác.');
    }

    $voucher->delete();

    return redirect()->route('voucher.index')->with('success', 'Voucher đã được xóa thành công!');
}

    // Hiển thị form thêm mới voucher
    public function voucherCreate(){
        return view('admin.addvoucher');
    }
    // Xử lý lưu voucher vào database
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
        'quantity' => 'required|integer|min:1',
        'status' => 'required|boolean',
    ]);

    Voucher::create($request->all());

    return redirect()->route('voucher.index')->with('success', 'Voucher đã được tạo thành công.');
}

    //chuyển đến trang sửa voucher
    public function voucherEdit($id){
        $voucher = Voucher::find($id);

    if (!$voucher) {
        return redirect()->route('voucher.index')->with('error', 'Voucher không tồn tại!');
    }

    return view('admin.editvoucher', compact('voucher'));
    }

    // Xử lý lưu thay đổi voucher vào database
public function voucherUpdate(Request $request, $id){
    $request->validate([
        'code' => 'required|string|unique:vouchers,code,'.$id,
        'discount_type' => 'required|in:percentage,fixed',
        'discount_value' => 'required|numeric|min:0',
        'min_order_value' => 'required|numeric|min:0',
        'max_discount' => 'nullable|numeric|min:0',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date',
        'usage_limit' => 'required|integer|min:1',
        'quantity' => 'required|integer|min:1',
        'status' => 'required|boolean',
    ]);

    $voucher = Voucher::find($id);

    if (!$voucher) {
        return redirect()->route('voucher.index')->with('error', 'Voucher không tồn tại!');
    }

    $voucher->update([
        'code' => $request->code,
        'discount_type' => $request->discount_type,
        'discount_value' => $request->discount_value,
        'min_order_value' => $request->min_order_value,
        'max_discount' => $request->max_discount,
        'start_date' => $request->start_date,
        'end_date' => $request->end_date,
        'usage_limit' => $request->usage_limit,
        'quantity' => $request->quantity,
        'status' => $request->status,
    ]);

    return redirect()->route('voucher.index')->with('success', 'Voucher đã được cập nhật thành công!');
}

    //Thay đổi trạng thái hoạt động của voucher
    public function toggleStatus($id)
    {
        $voucher = Voucher::findOrFail($id);

        // Nếu voucher hết hạn, không cho phép kích hoạt
        if (\Carbon\Carbon::now()->greaterThan($voucher->end_date)) {
            return redirect()->back()->with('error', 'Không thể kích hoạt voucher đã hết hạn.');
        }

        // Đảo trạng thái giữa 'active' và 'disabled'
        $voucher->status = $voucher->status == 'active' ? 'disabled' : 'active';
        $voucher->save();

        return redirect()->back()->with('success', 'Trạng thái voucher đã được cập nhật.');
    }

}
