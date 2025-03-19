<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Product_image;
use App\Models\Variant;
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
        'id_variant' => 'required|exists:variants,id',
        'quantity' => 'required|integer|min:1'
    ]);

    $variant = Variant::with('product')->findOrFail($request->id_variant);
    $user = Auth::user();

    // Kiểm tra số lượng tồn kho
    if ($variant->quantity < $request->quantity) {
        return response()->json(['message' => 'Không đủ hàng trong kho'], 400);
    }



    public function addToCart(Request $request)
    {
        $product = Product::find($request->product_id);

        if ($product) {
            $cartItem = Cart::where('product_id', $product->id)->first();
            if ($cartItem) {
                // If the product is already in the cart, increase the quantity
                $cartItem->quantity += $request->quantity;
            } else {
                // If the product is not in the cart, add it
                $cartItem = new Cart();
                $cartItem->product_id = $product->id;
                $cartItem->name = $product->name;
                $cartItem->price = $product->price;
                $cartItem->quantity = $request->quantity;
                $cartItem->image = $product->image;
            }
            $cartItem->save();
        }

        return redirect()->route('home.index');
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)

    // Thêm vào giỏ hàng hoặc cập nhật số lượng nếu đã tồn tại
    $cartItem = Cart::updateOrCreate(
        [
            'id_user' => $user->id,
            'id_variant' => $variant->id
        ],
        [
            'quantity' => $request->quantity,
            'price' => $variant->price
        ]
    );

    return response()->json([
        'message' => 'Sản phẩm đã được thêm vào giỏ hàng',
        'cartItem' => $cartItem
    ]);
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
