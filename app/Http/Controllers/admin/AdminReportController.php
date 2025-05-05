<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\LogHelper;
use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Variant;
use App\Models\Order;
use App\Models\Order_item;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdminReportController extends Controller
{
    public function index(Request $request)
    {
        // Danh sách các trạng thái không tính vào doanh thu và thống kê
        $excludedStatuses = [
            'cancelled',
            'failed',
            'refunded',
            'return_processing',
            'shop_refunded',
            'customer_confirmed_refund'
        ];

        // Tổng số nhân viên
        $totalEmployees = Employee::count();

        // Tổng số sản phẩm (biến thể)
        $totalProducts = Variant::count();

        // Tổng số sản phẩm đã bán
        $totalProductsSold = Order_item::sum('quantity');

        // Tổng số đơn hàng
        $totalOrders = Order::count();

        // Tổng doanh thu
        $totalRevenue = Order::whereNotIn('payment_status', $excludedStatuses)->sum('total_price');

        // Nhân viên mới trong tháng này
        $newEmployees = Employee::whereMonth('created_at', Carbon::now()->month)->count();

        // Đơn hàng bị hoàn
        $refundedOrders = Order_item::whereIn('status', ['return_processing', 'refunded'])->count();

        // Sản phẩm hết hàng
        $outOfStockProducts = Variant::where('quantity', 0)->count();

        // Đơn hàng bị hủy
        $cancelledOrders = Order::whereIn('payment_status', ['cancelled', 'failed'])->count();

        // Danh sách sản phẩm bán chạy
        $bestSellingProducts = Order_item::select(
            'variants.id',
            'products.name AS product_name',
            'variants.price',
            'categories.name AS category_name',
            DB::raw('SUM(order_items.quantity) as total_quantity')
        )
        ->join('variants', 'order_items.id_variant', '=', 'variants.id')
        ->join('products', 'variants.id_product', '=', 'products.id')
        ->join('categories', 'products.id_category', '=', 'categories.id')
        ->groupBy('variants.id', 'products.name', 'variants.price', 'categories.name')
        ->orderByRaw('SUM(order_items.quantity) DESC')
        ->limit(5)
        ->get();

        // Danh sách sản phẩm đã hết hàng
        $outOfStockList = Variant::where('quantity', 0)
            ->join('products', 'variants.id_product', '=', 'products.id')
            ->join('categories', 'products.id_category', '=', 'categories.id')
            ->select('variants.*', 'products.name as product_name', 'categories.name as category_name')
            ->get();

        // Đơn hàng gần đây
        $recentOrders = Order::with(['user', 'orderItems.variant.product'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Xử lý bộ lọc doanh thu
        $revenues = [];

        if ($request->has('date')) {
            $date = $request->input('date');
            $revenues = Order::whereNotIn('payment_status', $excludedStatuses)
                ->whereDate('created_at', $date)
                ->selectRaw('DATE(created_at) as date, SUM(total_price) as revenue')
                ->groupBy('date')
                ->pluck('revenue', 'date')
                ->toArray();
        } elseif ($request->has('month')) {
            $month = Carbon::parse($request->input('month'));
            $revenues = Order::whereNotIn('payment_status', $excludedStatuses)
                ->whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->selectRaw('DATE(created_at) as date, SUM(total_price) as revenue')
                ->groupBy('date')
                ->pluck('revenue', 'date')
                ->toArray();
        } elseif ($request->has('year')) {
            $year = $request->input('year');
            $revenues = Order::whereNotIn('payment_status', $excludedStatuses)
                ->whereYear('created_at', $year)
                ->selectRaw('MONTH(created_at) as month, SUM(total_price) as revenue')
                ->groupBy('month')
                ->pluck('revenue', 'month')
                ->toArray();
        }

        // Doanh thu & đơn hàng theo tháng
        $monthlySales = Order::whereNotIn('payment_status', $excludedStatuses)
            ->selectRaw('MONTH(created_at) as month, SUM(total_price) as revenue')
            ->groupBy('month')
            ->pluck('revenue', 'month')
            ->toArray();

        $monthlyOrders = Order::whereNotIn('payment_status', $excludedStatuses)
            ->selectRaw('MONTH(created_at) as month, COUNT(id) as order_count')
            ->groupBy('month')
            ->pluck('order_count', 'month')
            ->toArray();

        // Chuẩn bị dữ liệu biểu đồ
        $labels = [];
        $sales = [];
        $orders = [];

        for ($i = 1; $i <= 12; $i++) {
            $labels[] = "Tháng $i";
            $sales[] = $monthlySales[$i] ?? 0;
            $orders[] = $monthlyOrders[$i] ?? 0;
        }

        // Trả dữ liệu ra view
        return view('admin.reports', compact(
            'totalEmployees',
            'totalProducts',
            'totalOrders',
            'totalRevenue',
            'totalProductsSold',
            'newEmployees',
            'outOfStockProducts',
            'cancelledOrders',
            'refundedOrders',
            'bestSellingProducts',
            'outOfStockList',
            'recentOrders',
            'revenues',
            'sales',
            'labels',
            'orders'
        ));
    }
}
