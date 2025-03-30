<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Rate;
use Illuminate\Http\Request;

class RateController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_user' => 'required|exists:users,id',
            'id_product' => 'required|exists:products,id',
            'id_order_item' => 'required|exists:order_items,id',
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string',
        ]);

        $rate = Rate::create($validated);

        return response()->json([
            'message' => 'Đánh giá đã được thêm thành công!',
            'data' => $rate,
        ], 201);
    }
}
