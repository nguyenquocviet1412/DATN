@extends('master.main')
@section('title', 'Chi tiết đơn hàng')
@section('main')

<main>
    <!-- breadcrumb area start -->
    <div class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb-wrap">
                        <nav aria-label="breadcrumb">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('home.index')}}"><i class="fa fa-home"></i></a></li>
                                <li class="breadcrumb-item "><a href="{{route('user.orders')}}">Đơn hàng</a></li>
                                <li class="breadcrumb-item active">Chi tiết đơn hàng</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb area end -->
    <div class="container py-5">
        <div class="text-center mb-4">
            <h2 class="fw-bold">Chi tiết đơn hàng <span class="text-primary">#{{ $order->id }}</span></h2>
        </div>

        <!-- Thông tin đơn hàng -->
        <div class="card shadow-lg p-4 mb-4">
            <h4 class="text-primary">🛒 Thông tin đơn hàng</h4>
            <table class="table">
                <tr><th>📅 Ngày đặt hàng:</th><td>{{ $order->created_at->format('d/m/Y H:i') }}</td></tr>
                <tr><th>💳 Phương thức thanh toán:</th><td>
                    @switch($order->payment_method)
                        @case('COD')
                        @case('cod') Thanh toán khi nhận hàng (COD) @break
                        @case('momo') Momo @break
                    @endswitch
                </td></tr>
                <tr><th>📦 Trạng thái đơn hàng:</th><td>
                    @php
                        $status = $order->payment_status;
                        $statusData = [
                            'pending' => ['color' => 'warning', 'icon' => '⏳', 'text' => 'Chờ xử lý'],
                            'confirmed' => ['color' => 'info', 'icon' => '✅', 'text' => 'Đã xác nhận'],
                            'preparing' => ['color' => 'primary', 'icon' => '📦', 'text' => 'Đang chuẩn bị'],
                            'handed_over' => ['color' => 'dark', 'icon' => '📤', 'text' => 'Đã bàn giao'],
                            'shipping' => ['color' => 'info', 'icon' => '🚚', 'text' => 'Đang vận chuyển'],
                            'completed' => ['color' => 'success', 'icon' => '🎉', 'text' => 'Giao thành công'],
                            'cancelled' => ['color' => 'danger', 'icon' => '❌', 'text' => 'Đã hủy'],
                            'failed' => ['color' => 'danger', 'icon' => '⚠️', 'text' => 'Thất bại'],
                            'return_processing' => ['color' => 'warning', 'icon' => '🔄', 'text' => 'Đang xử lý hoàn tiền'],
                            'shop_refunded' => ['color' => 'info', 'icon' => '💸', 'text' => 'Shop đã hoàn tiền'],
                            'customer_confirmed_refund' => ['color' => 'success', 'icon' => '🤝', 'text' => 'Khách xác nhận đã nhận tiền'],
                            'refunded' => ['color' => 'secondary', 'icon' => '💰', 'text' => 'Đã hoàn tiền (hoàn tất)'],
                        ];
                    @endphp
                    <span class="badge bg-{{ $statusData[$status]['color'] ?? 'secondary' }}">
                        {!! $statusData[$status]['icon'] ?? '❓' !!} {{ $statusData[$status]['text'] ?? 'Không xác định' }}
                    </span>
                </td></tr>
                <tr><th>💸 Trạng thái thanh toán:</th><td>
                    @if ($order->status == 'unpaid')
                        <span class="badge bg-danger">Chưa thanh toán</span>
                    @elseif ($order->status == 'pay')
                        <span class="badge bg-success">Đã thanh toán</span>
                    @else
                        <span class="badge bg-secondary">Không xác định</span>
                    @endif
                </td></tr>

                @if ($order->id_voucher)
                <tr><th>🎟 Mã giảm giá:</th><td><span class="badge bg-warning">{{ $order->voucher->code }}</span></td></tr>
                @endif

                <tr><th>💰 Tổng tiền chưa giảm:</th><td><strong>{{ number_format($order->total_price + $order->discount_amount,0, ',', '.') }} VNĐ</strong></td></tr>
                <tr><th>💲 Số tiền giảm giá:</th><td>- {{ number_format($order->discount_amount,0, ',', '.') }} VNĐ</td></tr>
                <tr><th>🤑 Tổng tiền đơn hàng:</th><td><strong>{{ number_format($order->total_price,0, ',', '.') }} VNĐ</strong> (Đã tính phí vận chuyển)</td></tr>
            </table>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card shadow p-4 mb-4">
                    <h4 class="text-success">👤 Thông tin người đặt hàng</h4>
                    <table class="table">
                        <tr><th>Họ tên:</th><td>{{ $order->user->fullname }}</td></tr>
                        <tr><th>📞 Điện thoại:</th><td>{{ $order->user->phone }}</td></tr>
                        <tr><th>✉️ Email:</th><td>{{ $order->user->email }}</td></tr>
                    </table>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card shadow p-4 mb-4">
                    <h4 class="text-danger">🚚 Thông tin người nhận</h4>
                    <table class="table">
                        <tr><th>Họ tên:</th><td>{{ $order->fullname ?? $order->user->fullname }}</td></tr>
                        <tr><th>📞 Điện thoại:</th><td>{{ $order->phone ?? $order->user->phone }}</td></tr>
                        <tr><th>📍 Địa chỉ giao hàng:</th><td>{{ $order->shipping_address }}</td></tr>
                    </table>
                </div>
            </div>
        </div>

        <!-- Danh sách sản phẩm -->
            <div class="card shadow p-4">
                <h4 class="text-dark">🛍 Sản phẩm trong đơn hàng</h4>
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Hình ảnh</th>
                            <th>Sản phẩm</th>
                            <th>Size</th>
                            <th>Màu</th>
                            <th>Số lượng</th>
                            <th>Giá (sau giảm)</th>
                            <th>Tổng</th>
                            <th>Thao tác</th> <!-- Cột mới -->
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->orderItems as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                @if ($item->variant && $item->variant->images->isNotEmpty())
                                    <img src="{{ asset($item->variant->images->first()->image_url) }}" alt="Ảnh sản phẩm" width="50">
                                @else
                                    <img src="{{ asset('default-image.jpg') }}" alt="Ảnh mặc định" width="50">
                                @endif
                            </td>
                            <td>{{ $item->variant->product->name ?? 'N/A' }}</td>
                            <td>{{ $item->variant->size->size ?? '-' }}</td>
                            <td>{{ $item->variant->color->name ?? '-' }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ number_format($item->price, 0, ',', '.') }}VNĐ</td>
                            <td>{{ number_format($item->subtotal, 0, ',', '.') }}VNĐ</td>
                            <td>
                                <!-- Nút thêm đánh giá -->
                                @php
                                    $check = 0;
                                    foreach ($rating as $rate) {
                                        if ($rate->id_order_item == $item->id) {
                                            $check = 1;
                                            break;
                                        }
                                    }
                                @endphp

                                @if($check == 1)
                                <!-- Nếu đã đánh giá rồi thì không hiển thị nút -->
                                {{-- Nút mua lại --}}
                                <a href="{{route('product.show',$item->variant->id_product)}}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-shopping-cart"></i> Mua lại
                                </a>
                                @elseif ($order->payment_status == 'completed')
                                <a href="{{ route('client.rate.create', $item->id) }}" class="btn btn-custom btn-sm">
                                    <span class="btn-text">Thêm Đánh Giá</span>
                                </a>
                                @endif

                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>


        <!-- Tổng tiền -->
        <div class="text-end mt-4">
            <h3 class="text-danger">💰 Tổng đơn hàng: <strong>{{ number_format($order->total_price, 0, ',', '.') }}VNĐ</strong></h3>
        </div>

        <div class="text-center mt-4">
            <a href="{{ route('user.orders') }}" class="btn btn-secondary">🔙 Quay lại</a>
        </div>
    </div>
