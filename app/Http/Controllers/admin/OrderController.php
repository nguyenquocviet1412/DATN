<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    //
    public function index()
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
    public function show($id)
    {
        $order = Order::query()->findOrFail($id);
        $auth = $order->users;
        return view('admin.detailorder', compact('auth','order'));
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

