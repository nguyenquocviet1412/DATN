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
                  <p class="info-tong">Số sản phẩm cảnh báo hết cần nhập thêm.</p>
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
                        @foreach ($orders as $order)
                        <tr>
                            <td>{{ $order->order_code }}</td>
                            <td>{{ $order->user_name }}</td>
                            <td>{{ number_format($order->total_price, 0, ',', '.') }} đ</td>
                            <td class="border px-4 py-2">
                                @switch($order->payment_status)
                                    @case('completed')
                                        <span class="status-label status-completed">Hoàn thành</span>
                                        @break
                                    @case('pending')
                                        <span class="status-label status-pending">Chờ xử lý</span>
                                        @break
                                    @case('failed')
                                        <span class="status-label status-failed">Thất bại</span>
                                        @break
                                    @default
                                        <span>Không xác định</span>
                                @endswitch
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                  </table>
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
        <div class="col-md-12 col-lg-6">
            <h2 class="chart-title">Thống kê doanh thu</h2>
            <canvas id="revenueChart"></canvas>

            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                document.addEventListener("DOMContentLoaded", function () {
                    var ctx = document.getElementById('revenueChart').getContext('2d');

                    var monthlyRevenue = @json($monthlyRevenue);

                    var labels = [];
                    var data = [];

                    monthlyRevenue.forEach(item => {
                        labels.push("Tháng " + item.month);
                        data.push(item.total);
                    });

                    new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Doanh thu (VND)',
                                data: data,
                                backgroundColor: 'rgba(255, 193, 7, 0.8)',
                                borderColor: 'rgba(255, 193, 7, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                });
            </script>
      </div>

      <div class="text-center" style="font-size: 13px">
        <p><b>Copyright
            <script>document.write(new Date().getFullYear());</script> Phần mềm quản lý bán hàng | Dev By Trường
          </b></p>
      </div>
    </main>

@endsection
