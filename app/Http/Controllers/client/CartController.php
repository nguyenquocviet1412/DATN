<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Product_image;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $product_images = Product_image::take(1)->get(); // Lấy 1 ảnh của sản phẩm để hiển thị
        $products = Product::take(1)->get(); // Lấy 1 sản phẩm để hiển thị
        $cartItems = Cart::take(3)->get(); // Lấy 3 mục đầu tiên trong giỏ hàng
        $cartTotal = $cartItems->sum(function ($item) {
            return $item->price * $item->quantity;
        });
        $shippingCost = 10; // Ví dụ về chi phí vận chuyển

        return view('home.Cart', compact('cartItems', 'cartTotal', 'shippingCost', 'products', 'product_images'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $product = Product::find($request->product_id);

        $cartItem = new Cart();
        $cartItem->product_id = $product->id;
        $cartItem->name = $product->name;
        $cartItem->price = $product->price;
        $cartItem->quantity = $request->quantity;
        $cartItem->image = $product->image;
        $cartItem->save();

        return redirect()->route('cart.index');
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
    {
        $cartItem = Cart::find($id);
        $cartItem->quantity = $request->quantity;
        $cartItem->save();

        return redirect()->route('cart.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $cartItem = Cart::find($id);
        $cartItem->delete();

        return redirect()->route('cart.index');
    }

    /**
     * Apply a coupon code to the cart.
     */
    public function applyCoupon(Request $request)
    {
        // Example coupon application logic
        $couponCode = $request->coupon_code;
        // Apply coupon logic here

        return redirect()->route('cart.index');
    }
}
