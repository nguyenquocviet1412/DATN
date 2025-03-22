<?php

namespace App\Providers;

use App\Models\Cart;
use Auth;
use DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Category;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB as FacadesDB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
{
    // Sử dụng dữ liệu cho tất cả view
    view()->composer("*", function ($view) {
        // Lấy danh sách danh mục
        $categories = FacadesDB::table('categories')->get();

        // Lấy giỏ hàng nếu có người dùng đăng nhập
        $cartItems = collect(); // Gán giá trị mặc định là một collection rỗng

        $user = Auth::user();
        if ($user) { // Kiểm tra xem có người dùng đăng nhập không
            $cartItems = Cart::where('id_user', $user->id)
                ->with(['variant.product', 'variant.color', 'variant.size', 'variant.images'])
                ->get();
        }

        $view->with(compact('categories', 'cartItems'));
    });

    Paginator::useBootstrapFive();
}

}

