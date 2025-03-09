<?php

namespace App\Http\Controllers\admin;

use App\Helpers\LogHelper;
use App\Http\Controllers\Controller;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class VoucherController extends Controller
{
    public function voucherIndex(){
        //Lấy danh sách voucher
        $vouchers = Voucher::query()->get();

        // Ghi log
        LogHelper::logAction('Vào trang hiển thị danh sách voucher');
        return view('admin.voucher.voucher',compact('vouchers'));
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
    // Ghi log
    LogHelper::logAction('Xóa voucher có id: ' . $voucher->id);
    return redirect()->route('voucher.index')->with('success', 'Voucher đã được xóa thành công!');
}

    // Hiển thị form thêm mới voucher
    public function voucherCreate(){

        // Ghi log
        LogHelper::logAction('Vào trang thêm voucher');
        return view('admin.voucher.addvoucher');
    }

    // Xử lý lưu voucher vào database
public function voucherStore(Request $request)
{
    $request->validate([
        'code' => 'required|unique:vouchers|max:255',
        'discount_type' => 'required|in:percentage,fixed',
        'discount_value' => 'required|numeric|min:0',
        'min_order_value' => 'required|numeric|min:0', // Giá trị đơn hàng tối thiểu
        'max_discount' => 'nullable|numeric|min:0', // Giá trị giảm tối đa
        'quantity' => 'required|integer|min:1',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after:start_date',
        'status' => 'required|boolean',
    ]);

    // Kiểm tra giá trị giảm giá theo loại voucher
    if ($request->discount_type == 'percentage' && $request->discount_value > 50) {
        return back()->withErrors(['discount_value' => 'Giá trị giảm không được quá 50%']);
    }
    if ($request->discount_type == 'fixed' && $request->discount_value > 2000000) {
        return back()->withErrors(['discount_value' => 'Giá trị giảm không được quá 2 triệu']);
    }

    $voucher=Voucher::create($request->all());
    // Ghi log
    LogHelper::logAction('Tạo voucher mới có id: ' . $voucher->id);
    return redirect()->route('voucher.index')->with('success', 'Voucher đã được tạo thành công.');
}


    //chuyển đến trang sửa voucher
    public function voucherEdit($id){
        $voucher = Voucher::find($id);

    if (!$voucher) {
        return redirect()->route('voucher.index')->with('error', 'Voucher không tồn tại!');
    }

        // Ghi log
        LogHelper::logAction('Vào trang chỉnh sửa voucher có ID: ' . $id);
    return view('admin.voucher.editvoucher', compact('voucher'));
    }

    // Xử lý lưu thay đổi voucher vào database
    public function voucherUpdate(Request $request, $id){

        $request->validate([
            'code' => ['required', 'string', Rule::unique('vouchers', 'code')->ignore($id)],
            'discount_type' => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:0',
            'min_order_value' => 'required|numeric|min:0',
            'max_discount' => 'nullable|numeric|min:0',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'usage_limit' => 'required|integer|min:1',
            'quantity' => 'required|integer|min:1',
            'status' => ['required', Rule::in(['active', 'expired', 'disabled'])], // Cập nhật trạng thái
        ]);
        // dd($request->all());

        // Kiểm tra điều kiện giảm giá
        if ($request->discount_type == 'percentage' && $request->discount_value > 50) {
            return redirect()->back()->withErrors(['discount_value' => 'Giảm giá theo phần trăm không được vượt quá 50%!'])->withInput();
        }

        if ($request->discount_type == 'fixed' && $request->discount_value > 2000000) {
            return redirect()->back()->withErrors(['discount_value' => 'Giảm giá cố định không được vượt quá 2.000.000 VNĐ!'])->withInput();
        }

        $voucher = Voucher::find($id);

        if (!$voucher) {
            return redirect()->route('voucher.index')->with('error', 'Voucher không tồn tại!');
        }

        // Nếu không nhập ngày, giữ nguyên dữ liệu cũ
        $start_date = $request->start_date ?? $voucher->start_date;
        $end_date = $request->end_date ?? $voucher->end_date;

        $voucher->update([
            'code' => $request->code,
            'discount_type' => $request->discount_type,
            'discount_value' => $request->discount_value,
            'min_order_value' => $request->min_order_value,
            'max_discount' => $request->max_discount,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'usage_limit' => $request->usage_limit,
            'quantity' => $request->quantity,
            'status' => $request->status,
        ]);
        // Ghi log
        LogHelper::logAction('Cập nhật voucher có ID: ' . $id);
        return redirect()->route('voucher.index')->with('success', 'Voucher đã được cập nhật thành công!');
    }

    //Thay đổi trạng thái hoạt động của voucher
    public function toggleStatus($id)
    {
        $voucher = Voucher::findOrFail($id);

        // Nếu voucher hết hạn, không cho phép kích hoạt
        if (\Carbon\Carbon::now()->greaterThan($voucher->end_date)) {
            return redirect()->route('voucher.index')->with('error', 'Không thể kích hoạt voucher đã hết hạn.');
        }

        // Đảo trạng thái giữa 'active' và 'disabled'
        $voucher->status = $voucher->status == 'active' ? 'disabled' : 'active';
        $voucher->save();
        // Ghi log
        LogHelper::logAction('Thay đổi trạng thái voucher có ID: ' . $id);
        return redirect()->route('voucher.index')->with('success', 'Trạng thái voucher đã được cập nhật.');
    }

}
