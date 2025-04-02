@extends('admin.layout')
@section('title2', 'Báo cáo doanh thu')
@section('content')

<div class="row">
    <div class="col-md-6 col-lg-3">
        <div class="widget-small primary coloured-icon"><i class='icon bx bxs-user fa-3x'></i>
            <div class="info">
                <h4>Tổng Nhân viên</h4>
                <p><b>{{ $totalEmployees }} nhân viên</b></p>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="widget-small info coloured-icon"><i class='icon bx bxs-purchase-tag-alt fa-3x' ></i>
            <div class="info">
                <h4>Tổng sản phẩm</h4>
                <p><b>{{ $totalProducts }} sản phẩm</b></p>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="widget-small warning coloured-icon"><i class='icon fa-3x bx bxs-shopping-bag-alt'></i>
            <div class="info">
                <h4>Tổng đơn hàng</h4>
                <p><b>{{ $totalOrders }} đơn hàng</b></p>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="widget-small danger coloured-icon"><i class='icon fa-3x bx bxs-chart' ></i>
            <div class="info">
                <h4>Tổng thu nhập</h4>
                <p><b>{{ number_format($totalRevenue, 0, ',', '.') }} đ</b></p>
            </div>
        </div>
    </div>

</div>
<div class="row">


    <div class="col-md-6 col-lg-3">
        <div class="widget-small info coloured-icon"><i class='icon bx bxs-user-badge fa-3x'></i>
            <div class="info">
                <h4>Nhân viên mới</h4>
                <p><b>{{ $newEmployees }} nhân viên</b></p>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-3">
        <div class="widget-small warning coloured-icon"><i class='icon bx bxs-tag-x fa-3x'></i>
            <div class="info">
                <h4>Hết hàng</h4>
                <p><b>{{ $outOfStockProducts }} sản phẩm</b></p>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-3">
        <div class="widget-small danger coloured-icon"><i class='icon bx bxs-receipt fa-3x'></i>
            <div class="info">
                <h4>Đơn hàng hủy</h4>
                <p><b>{{ $cancelledOrders }} đơn hàng</b></p>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="widget-small danger coloured-icon"><i class='icon bx bxs-receipt fa-3x'></i>
            <div class="info">
                <h4>Đơn hàng hoàn</h4>
                <p><b>{{ $refundedOrders }} đơn hàng</b></p>
            </div>
        </div>
    </div>
