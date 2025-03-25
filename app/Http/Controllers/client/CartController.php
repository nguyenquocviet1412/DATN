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

    // Kiểm tra xem sản phẩm có trong giỏ hàng chưa
    $cartItem = Cart::where('id_user', $user->id)
                    ->where('id_variant', $variant->id)
                    ->first();

    if ($cartItem) {
        // Nếu sản phẩm đã có trong giỏ hàng, cộng dồn số lượng mới
        $newQuantity = $cartItem->quantity + $request->quantity;

        // Kiểm tra số lượng tồn kho
        if ($newQuantity > $variant->quantity) {
            return response()->json(['message' => 'Không đủ hàng trong kho'], 400);
        }

        $cartItem->update(['quantity' => $newQuantity]);
    } else {
        // Nếu chưa có, thêm mới
        if ($variant->quantity < $request->quantity) {
            return response()->json(['message' => 'Không đủ hàng trong kho'], 400);
        }

        $cartItem = Cart::create([
            'id_user' => $user->id,
            'id_variant' => $variant->id,
            'quantity' => $request->quantity,
            'price' => $variant->price
        ]);
    }

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
        $variant = Variant::findOrFail($cartItem->id_variant);
    if (!$cartItem) {
        return response()->json(['message' => 'Sản phẩm không tồn tại trong giỏ hàng'], 400);
    }

    if ($variant->quantity < $request->quantity) {
        return response()->json([
            'message' => 'Số lượng trong kho không đủ',
            'max_quantity' => $variant->quantity
        ], 400);
    }

        $cartItem->update(['quantity' => $request->quantity]);

        // Tính tổng giá trị giỏ hàng
        $cartItems = Cart::where('id_user', Auth::id())->get();
        $subtotal = $cartItems->sum(fn($item) => $item->quantity * $item->variant->price);
        $total = $subtotal + 30000; // Cộng phí vận chuyển

        return response()->json([
            'message' => 'Cập nhật thành công',
            'cartItem' => $cartItem,
            'subtotal' => $subtotal,
            'total' => $total
        ]);
    }

    // Xóa sản phẩm khỏi giỏ hàng
    public function remove($id)
    {
        $cartItem = Cart::findOrFail($id);
        $cartItem->delete();

         // Tính tổng giá trị giỏ hàng
        $cartItems = Cart::where('id_user', Auth::id())->get();
        $subtotal = $cartItems->sum(fn($item) => $item->quantity * $item->variant->price);
        $total = $subtotal + 30000; // Cộng phí vận chuyển

        return response()->json([
            'message' => 'Xóa sản phẩm thành công',
            'cartItem' => $cartItem,
            'subtotal' => $subtotal,
            'total' => $total
        ]);
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
    //Cập nhật biến thể sản phẩm
    public function updateVariant(Request $request)
    {
        $cartItem = Cart::find($request->cart_id);
        $variant = Variant::find($request->variant_id);

        if (!$cartItem || !$variant || $variant->quantity == 0) {
            return redirect()->back()->with('error', 'Biến thể không hợp lệ hoặc hết hàng.');
        }

        $cartItem->id_variant = $variant->id;
        $cartItem->quantity = min($cartItem->quantity, $variant->quantity); // Giới hạn số lượng theo tồn kho
        $cartItem->save();

        return redirect()->back()->with('success', 'Cập nhật biến thể thành công.');
    }

    public function removemini($id)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->back()->with('error', 'Bạn chưa đăng nhập.');
        }

        $cartItem = Cart::where('id', $id)->where('id_user', $user->id)->first();

        if (!$cartItem) {
            return redirect()->back()->with('error', 'Sản phẩm không tồn tại trong giỏ hàng.');
        }

        $cartItem->delete();

        return redirect()->back()->with('success', 'Sản phẩm đã được xóa khỏi giỏ hàng.');
    }

}

