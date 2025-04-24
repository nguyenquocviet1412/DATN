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
use App\Models\Rate;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();
        $colors = Color::all();
        $sizes = Size::all();

        // Bắt đầu truy vấn sản phẩm
        $products = Product::query();
        // Chỉ lấy sản phẩm đang hoạt động
        $products->where('status', 'active');

        // Lọc sản phẩm có tất cả các màu được chọn
        if ($request->filled('id_color')) {
            $selectedColors = is_array($request->id_color) ? $request->id_color : [$request->id_color];

            // Chỉ lấy sản phẩm có **tất cả** các màu trong danh sách
            foreach ($selectedColors as $color) {
                $products->whereHas('variants', function ($query) use ($color) {
                    $query->where('id_color', $color);
                });
            }
        }

        // Lọc sản phẩm có tất cả các kích thước được chọn
        if ($request->filled('id_size')) {
            $selectedSizes = is_array($request->id_size) ? $request->id_size : [$request->id_size];

            foreach ($selectedSizes as $size) {
                $products->whereHas('variants', function ($query) use ($size) {
                    $query->where('id_size', $size);
                });
            }
        }

        // Lọc theo từ khóa tìm kiếm
        if ($request->filled('search')) {
            $products->where('name', 'like', '%' . $request->search . '%');
        }

        // Lọc theo danh mục
        if ($request->filled('id_category')) {
            $products->where('id_category', $request->id_category);
        }

        // Lọc theo khoảng giá
        if ($request->filled('max_price') && is_numeric($request->max_price)) {
            $products->where('price', '<=', (int) $request->max_price);
        }

        // Lọc theo điểm đánh giá trung bình
        if ($request->filled('min_rating') && is_numeric($request->min_rating)) {
            $products->whereHas('rates', function ($query) use ($request) {
                $query->havingRaw('AVG(rating) >= ?', [(float) $request->min_rating]);
            });
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

        // Trả về danh sách sản phẩm (tránh trùng lặp)
        $products = $products->with('rates')->distinct()->paginate(9)->appends(request()->query());

        // Lấy danh sách sản phẩm yêu thích của người dùng (nếu có)
        $favoriteProductIds = Auth::check() ? Favorite::where('id_user', Auth::id())->pluck('id_product')->toArray() : [];

        return view('home.shop', compact('categories', 'colors', 'sizes', 'products', 'favoriteProductIds'));
    }
}
