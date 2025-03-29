@extends('admin.layout')

@section('content')
    <div class="row">
        <!--Left-->
        <div class="col-md-12 col-lg-6">
          <div class="row">
            <!-- Tổng khách hàng -->
            <div class="col-md-6">
              <div class="widget-small primary coloured-icon"><i class='icon bx bxs-user-account fa-3x'></i>
                <div class="info">
                  <h4>Tổng khách hàng</h4>
                  <p><b><?= $totalUsers ?> khách hàng</b></p>
                  <p class="info-tong">Tổng số khách hàng được quản lý.</p>
                </div>
              </div>
            </div>

            <!-- Tổng sản phẩm -->
            <div class="col-md-6">
              <div class="widget-small info coloured-icon"><i class='icon bx bxs-data fa-3x'></i>
                <div class="info">
                  <h4>Tổng sản phẩm</h4>
                  <p><b><?= $totalProducts ?> sản phẩm</b></p>
                  <p class="info-tong">Tổng số sản phẩm được quản lý.</p>
                </div>
              </div>
            </div>

            <!-- Tổng đơn hàng -->
            <div class="col-md-6">
              <div class="widget-small warning coloured-icon"><i class='icon bx bxs-shopping-bags fa-3x'></i>
                <div class="info">
                  <h4>Tổng đơn hàng</h4>
                  <p><b><?= $totalOrders ?> đơn hàng</b></p>
                  <p class="info-tong">Tổng số hóa đơn bán hàng trong tháng.</p>
                </div>
              </div>
            </div>

            <!-- Sắp hết hàng -->
            <div class="col-md-6">
              <div class="widget-small danger coloured-icon"><i class='icon bx bxs-error-alt fa-3x'></i>
                <div class="info">
                  <h4>Sắp hết hàng</h4>
                  <p><b><?= $lowStockProducts ?> sản phẩm</b></p>
                  <p class="info-tong">Cảnh báo hết cần nhập thêm.</p>
                </div>
              </div>
            </div>

            <!-- Tình trạng đơn hàng -->
            <div class="col-md-12">
              <div class="tile">
                <h3 class="tile-title">Tình trạng đơn hàng</h3>
                <div>
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th>ID đơn hàng</th>
                        <th>Tên khách hàng</th>
                        <th>Tổng tiền</th>
                        <th>Trạng thái</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($orderStatusList as $order)
                        <tr>
                            <td>{{ $order->order_code }}</td>
                            <td>{{ $order->user_name }}</td>
                            <td>{{ number_format($order->total_price, 0, ',', '.') }} đ</td>
                            <td class="border px-4 py-2">
                                @switch($order->payment_status)
                                    @case('pending')
                                        <span class="badge bg-warning text-dark">Chờ xử lý</span>
                                        @break
                                    @case('confirmed')
                                        <span class="badge bg-success">Đã xác nhận</span>
                                        @break
                                    @case('preparing')
                                        <span class="badge bg-info text-dark">Đang chuẩn bị</span>
                                        @break
                                    @case('handed_over')
                                        <span class="badge bg-warning text-dark">Đã bàn giao</span>
                                        @break
                                    @case('shipping')
                                        <span class="badge bg-info text-white">Đang vận chuyển</span>
                                        @break
                                    @case('completed')
                                        <span class="badge bg-success text-white">Hoàn thành</span>
                                        @break
                                    @case('cancelled')
                                        <span class="badge bg-danger text-white">Đã hủy</span>
                                        @break
                                    @case('failed')
                                        <span class="badge bg-dark text-white">Thất bại</span>
                                        @break
                                    @case('return_processing')
                                        <span class="badge bg-danger text-dark">Xử lý hoàn tiền</span>
                                        @break
                                    @case('refunded')
                                        <span class="badge bg-secondary text-white">Đã hoàn tiền</span>
                                        @break
                                    @default
                                        <span class="badge bg-secondary text-white">Không xác định</span>
                                @endswitch
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                  </table>
                  <div class="d-flex justify-content-center">
                    {{ $orderStatusList->links() }}
                </div>
                </div>
              </div>
            </div>
            <!-- Khách hàng mới -->
            <div class="col-md-12">
              <div class="tile">
                <h3 class="tile-title">Khách hàng mới</h3>
                <div>
                  <table class="table table-hover">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>Tên khách hàng</th>
                        <th>Email</th>
                        <th>Số điện thoại</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($newUsers as $user): ?>
                        <tr>
                          <td><?= $user['id'] ?></td>
                          <td><?= $user['fullname'] ?></td>
                          <td><?= $user['email'] ?></td>
                          <td><span class="tag tag-success"><?= $user['phone'] ?></span></td>
                        </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>

          </div>
        </div>

        <!--Right-->
        <div class="card col-md-12 col-lg-6">
            <div class="card-header">Biểu đồ doanh thu và đơn hàng</div>
            <div class="card-body">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var ctx = document.getElementById("revenueChart").getContext("2d");
        var revenueChart = new Chart(ctx, {
            type: "bar",
            data: {
                labels: {!! json_encode($labels) !!},
                datasets: [
                    {
                        label: "Doanh thu (VND)",
                        data: {!! json_encode($sales) !!},
                        backgroundColor: "rgba(54, 162, 235, 0.7)",
                        borderColor: "rgba(54, 162, 235, 1)",
                        borderWidth: 1,
                        yAxisID: 'y-left'
                    },
                    {
                        label: "Số đơn hàng",
                        data: {!! json_encode($orders) !!},
                        backgroundColor: "rgba(255, 99, 132, 0.8)",
                        borderColor: "rgba(255, 99, 132, 1)",
                        borderWidth: 1,
                        yAxisID: 'y-right',
                        barThickness: 30 // Làm cột đơn hàng to hơn
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
                            drawOnChartArea: false // Không hiển thị lưới bên phải để dễ nhìn hơn
                        }
                    }
                }
            }
        });
    });
</script>
<style>
    .tile-body table {
        font-size: 14px; /* Giảm cỡ chữ */
    }
    .tile-body th, .tile-body td {
        padding: 6px 10px; /* Giảm khoảng cách giữa các ô */
    }
    .tile {
        padding: 10px; /* Giảm padding bên trong */
    }
    .tile-body {
        max-height: 250px; /* Giới hạn chiều cao bảng */
        overflow-y: auto; /* Thêm thanh cuộn nếu cần */
    }
</style>



    </main>

@endsection
