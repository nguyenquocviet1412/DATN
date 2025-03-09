<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Lấy 8 sản phẩm mới nhất có ảnh
        $products = Product::with(['variants.images'])->latest()->take(8)->get();
        $cartItems = Cart::take(3)->get(); // Lấy tất cả các mục trong giỏ hàng

        return view('home.index', compact('products', 'cartItems'));
    }



    public function login()
    {
        //
        return view("home.login");
    }

    public function register()
    {
        //
        return view("home.register");
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
