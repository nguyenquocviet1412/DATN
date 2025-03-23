@extends('master.main')
@section('title', 'Chi tiết đơn hàng')
@section('main')

<main>
    <div class="container py-5">
        <div class="text-center mb-4">
            <h2 class="fw-bold">Chi tiết đơn hàng <span class="text-primary">#{{ $order->id }}</span></h2>
        </div>

        <!-- Thông tin đơn hàng -->
        <div class="card shadow-lg p-4 mb-4">
            <h4 class="text-primary">🛒 Thông tin đơn hàng</h4>
            <table class="table">
                <tr>
                    <th>📅 Ngày đặt hàng:</th>
                    <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                </tr>
                <tr>
                    <th>💳 Phương thức thanh toán:</th>
                    <td class="text-uppercase">{{ $order->payment_method }}</td>
                </tr>
                <tr>
                    <th>📦 Trạng thái đơn hàng:</th>
                    <td>
                        <span class="badge bg-{{ $order->payment_status == 'completed' ? 'success' : 'warning' }}">
                            {{ ucfirst(str_replace('_', ' ', $order->payment_status)) }}
                        </span>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Thông tin người đặt và nhận hàng -->
        <div class="row">
            <div class="col-md-6">
                <div class="card shadow p-4 mb-4">
                    <h4 class="text-success">👤 Thông tin người đặt hàng</h4>
                    <table class="table">
                        <tr>
                            <th>Họ tên:</th>
                            <td>{{ $order->user->fullname }}</td>
                        </tr>
                        <tr>
                            <th>📞 Điện thoại:</th>
                            <td>{{ $order->user->phone }}</td>
                        </tr>
                        <tr>
                            <th>✉️ Email:</th>
                            <td>{{ $order->user->email }}</td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card shadow p-4 mb-4">
                    <h4 class="text-danger">🚚 Thông tin người nhận</h4>
                    <table class="table">
                        <tr>
                            <th>Họ tên:</th>
                            <td>{{ $order->fullname ?? $order->user->fullname }}</td>
                        </tr>
                        <tr>
                            <th>📞 Điện thoại:</th>
                            <td>{{ $order->phone ?? $order->user->phone }}</td>
                        </tr>
                        <tr>
                            <th>📍 Địa chỉ giao hàng:</th>
                            <td>{{ $order->shipping_address }}</td>
                        </tr>
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
                            <th>Giá</th>
                            <th>Tổng</th>
                            <th>Trạng thái</th> <!-- Cột mới -->
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->orderItems as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <img src="{{ asset($item->variant->images->first()->image_url ?? 'default-image.jpg') }}" alt="Ảnh sản phẩm" width="50">
                            </td>
                            <td>{{ $item->variant->product->name ?? 'N/A' }}</td>
                            <td>{{ $item->variant->size->size ?? '-' }}</td>
                            <td>{{ $item->variant->color->name ?? '-' }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ number_format($item->price) }}₫</td>
                            <td>{{ number_format($item->subtotal) }}₫</td>
                            <td>
                                @php
                                    $status = $item->status;
                                    $statusData = [
                                        'pending' => ['color' => 'warning', 'icon' => '⏳', 'text' => 'Chờ xử lý'],
                                        'confirmed' => ['color' => 'info', 'icon' => '✅', 'text' => 'Đã xác nhận'],
                                        'preparing' => ['color' => 'primary', 'icon' => '📦', 'text' => 'Đang chuẩn bị hàng'],
                                        'handed_over' => ['color' => 'dark', 'icon' => '📤', 'text' => 'Đã bàn giao'],
                                        'shipping' => ['color' => 'info', 'icon' => '🚚', 'text' => 'Đang vận chuyển'],
                                        'completed' => ['color' => 'success', 'icon' => '🎉', 'text' => 'Giao thành công'],
                                        'return_processing' => ['color' => 'warning', 'icon' => '🔄', 'text' => 'Đang xử lý trả hàng'],
                                        'cancelled' => ['color' => 'danger', 'icon' => '❌', 'text' => 'Đã hủy'],
                                        'failed' => ['color' => 'danger', 'icon' => '⚠️', 'text' => 'Thất bại'],
                                        'refunded' => ['color' => 'secondary', 'icon' => '💰', 'text' => 'Đã trả hàng'],
                                    ];

                                    // Kiểm tra thời gian trả hàng (trong vòng 7 ngày kể từ khi giao hàng)
                                    $orderDate = $order->updated_at;
                                    $canReturn = now()->diffInDays($orderDate) <= 7;
                                @endphp

                                <span class="badge bg-{{ $statusData[$status]['color'] ?? 'secondary' }} px-3 py-2">
                                    {!! $statusData[$status]['icon'] ?? '❓' !!} {{ $statusData[$status]['text'] ?? 'Không xác định' }}
                                </span>

                                @if ($status === 'completed' && $canReturn)
                                    <form action="{{ route('order.return-item', ['order' => $order->id, 'item' => $item->id]) }}" method="POST" class="mt-2">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Bạn có chắc muốn trả hàng sản phẩm này?')">
                                            🔄 Trả hàng
                                        </button>
                                    </form>
                                @elseif ($status === 'completed' && !$canReturn)
                                    <button type="button" class="btn btn-secondary btn-sm mt-2" disabled>
                                        ⏳ Hết hạn trả hàng
                                    </button>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        <!-- Tổng tiền -->
        <div class="text-end mt-4">
            <h3 class="text-danger">💰 Tổng đơn hàng: <strong>{{ number_format($order->total_price) }}₫</strong></h3>
        </div>

        <div class="text-center mt-4">
            <a href="{{ route('user.orders') }}" class="btn btn-secondary">🔙 Quay lại</a>
            @if ($order->payment_status == 'shipping')
            <button id="confirm-receipt" class="btn btn-success">✅ Nhận hàng thành công</button>
            @endif
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

@endsection
