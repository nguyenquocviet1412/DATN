<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Product_image;
use App\Models\Voucher;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // Hiển thị giỏ hàng
    public function index()
{
    $user = Auth::user();
    $cartItems = Cart::where('id_user', $user->id)
                     ->with(['variant.product', 'variant.color', 'variant.size', 'variant.images'])
                     ->get();
    return view('home.cart', compact('cartItems'));
}

    // Thêm sản phẩm vào giỏ hàng
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $product = Product::findOrFail($request->product_id);
        $user = Auth::user();

        if ($product->stock < $request->quantity) {
            return response()->json(['message' => 'Không đủ hàng trong kho'], 400);
        }

        $cartItem = Cart::updateOrCreate(
            ['user_id' => $user->id, 'product_id' => $product->id],
            ['quantity' => $request->quantity, 'price' => $product->price]
        );

        return response()->json(['message' => 'Sản phẩm đã được thêm vào giỏ hàng', 'cartItem' => $cartItem]);
    }

    // Cập nhật số lượng sản phẩm trong giỏ hàng
    public function update(Request $request, $id)
    {
        $request->validate(['quantity' => 'required|integer|min:1']);

        $cartItem = Cart::findOrFail($id);
        $product = Product::findOrFail($cartItem->product_id);

        if ($product->stock < $request->quantity) {
            return response()->json(['message' => 'Không đủ hàng trong kho'], 400);
        }

        $cartItem->update(['quantity' => $request->quantity]);

        return response()->json(['message' => 'Cập nhật thành công', 'cartItem' => $cartItem]);
    }

    // Xóa sản phẩm khỏi giỏ hàng
    public function remove($id)
    {
        $cartItem = Cart::findOrFail($id);
        $cartItem->delete();

        return response()->json(['message' => 'Xóa sản phẩm thành công']);
    }

    // Áp dụng mã giảm giá
    public function applyDiscount(Request $request)
    {
        $request->validate(['code' => 'required|string']);

        $discount = Voucher::where('code', $request->code)->first();

        if (!$discount) {
            return response()->json(['message' => 'Mã giảm giá không hợp lệ'], 400);
        }

        $user = Auth::user();
        $cartItems = Cart::where('user_id', $user->id)->get();
        $total = $cartItems->sum(fn($item) => $item->quantity * $item->price);

        $discountAmount = ($discount->percentage / 100) * $total;
        $newTotal = $total - $discountAmount;

        return response()->json(['message' => 'Áp dụng mã giảm giá thành công', 'discountAmount' => $discountAmount, 'newTotal' => $newTotal]);
    }
}
