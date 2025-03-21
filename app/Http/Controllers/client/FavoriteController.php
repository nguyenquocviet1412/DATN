<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $favoriteItems = favorite::where('id_user', $user->id)
            ->with(['variant.product', 'variant.images' , 'variant.price'])
            ->get();
        $favoriteProductIds = $favoriteItems->pluck('id_product')->toArray();
        return view('home.favorite', compact('favoriteItems', 'favoriteProductIds'));
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
        $user = Auth::user();
        $productId = $request->input('product_id');

        // Kiểm tra xem sản phẩm đã có trong danh sách yêu thích chưa
        $favoriteItem = favorite::where('id_user', $user->id)->where('id_product', $productId)->first();

        if (!$favoriteItem) {
            // Thêm sản phẩm vào danh sách yêu thích
            favorite::create([
                'id_user' => $user->id,
                'id_product' => $productId,
            ]);
            return response()->json(['success' => true, 'added' => true, 'message' => 'Sản phẩm đã được thêm vào danh sách yêu thích!']);
        } else {
            // Xóa sản phẩm khỏi danh sách yêu thích
            $favoriteItem->delete();
            return response()->json(['success' => true, 'added' => false, 'message' => 'Sản phẩm đã được xóa khỏi danh sách yêu thích!']);
        }
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
    public function remove(string $id)
    {
        $user = Auth::user();
        $favoriteItem = favorite::where('id_user', $user->id)->where('id', $id)->first();

        if ($favoriteItem) {
            $favoriteItem->delete();
            return redirect()->back()->with('success', 'Xóa sản phẩm khỏi danh sách yêu thích thành công!');
        }

        return redirect()->back()->with('error', 'Xóa sản phẩm khỏi danh sách yêu thích thất bại!');
    }
}
