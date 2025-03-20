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
        $product = Product::with(['variants.color', 'variants.size', 'rates.user'])->findOrFail($id);

        // Tăng số lượt xem mỗi khi người dùng vào xem chi tiết
        $product->increment('view');

        $categories = Category::all();
        $colors = Color::all();
        $sizes = Size::all();

        // Tính toán điểm trung bình đánh giá và số lượng đánh giá
        $averageRating = $product->rates->avg('rating');
        $reviewsCount = $product->rates->count();

        // Tính toán số lượng đánh giá theo từng số sao
        $starCounts = [
            5 => $product->rates->where('rating', 5)->count(),
            4 => $product->rates->where('rating', 4)->count(),
            3 => $product->rates->where('rating', 3)->count(),
            2 => $product->rates->where('rating', 2)->count(),
            1 => $product->rates->where('rating', 1)->count(),
        ];

        // Lấy các sản phẩm liên quan cùng danh mục
        $relatedProducts = Product::where('id_category', $product->id_category)
                                  ->where('id', '!=', $product->id)
                                  ->take(4)
                                  ->get()
                                  ->map(function ($relatedProduct) {
                                      $relatedProduct->average_rating = $relatedProduct->rates->avg('rating');
                                      return $relatedProduct;
                                  });

        return view('home.detailproduct', compact('product', 'categories', 'colors', 'sizes', 'averageRating', 'reviewsCount', 'starCounts', 'relatedProducts'));
    }
}