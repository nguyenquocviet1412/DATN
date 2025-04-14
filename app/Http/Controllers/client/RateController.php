<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Order_item;
use App\Models\Product;
use App\Models\Rate;
use Illuminate\Http\Request;

class RateController extends Controller
{
    //Trang đánh giá
    public function create($id)
    {
        //Kiểm tra đơn hàng đã được giao chưa
        $orderItem = Order_item::where('id', $id)->first();
        if (!$orderItem || $orderItem->status !== 'completed') {
            return redirect()->back()->with('error', 'Đơn hàng chưa được hoàn thành hoặc không tồn tại.');
        }
        //Kiểm tra sản phẩm đã được đánh giá chưa
        $existingRate = Rate::where('id_order_item', $id)->first();
        if ($existingRate) {
            return redirect()->back()->with('error', 'Sản phẩm đã được đánh giá.');
        }
        //Lấy thông tin sản phẩm
        $product = Product::where('id', $orderItem->variant->id_product)->with(['category', 'variants.images'])->first();
        if (!$product) {
            return redirect()->back()->with('error', 'Sản phẩm không tồn tại.');
        }
        //Kiểm tra xem người dùng đã mua sản phẩm này chưa
        $orderItem = Order_item::where('id_variant', $orderItem->id_variant)
            ->where('id_order', $orderItem->id_order)
            ->first();
        if (!$orderItem) {
            return redirect()->back()->with('error', 'Bạn chưa mua sản phẩm này.');
        }
        //Lấy thông tin người dùng
        $user = auth()->user();
        //Lấy thông tin đơn hàng
        $order = $orderItem->order;
        $orderItem = $order->orderItems()->where('id', $id)->first();
        //Truyền dữ liệu vào view
        return view('home.rate', compact('product', 'user', 'orderItem'));
    }
    public function store(Request $request)
{
    // Xác thực dữ liệu đầu vào
    $validated = $request->validate([
        'id_product' => 'required|exists:products,id',
        'id_order_item' => 'required|exists:order_items,id',
        'rating' => 'required|integer|min:1|max:5',
        'review' => 'nullable|string',
    ]);

    // Lấy thông tin đơn hàng
    $orderItem = Order_item::find($validated['id_order_item']);

    if (!$orderItem) {
        return redirect()->back()->with(['error' => 'Đơn hàng không tồn tại.'], 404);
    }

    // Kiểm tra đơn hàng có thuộc về user hiện tại không
    if ($orderItem->order->id_user !== auth()->id()) {
        return redirect()->back()->with(['error' => 'Bạn không có quyền đánh giá đơn hàng này.'], 403);
    }

    // Kiểm tra đơn hàng đã hoàn thành chưa
    if ($orderItem->status !== 'completed') {
        return redirect()->back()->with(['error' => 'Bạn chỉ có thể đánh giá khi đơn hàng đã hoàn thành.'], 400);
    }

    // Kiểm tra xem sản phẩm đã được đánh giá chưa
    $existingRate = Rate::where('id_order_item', $validated['id_order_item'])->first();
    if ($existingRate) {
        return redirect()->back()->with(['error' => 'Sản phẩm này đã được đánh giá.'], 400);
    }

    // Tạo đánh giá mới
        $rate = Rate::create([
            'id_user' => auth()->id(), // Lấy ID người dùng hiện tại
            'id_product' => $validated['id_product'],
            'id_order_item' => $validated['id_order_item'],
            'rating' => $validated['rating'],
            'review' => $validated['review'] ?? '',
            'status' => 'approved',
        ]);

        return redirect()->route('home.index')->with(['success' => 'Đánh giá của bạn đã được gửi thành công.']);
}


}