</main>

<script>
    document.getElementById('confirm-receipt')?.addEventListener('click', function() {
        if (confirm('Bạn có chắc chắn đã nhận hàng thành công?')) {
            fetch(`/order/confirm-receipt/{{ $order->id }}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                }).then(response => response.json())
                .then(data => {
                    if (data.message === 'Cập nhật thành công') {
                        alert('Đơn hàng đã được cập nhật thành công.');
                        location.reload();
                    } else {
                        alert('Có lỗi xảy ra, vui lòng thử lại.');
                    }
                });
        }
    });
</script>
<style>
    /* Nút thêm đánh giá đẹp và thú vị */
.btn-custom {
    background: linear-gradient(135deg, #ff7e5f, #feb47b);
    color: #fff;
    border: none;
    padding: 12px 24px;
    border-radius: 50px;
    font-size: 16px;
    font-weight: bold;
    position: relative;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
    text-transform: uppercase;
    overflow: hidden;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.15);
}

.btn-custom:hover {
    background: linear-gradient(135deg, #ff6a00, #ff8c00);
    transform: translateY(-5px);
    box-shadow: 0px 6px 20px rgba(0, 0, 0, 0.2);
}

/* Hiệu ứng khi hover */
.btn-custom .btn-text {
    background: linear-gradient(90deg, #000, #fff);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.btn-custom:disabled {
    background: #ddd;
    color: #aaa;
    cursor: not-allowed;
}

/* Thêm bóng đổ cho nút khi hover */
.btn-custom:active {
    transform: translateY(2px);
}

/* Nếu đã đánh giá thì nút sẽ không hiển thị */
.btn-custom.hidden {
    display: none;
}

</style>

@endsection
