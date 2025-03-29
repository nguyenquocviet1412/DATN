<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\LogHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use App\Models\Order_item;
use App\Models\Product;
use App\Models\Variant;
use Carbon\Carbon;
use DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Tổng người dùng
        $totalUsers = User::count();

        // Tổng sản phẩm
        $totalProducts = Product::count();

        // Tổng đơn hàng tháng hiện tại
        $totalOrders = Order::whereMonth('created_at', Carbon::now()->month)->count();

        // Tình trạng đơn hàng

        // Thống kê tình trạng đơn hàng
        $orderStatusList = Order::join('users', 'orders.id_user', '=', 'users.id')
            ->select(
                'orders.id as order_code',
                'users.fullname as user_name',
                'orders.total_price',
                'orders.payment_status'
            )
            ->orderBy('orders.id', 'desc')
            ->paginate(10);


        // Số sản phẩm sắp hết hàng (ví dụ dưới 5 sản phẩm)
        $lowStockProducts = Variant::where('quantity', '<', 5)->count();


        // Danh sách đơn hàng mới nhất
        $recentOrders = Order::with('user')->orderBy('created_at', 'desc')->limit(5)->get();

        // Người dùng mới nhất
        $newUsers = User::orderBy('created_at', 'desc')->limit(5)->get();

        // Thống kê doanh thu 6 tháng gần nhất
        // Dữ liệu doanh thu và đơn hàng theo tháng
        $monthlySales = Order::whereNotIn('payment_status', ['fail', 'refund'])
            ->selectRaw('MONTH(created_at) as month, SUM(total_price) as revenue, COUNT(id) as order_count')
            ->groupBy('month')
            ->pluck('revenue', 'month')
            ->toArray();

        $monthlyOrders = Order::whereNotIn('payment_status', ['fail', 'refund'])
            ->selectRaw('MONTH(created_at) as month, COUNT(id) as order_count')
            ->groupBy('month')
            ->pluck('order_count', 'month')
            ->toArray();
                // Chuyển dữ liệu sang dạng mảng cho Chart.js
                $labels = [];
                $sales = [];
                $orders = [];

                for ($i = 1; $i <= 12; $i++) {
                    $labels[] = "Tháng $i";
                    $sales[] = $monthlySales[$i] ?? 0;
                    $orders[] = $monthlyOrders[$i] ?? 0;
                }
        LogHelper::logAction('hiển thị trang dashboard');
        return view('admin.dashboard', compact(
            'totalUsers',
            'totalProducts',
            'totalOrders',
            'orderStatusList',
            'lowStockProducts',
            'recentOrders',
            'newUsers',
            'monthlySales',
            'monthlyOrders',
            'sales',
            'labels',
            'orders'
        ));
    }
}
