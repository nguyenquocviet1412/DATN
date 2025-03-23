<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Color;
use App\Models\Size;
use App\Models\Variant;
use App\Models\Product_image;
use Illuminate\Support\Facades\Auth;
use App\Models\Favorite;

class ShopController extends Controller
{
    public function index(Request $request)
{
    $categories = Category::all();
    $colors = Color::all();
    $sizes = Size::all();

    // Truy vấn sản phẩm dựa trên biến thể
    $products = Product::whereHas('variants', function ($query) use ($request) {

        // Lọc theo màu sắc
        if ($request->filled('id_color')) {
            $selectedColors = is_array($request->id_color) ? $request->id_color : [$request->id_color];
            $query->whereIn('id_color', $selectedColors);
        }

        // Lọc theo kích thước
        if ($request->filled('id_size')) {
            $selectedSizes = is_array($request->id_size) ? $request->id_size : [$request->id_size];
            $query->whereIn('id_size', $selectedSizes);
        }
    });

    // Lọc theo danh mục (ngoài biến thể)
    if ($request->filled('id_category')) {
        $products->where('id_category', $request->id_category);
    }

    // Lọc theo khoảng giá
    if ($request->filled('max_price') && is_numeric($request->max_price)) {
        $products->where('price', '<=', (int) $request->max_price);
    }

    // Tìm kiếm theo từ khóa
    if ($request->filled('search')) {
        $products->where('name', 'like', '%' . $request->search . '%');
    }

        // **Sắp xếp sản phẩm**
        $sort_by = $request->input('sort_by', 'default');
        switch ($sort_by) {
            case 'name_asc':
                $products->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $products->orderBy('name', 'desc');
                break;
            case 'price_asc':
                $products->orderByRaw('CAST(price AS UNSIGNED) ASC');
                break;
            case 'price_desc':
                $products->orderByRaw('CAST(price AS UNSIGNED) DESC');
                break;
            default:
                $products->orderBy('created_at', 'desc'); // Mặc định: sản phẩm mới nhất
                break;
        }
    // Trả về danh sách sản phẩm
    $products = $products->distinct()->paginate(9)->appends(request()->query());

    // Lấy danh sách sản phẩm yêu thích của người dùng (nếu có)
    $favoriteProductIds = Auth::check() ? Favorite::where('id_user', Auth::id())->pluck('id_product')->toArray() : [];
        
    return view('home.shop', compact('categories', 'colors', 'sizes', 'products', 'favoriteProductIds'));
}

}