</div>
<div class="card mb-4">
    <div class="card-header">Lọc Doanh Thu</div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <form method="GET" action="{{ route('admin.reports.index') }}">
                    <label for="date">Lọc theo ngày</label>
                    <input type="date" name="date" id="date" class="form-control"
                           value="{{ request('date') }}" max="{{ date('Y-m-d') }}">
                    <button type="submit" class="btn btn-primary mt-2">Lọc theo ngày</button>
                </form>
            </div>

            <div class="col-md-4">
                <form method="GET" action="{{ route('admin.reports.index') }}">
                    <label for="month">Lọc theo tháng</label>
                    <input type="month" name="month" id="month" class="form-control"
                           value="{{ request('month', date('Y-m')) }}" max="{{ date('Y-m') }}">
                    <button type="submit" class="btn btn-success mt-2">Lọc theo tháng</button>
                </form>
            </div>

            <div class="col-md-4">
                <form method="GET" action="{{ route('admin.reports.index') }}">
                    <label for="year">Lọc theo năm</label>
                    <select name="year" id="year" class="form-control">
                        @for ($i = date('Y'); $i >= 2000; $i--)
                            <option value="{{ $i }}" {{ request('year') == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                    <button type="submit" class="btn btn-warning mt-2">Lọc theo năm</button>
                </form>
            </div>
        </div>
    </div>
</div>
@if(request()->has('date') || request()->has('month') || request()->has('year'))
<div class="card mb-4">
    <div class="card-header">
        Bảng Doanh Thu
        @if(request()->has('date'))
            Ngày {{ request('date') }}
        @elseif(request()->has('month'))
            Tháng {{ request('month') }}
        @elseif(request()->has('year'))
            Năm {{ request('year') }}
        @endif
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>@if(request()->has('year')) Tháng @else Ngày @endif</th>
                    <th>Doanh Thu (VND)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($revenues as $key => $revenue)
                <tr>
                    <td>
                        @if(request()->has('year'))
                            Tháng {{ $key }}
                        @else
                            {{ \Carbon\Carbon::parse($key)->format('d/m/Y') }}
                        @endif
                    </td>
                    <td>{{ number_format($revenue, 0, ',', '.') }} VND</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        <a href="{{ route('admin.reports.index') }}" class="btn btn-secondary">Xóa bộ lọc</a>
    </div>
</div>
@else
<div class="card mb-4">
    <div class="card-header">Tổng Quan Doanh Thu</div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Tổng Doanh Thu</th>
                    <th>Tổng Đơn Hàng</th>
                    <th>Tổng Sản Phẩm Bán</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ number_format($totalRevenue, 0, ',', '.') }} VND</td>
                    <td>{{ $totalOrders }}</td>
                    <td>{{ $totalProductsSold }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endif

<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <div>
                <h3 class="tile-title">SẢN PHẨM BÁN CHẠY</h3>
            </div>
            <div class="tile-body">
                <table class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>Mã sản phẩm</th>
                            <th>Tên sản phẩm</th>
                            <th>Giá tiền</th>
                            <th>Danh mục</th>
                            <th>Số lượng đã bán</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bestSellingProducts as $product)
                        <tr>
                            <td>{{ $product->id }}</td>
                            <td>{{ $product->product_name }}</td>
                            <td>{{ number_format($product->price, 0, ',', '.') }} đ</td>
                            <td>{{ $product->category_name}}</td>
                            <td>{{ $product->total_quantity }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<h3 class="tile-title">BIỂU ĐỒ DOANH THU VÀ SỐ LƯỢNG ĐƠN HÀNG</h3>
<div class="row">
<div class="chart-wrapper col-6" style="width: 48%;">
    <canvas id="revenueChart"></canvas>
</div>
<div class="chart-wrapper col-6" style="width: 48%;">
    <canvas id="ordersLineChart"></canvas>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Dữ liệu từ controller
        var labels = {!! json_encode($labels) !!};
        var sales = {!! json_encode($sales) !!};
        var orders = {!! json_encode($orders) !!};

        // Biểu đồ doanh thu và đơn hàng (dạng cột)
        var revenueBarCtx = document.getElementById("revenueChart").getContext("2d");
        var revenueBarChart = new Chart(revenueBarCtx, {
            type: "bar",
            data: {
                labels: labels,
                datasets: [
                    {
                        label: "Doanh thu (VND)",
                        data: sales,
                        backgroundColor: "rgba(54, 162, 235, 0.7)",
                        borderColor: "rgba(54, 162, 235, 1)",
                        borderWidth: 1,
                        yAxisID: 'y-left'
                    },
                    {
                        label: "Số đơn hàng",
                        data: orders,
                        backgroundColor: "rgba(255, 99, 132, 0.7)",
                        borderColor: "rgba(255, 99, 132, 1)",
                        borderWidth: 1,
                        yAxisID: 'y-right',
                        barThickness: 30
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    },
                    'y-left': {
                        type: 'linear',
                        position: 'left',
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: "Doanh thu (VND)"
                        }
                    },
                    'y-right': {
                        type: 'linear',
                        position: 'right',
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: "Số đơn hàng"
                        },
                        grid: {
                            drawOnChartArea: false
                        }
                    }
                }
            }
        });

        // Biểu đồ doanh thu và đơn hàng (dạng đường)
        var revenueLineCtx = document.getElementById("ordersLineChart").getContext("2d");
        var revenueLineChart = new Chart(revenueLineCtx, {
            type: "line",
            data: {
                labels: labels,
                datasets: [
                    {
                        label: "Doanh thu (VND)",
                        data: sales,
                        borderColor: "rgba(54, 162, 235, 1)",
                        backgroundColor: "rgba(54, 162, 235, 0.2)",
                        borderWidth: 2,
                        yAxisID: 'y-left-line'
                    },
                    {
                        label: "Số đơn hàng",
                        data: orders,
                        borderColor: "rgba(255, 99, 132, 1)",
                        backgroundColor: "rgba(255, 99, 132, 0.2)",
                        borderWidth: 2,
                        yAxisID: 'y-right-line'
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    },
                    'y-left-line': {
                        type: 'linear',
                        position: 'left',
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: "Doanh thu (VND)"
                        }
                    },
                    'y-right-line': {
                        type: 'linear',
                        position: 'right',
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: "Số đơn hàng"
                        },
                        grid: {
                            drawOnChartArea: false
                        }
                    }
                }
            }
        });
    });
</script>
@endsection
