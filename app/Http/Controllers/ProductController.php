<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    public function index(Request $request)
    {

        $query = Product::query();
        // Chỉ lấy sản phẩm đang hoạt động
        $query->where('status', 'active');

        // Tìm kiếm theo tên sản phẩm
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Lọc theo danh mục
        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }
        // Lọc danh mục
        if ($request->filled('id_category')) {
            $query->where('id_category', $request->id_category);
        }


        // Sắp xếp theo giá, lượt xem hoặc yêu thích
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'price_asc':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('price', 'desc');
                    break;
                case 'views':
                    $query->orderBy('views', 'desc');
                    break;
                case 'favorites':
                    $query->orderBy('favorites', 'desc');
                    break;
            }
        }

        $products = $query->paginate(9);
        $categories = Category::all();

        return view('home.index', compact('products', 'categories'));
    }
}
