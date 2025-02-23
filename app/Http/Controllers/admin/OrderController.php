<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    //
    public function orderIndex()
    {
        $listOrder = Order::query()->orderByDesc('id')->get();

        $status = Order::TRANG_THAI_DON_HANG;
        
        return view('admin.order', compact('listOrder','status'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        $auth = $order->user;
        return view('admin.detailorder', compact('auth','order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $orders = Order::query()->findOrFail($id);
        if (!$orders) {
            return redirect()->route('order.index');
        }

        return view('admin.detailorder', compact('orders'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $orDer = Order::query()->findOrFail($id);

        $currentStatus = $orDer->status;

        $newStatus = $request->input('status');

        $statuss = array_keys(Order::TRANG_THAI_DON_HANG);
        if ($currentStatus === Order::HUY_DON_HANG) {
            return redirect()->route('admin.order')->with('error', 'Đơn hàng đã hủy không thể thay đổi trạng thái');
        }
        if (array_search($newStatus, $statuss) < array_search($currentStatus, $statuss)) {
            return redirect()->route('admin.order')->with('error', 'Không thể cập nhật ngược trạng thái đơn hàng');
        }

        $orDer->status = $newStatus;

        $orDer->save();
        return redirect()->route('admin.order')->with('success', 'Cập nhật trạng thái thành công');
    }

    /**
     * Remove the specified resource from storage.
     */
    
    public function trash()
    {
        $listOrd = Order::onlyTrashed()->get();
        return view('admin.trashorder',compact('listOrd'));
    }

    public function restore($id)
    {
        $order = Order::withTrashed()->find($id);

        if ($order) {
            $order->restore();
            $order->details()->withTrashed()->restore();

            // Khôi phục các sản phẩm liên quan nếu cần
            foreach ($order->details as $item) {
                $product = Product::withTrashed()->find($item->product_id);
                if ($product) {
                    $product->restore();
                }
            }
            return redirect()->route('admin.order')->with('success', 'Khôi phục đơn hàng thành công!');
        }
    }
   
}

