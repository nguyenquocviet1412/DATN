<?php

namespace App\Http\Controllers\admin;

use App\Helpers\LogHelper;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    //hiển thị danh sách đơn hàng
    public function index()
{
    $listOrder = Order::with('orderItems.variant.product')->orderByDesc('id')->get();

        // Ghi log
        LogHelper::logAction('Vào trang hiển thị danh sách đơn hàng');
    return view('admin.order', compact('listOrder'));
}

    //Trang hiện thị đơn hàng chi tiết
    public function show($id)
{
    $order = Order::with(['user', 'voucher', 'orderItems.variant.product', 'orderItems.variant.color', 'orderItems.variant.size'])->findOrFail($id);
    // Ghi log
    LogHelper::logAction('Xem chi tiết đơn hàng: ' . $order->id);
    return view('admin.detailorder', compact('order'));
}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        $order = Order::query()->findOrFail($id);
        if (!$order) {
            return redirect()->route('order.index');
        }

        return view('admin.editorder', compact('order'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $orDer = Order::query()->findOrFail($id);


        $newStatus = $request->input('payment_status');



        $orDer->payment_status = $newStatus;

        $orDer->save();
        return redirect()->route('admin.order')->with('success', 'Cập nhật trạng thái thành công');
    }

    /**
     * Remove the specified resource from storage.
    */

    public function delete($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();
        return redirect()->route('admin.order')->with('success', 'Order deleted successfully.');
    }

}

