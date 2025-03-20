<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use DB;

class FilterProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        // Lọc theo danh mục
        if ($request->has('category')) {
            $query->where('id_category', $request->category);
        }

        // Lọc theo giá
        if ($request->has('min_price') && $request->has('max_price')) {
            $query->whereBetween('price', [$request->min_price, $request->max_price]);
        }

        // Lọc theo từ khóa tìm kiếm
        if ($request->has('keyword')) {
            $query->where('name', 'like', '%' . $request->keyword . '%');
        }

        // Sắp xếp theo lượt xem hoặc lượt yêu thích
        if ($request->has('sort_by')) {
            if ($request->sort_by == 'view') {
                $query->orderBy('view', 'desc');
            } elseif ($request->sort_by == 'likes') {
                $query->leftJoin('favorites', 'products.id', '=', 'favorites.id_product')
                      ->selectRaw('products.*, COUNT(favorites.id) as likes')
                      ->groupBy('products.id')
                      ->orderBy('likes', 'desc');
            }
        }

        $products = $query->paginate(12);
        $categories = Category::all();

        return view('home.filter_product', compact('products', 'categories'));
    }
}
