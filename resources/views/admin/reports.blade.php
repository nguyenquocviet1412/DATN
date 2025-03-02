@extends('admin.layout')

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


    <div class="col-md-6 col-lg-4">
        <div class="widget-small info coloured-icon"><i class='icon bx bxs-user-badge fa-3x'></i>
            <div class="info">
                <h4>Nhân viên mới</h4>
                <p><b>{{ $newEmployees }} nhân viên</b></p>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-4">
        <div class="widget-small warning coloured-icon"><i class='icon bx bxs-tag-x fa-3x'></i>
            <div class="info">
                <h4>Hết hàng</h4>
                <p><b>{{ $outOfStockProducts }} sản phẩm</b></p>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-4">
        <div class="widget-small danger coloured-icon"><i class='icon bx bxs-receipt fa-3x'></i>
            <div class="info">
                <h4>Đơn hàng hủy</h4>
                <p><b>{{ $cancelledOrders }} đơn hàng</b></p>
            </div>
        </div>
    </div>
</div>
<form method="GET" action="{{ route('admin.reports.index') }}" class="mb-4">
    <div class="row g-3 align-items-center">
        <div class="col-auto">
            <label for="month" class="col-form-label">Chọn tháng:</label>
        </div>
        <div class="col-auto">
            <input type="month" id="month" name="month" class="form-control" value="{{ request('month') }}">
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary">Lọc</button>
        </div>
    </div>
</form>

<table class="table table-striped table-bordered">
    <thead class="table-dark">
        <tr>
            <th>Ngày</th>
            <th>Doanh thu</th>
        </tr>
    </thead>
    <tbody>
        @foreach($revenues as $date => $revenue)
            <tr>
                <td>{{ $date }}</td>
                <td>{{ number_format($revenue, 0, ',', '.') }} đ</td>
            </tr>
        @endforeach
    </tbody>
</table>

<!-- SẢN PHẨM BÁN CHẠY -->
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

<!-- BIỂU ĐỒ THỐNG KÊ -->
<div class="row">
    <div class="col-md-8">
        <div class="tile">
            <h3 class="tile-title">DOANH THU HÀNG THÁNG</h3>
            <canvas id="lineChart"></canvas>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var monthlyRevenue = @json(array_values($monthlyRevenue));
    var labels = ["Tháng 1", "Tháng 2", "Tháng 3", "Tháng 4", "Tháng 5", "Tháng 6", "Tháng 7", "Tháng 8", "Tháng 9", "Tháng 10", "Tháng 11", "Tháng 12"];

    var ctxLine = document.getElementById("lineChart").getContext("2d");
    var lineChart = new Chart(ctxLine, {
        type: "line",
        data: {
            labels: labels,
            datasets: [{
                label: "Doanh thu (VNĐ)",
                data: monthlyRevenue,
                borderColor: "rgb(75, 192, 192)",
                fill: false
            }]
        }
    });

</script>
@endsection
