<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Color;
use App\Models\Size;
use App\Models\Variant;
use Illuminate\Support\Facades\Auth;
use App\Models\Favorite;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all(); // Lấy danh sách danh mục
        $colors = Color::all(); // Lấy danh sách màu sắc
        $sizes = Size::all(); // Lấy danh sách kích thước

        $products = Product::query();

        // Lọc theo danh mục
        if ($request->has('id_category')) {
            $products->where('id_category', $request->id_category);
        }

        // Lọc theo khoảng giá
        if ($request->has('max_price')) {
            $products->where('price', '<=', $request->max_price);
        }

        // Lọc theo màu sắc
        if ($request->has('id_color')) {
            $products->whereHas('variants', function ($query) use ($request) {
                $query->whereIn('color_id', (array) $request->id_color);
            });
        }

        // Lọc theo kích thước
        if ($request->has('id_size')) {
            $products->whereHas('variants', function ($query) use ($request) {
                $query->whereIn('size_id', (array) $request->id_size);
            });

        }
        // Tìm kiếm theo từ khóa
        if ($request->has('search') && $request->search != '') {
            $products->where('name', 'like', '%' . $request->search . '%');
        }
        $products = $products->paginate(9);

        $favoriteProductIds = Auth::check() ? favorite::where('id_user', Auth::id())->pluck('id_product')->toArray() : [];

        return view('home.shop', [
            'categories' => $categories,
            'colors' => $colors,
            'sizes' => $sizes,
            'products' => $products,
            'favoriteProductIds' => $favoriteProductIds, // Truyền biến này sang view
        ]);
    }
}
