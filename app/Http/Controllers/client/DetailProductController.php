<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\Rate;
use App\Models\Size;
use App\Models\Variant;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DetailProductController extends Controller
{
    public function show($id)
    {
        $product = Product::with(['variants.color', 'variants.size', 'rates'])->findOrFail($id);

        // Tăng số lượt xem mỗi khi người dùng vào xem chi tiết
        $product->increment('view');

        $categories = Category::all();
        $colors = Color::all();
        $sizes = Size::all();

        // Tính toán điểm trung bình đánh giá và số lượng đánh giá
        $averageRating = $product->rates->avg('rating');
        $reviewsCount = $product->rates->count();

        // Lấy các sản phẩm liên quan cùng danh mục
        $relatedProducts = Product::where('id_category', $product->category_id)
                                  ->where('id', '!=', $product->id)
                                  ->take(4)
                                  ->get();

        return view('home.detailproduct', compact('product', 'categories', 'colors', 'sizes', 'averageRating', 'reviewsCount', 'relatedProducts'));
    }
}