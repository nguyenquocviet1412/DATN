<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\favorite;
use App\Models\Post;
use App\Models\Product;
use App\Models\Rate;
use App\Models\Banner;
use App\Models\Order;
use App\Models\Voucher;
use Carbon\Carbon;
// use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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
            $query->where('id_category', $request->category);
        }

        // Lấy 8 sản phẩm mới nhất
        $latestProducts = Product::orderBy('created_at', 'desc')->take(8)->where('status', 'active')->get();

        // Lấy 8 sản phẩm có lượt xem nhiều nhất
        $mostViewedProducts = Product::orderBy('view', 'desc')->where('status', 'active')->take(8)->get();

        $products = $query->paginate(9);
        $categories = Category::all();

        // Lấy 4 sản phẩm bán chạy nhất
        $bestSellingProducts = Product::select('products.*', DB::raw('SUM(order_items.quantity) as total_sold'))
            ->join('variants', 'products.id', '=', 'variants.id_product')
            ->join('order_items', 'variants.id', '=', 'order_items.id_variant')
            ->where('products.status', 'active')
            ->groupBy('products.id')
            ->orderByDesc('total_sold')
            ->take(4)
            ->get();

        $products = $query->paginate(9);
        $categories = Category::all();

        // Lấy 4 sản phẩm được đánh giá tốt nhất
        $topRatedProducts = Product::select('products.*', DB::raw('AVG(rates.rating) as avg_rating'))
            ->join('rates', 'products.id', '=', 'rates.id_product')
            ->groupBy('products.id')
            ->orderByDesc('avg_rating')
            ->take(4)
            ->where('products.status', 'active')
            ->get();

        // Lấy 3 bài viết mới nhất
        $latestPosts = Post::where('status', 'published') // Lọc bài viết đang hoạt động
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();
        // Lấy 4 đánh giá 5 sao mới nhất kèm sản phẩm
        $reviews = Rate::with(['user', 'product'])
            // Lọc đánh giá 5 sao và 4 sao
            ->where('rating', '>=', 4)
            ->whereHas('product', function ($query) {
                $query->where('status', 'active');
            })
            ->latest() // Lấy mới nhất
            ->take(5) // Giới hạn 5 đánh giá
            ->get();
        // Lấy danh sách sản phẩm yêu thích của người dùng
        $favoriteProductIds = Auth::check() ? favorite::where('id_user', Auth::id())->pluck('id_product')->where('status', 'active')->toArray() : [];
        //Lấy danh sách bannner
        $banners = Banner::where('status', 1)->get();

        return view('home.index',
        compact('products', 'categories', 'latestProducts', 'mostViewedProducts', 'bestSellingProducts', 'topRatedProducts', 'latestPosts', 'favoriteProductIds', 'reviews','banners'));

    }

    public function count()
    {
        $count = Cart::getContent()->count();
        return response()->json(['count' => $count]);
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
    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('products.show', compact('product'));
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
