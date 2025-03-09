<?php

namespace App\Providers;

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
    //Sử dụng dữ liệu cho tất cả view
    view()->composer("*",function ($view){
        //Lấy danh sách
        $categories =FacadesDB::table('categories')->get();
        $view->with(compact('categories'));
    });
    Paginator::useBootstrapFive();
}
}

