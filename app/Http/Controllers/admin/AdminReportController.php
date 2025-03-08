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
        // Lấy tổng số nhân viên
        $totalEmployees = Employee::where('role', 'staff')->count();

        // Lấy tổng số sản phẩm (biến thể)
        $totalProducts = Variant::count();

        // Lấy tổng số đơn hàng
        $totalOrders = Order::count();

        // Lấy tổng thu nhập từ order_items
        $totalRevenue = Order_item::join('variants', 'order_items.id_variant', '=', 'variants.id')
            ->sum(DB::raw('order_items.quantity * variants.price'));

        // Lấy số nhân viên mới trong tháng này
        $newEmployees = Employee::where('role', 'staff')
            ->whereMonth('created_at', Carbon::now()->month)
            ->count();

        // Lấy số sản phẩm hết hàng
        $outOfStockProducts = Variant::where('quantity', 0)->count();

        // Lấy số đơn hàng bị hủy (status = 'cancelled')
        $cancelledOrders = Order::where('payment_status', 'failed')->count();

        // Lấy danh sách sản phẩm bán chạy (dựa vào số lượng bán)
        $bestSellingProducts = Order_item::select(
            'variants.id',
            'products.name AS product_name', // Lấy tên sản phẩm từ bảng products
            'variants.price',
            'categories.name AS category_name',
            DB::raw('SUM(order_items.quantity) as total_quantity')
            )
            ->join('variants', 'order_items.id_variant', '=', 'variants.id')
            ->join('products', 'variants.id_product', '=', 'products.id') // Join bảng products
            ->join('categories', 'products.id_category', '=', 'categories.id') // Join qua bảng products
            ->groupBy('variants.id', 'products.name', 'variants.price', 'categories.name')
            ->orderByRaw('SUM(order_items.quantity) DESC')
            ->limit(5)
            ->get();
        // Lấy danh sách sản phẩm đã hết hàng
        $outOfStockList = Variant::where('quantity', 0)
            ->join('products', 'variants.id_product', '=', 'products.id') // Liên kết với products
            ->join('categories', 'products.id_category', '=', 'categories.id') // Liên kết với categories
            ->select('variants.*', 'products.name as product_name', 'categories.name as category_name')
            ->get();

        // Lấy danh sách đơn hàng gần đây
        $recentOrders = Order::with([
            'user',
            'orderItems.variant.product' // Thay đổi cách gọi quan hệ
        ])
        ->orderBy('created_at', 'desc')
        ->limit(10)
        ->get();

        // Dữ liệu doanh thu hàng tháng
        $monthlyRevenue = Order_item::selectRaw('MONTH(created_at) as month, SUM(subtotal) as revenue')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('revenue', 'month')
            ->toArray();

        $month = $request->input('month', date('Y-m'));
        $startDate = Carbon::parse($month . '-01')->startOfMonth();
        $endDate = Carbon::parse($month . '-01')->endOfMonth();

        $revenues = Order_item::whereBetween('created_at', [$startDate, $endDate])
            ->groupBy(DB::raw('DATE(created_at)'))
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(price * quantity) as revenue'))
            ->pluck('revenue', 'date');

            // Ghi log
            LogHelper::logAction('Vào trang doanh thu');
        // Trả dữ liệu ra view
        return view('admin.reports', compact(
            'totalEmployees',
            'totalProducts',
            'totalOrders',
            'totalRevenue',
            'newEmployees',
            'outOfStockProducts',
            'cancelledOrders',
            'bestSellingProducts',
            'outOfStockList',
            'recentOrders',
            'monthlyRevenue',
            'revenues'
        ));
    }
}
