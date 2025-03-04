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
        $orders = Order::join('order_items', 'orders.id', '=', 'order_items.id_order')
            ->join('variants', 'order_items.id_variant', '=', 'variants.id')
            ->join('users', 'orders.id_user', '=', 'users.id')
            ->select(
                'orders.id as order_code',
                'users.fullname as user_name',
                DB::raw('SUM(order_items.subtotal) as total_price'),
                'orders.payment_status'
            )
            ->groupBy('orders.id', 'users.fullname', 'orders.payment_status')
            ->orderBy('orders.created_at', 'desc')
            ->get();

        // Số sản phẩm sắp hết hàng (ví dụ dưới 5 sản phẩm)
        $lowStockProducts = Variant::where('quantity', '<', 5)->count();


        // Danh sách đơn hàng mới nhất
        $recentOrders = Order::with('user')->orderBy('created_at', 'desc')->limit(5)->get();

        // Người dùng mới nhất
        $newUsers = User::orderBy('created_at', 'desc')->limit(5)->get();

        // Thống kê doanh thu 6 tháng gần nhất
        $revenueData = Order::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(total_price) as total')
            )
            ->where('payment_status', 'completed')
            ->where('created_at', '>=', Carbon::now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month')
            ->get();
        $monthlyRevenue = Order_item::join('variants', 'order_items.id_variant', '=', 'variants.id')
            ->join('products', 'variants.id_product', '=', 'products.id')
            ->join('orders', 'order_items.id_order', '=', 'orders.id')
            ->select(
                DB::raw('MONTH(orders.created_at) as month'),
                DB::raw('SUM(order_items.quantity * order_items.price) as total')
            )
            ->whereYear('orders.created_at', Carbon::now()->year)
            ->groupBy(DB::raw('MONTH(orders.created_at)'))
            ->orderBy(DB::raw('MONTH(orders.created_at)'))
            ->get();
            // Ghi log
        LogHelper::logAction('hiển thị trang dashboard');
        return view('admin.dashboard', compact(
            'totalUsers',
            'totalProducts',
            'totalOrders',
            'orders',
            'lowStockProducts',
            'recentOrders',
            'newUsers',
            'revenueData',
            'monthlyRevenue'
        ));
    }
}
