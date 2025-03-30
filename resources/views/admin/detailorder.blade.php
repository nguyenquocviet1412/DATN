@extends('admin.layout')
@section('title', 'Chi tiết đơn hàng | Quản trị Admin')
@section('title2', 'Chi tiết đơn hàng')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="tile p-4">

            {{-- THÔNG TIN NGƯỜI ĐẶT HÀNG & NGƯỜI NHẬN HÀNG --}}
            <div class="row">
                <div class="col-md-6">
                    <h3 class="text-primary">🛒 Thông tin người đặt hàng</h3>
                    <table class="table">
                        <tr><th>Họ tên:</th><td>{{ $order->user->fullname }}</td></tr>
                        <tr><th>Phone:</th><td>{{ $order->user->phone }}</td></tr>
                        <tr><th>Email:</th><td>{{ $order->user->email }}</td></tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <h3 class="text-success">🚚 Thông tin người nhận</h3>
                    <table class="table">
                        <tr><th>Họ tên:</th><td>{{ $order->fullname ?? $order->user->fullname }}</td></tr>
                        <tr><th>Phone:</th><td>{{ $order->phone ?? $order->user->phone }}</td></tr>
                        <tr><th>Địa chỉ giao hàng:</th><td>{{ $order->shipping_address }}</td></tr>
                    </table>
                </div>
            </div>

            {{-- THÔNG TIN ĐƠN HÀNG --}}
            <h3 class="text-dark">📦 Thông tin đơn hàng</h3>
            <table class="table">
                <tr>
                    <th>🗓 Ngày đặt hàng:</th>
                    <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                </tr>
                <tr>
                    <th>💳 Phương thức thanh toán:</th>
                    <td>
                        @if ($order->payment_method == 'COD' || $order->payment_method == 'cod')
                            <span class="badge bg-secondary">Thanh toán khi nhận hàng (COD)</span>
                        @elseif ($order->payment_method == 'momo')
                            <span class="badge bg-primary">Momo</span>
                        @elseif ($order->payment_method == 'zalopay')
                            <span class="badge bg-primary">ZaloPay</span>
                        @elseif ($order->payment_method == 'bank_transfer')
                            <span class="badge bg-primary">Chuyển khoản ngân hàng</span>
                        @elseif ($order->payment_method == 'online_payment')
                            <span class="badge bg-primary">Thanh toán online</span>
                        @else
                            <span class="badge bg-primary">Thanh toán trực tuyến</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>📦 Trạng thái đơn hàng:</th>
                    <td>
                        @php
                            $statusColors = [
                                'waiting_payment' => 'bg-warning text-dark',
                                'pending' => 'bg-info',
                                'shipping' => 'bg-primary',
                                'completed' => 'bg-success',
                                'failed' => 'bg-danger'
                            ];
                        @endphp
                        <span class="badge {{ $statusColors[$order->payment_status] ?? 'bg-secondary' }}">
                            {{ ucfirst(str_replace('_', ' ', $order->payment_status)) }}
                        </span>
                    </td>
                </tr>

                {{-- Tổng tiền trước khi giảm giá --}}
                <tr>
                    <th>💰 Tổng tiền chưa giảm:</th>
                    <td><strong>{{ number_format($order->total_price + $order->discount_amount) }} VNĐ</strong></td>
                </tr>

                {{-- Hiển thị mã giảm giá nếu có --}}
                @if ($order->coupon_code)
                <tr>
                    <th>🎟 Mã giảm giá:</th>
                    <td><span class="badge bg-warning">{{ $order->coupon_code }}</span></td>
                </tr>
                @endif

                <tr>
                    <th>💲 Số tiền giảm giá:</th>
                    <td>- {{ number_format($order->discount_amount) }} VNĐ</td>
                </tr>
                <tr>
                    <th>🤑 Tổng tiền đơn hàng:</th>
                    <td><strong>{{ number_format($order->total_price) }} VNĐ </strong>(Đã tính phí vận chuyển)</td>
                </tr>
            </table>

            {{-- THÔNG TIN SẢN PHẨM --}}
            <h3 class="text-dark">🛍 Sản phẩm trong đơn hàng</h3>
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Mã SP</th>
                        <th>Tên sản phẩm</th>
                        <th>Hình ảnh</th>
                        <th>Size</th>
                        <th>Màu sắc</th>
                        <th>Số lượng</th>
                        <th>Giá</th>
                        <th>Tổng</th>
                        <th>Trạng thái</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->orderItems as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->variant->id_product }}</td>
                            <td>{{ $item->variant->product->name ?? 'N/A' }}</td>
                            <td>
                                @if ($item->variant->images->isNotEmpty())
                                    <img src="{{ asset($item->variant->images->first()->image_url) }}" alt="Ảnh sản phẩm" width="50">
                                @else
                                    <img src="{{ asset('default-image.jpg') }}" alt="Ảnh mặc định" width="50">
                                @endif
                            </td>
                            <td>{{ $item->variant->size->size ?? 'Không có' }}</td>
                            <td>{{ $item->variant->color->name ?? 'Không có' }}</td>
                            <td>{{ number_format($item->quantity) }}</td>
                            <td>{{ number_format($item->price) }} VNĐ</td>
                            <td>{{ number_format($item->subtotal) }} VNĐ</td>
                            <td class="text-center">
                                @php
                                    $status = $item->status;
                                    $statusData = [
                                        'pending' => ['color' => 'warning', 'icon' => '⏳', 'text' => 'Chờ xử lý'],
                                        'confirmed' => ['color' => 'info', 'icon' => '✅', 'text' => 'Đã xác nhận'],
                                        'preparing' => ['color' => 'primary', 'icon' => '📦', 'text' => 'Đang chuẩn bị'],
                                        'handed_over' => ['color' => 'dark', 'icon' => '📤', 'text' => 'Đã bàn giao'],
                                        'shipping' => ['color' => 'info', 'icon' => '🚚', 'text' => 'Đang vận chuyển'],
                                        'completed' => ['color' => 'success', 'icon' => '🎉', 'text' => 'Giao thành công'],
                                        'return_processing' => ['color' => 'warning', 'icon' => '🔄', 'text' => 'Đang xử lý trả hàng'],
                                        'cancelled' => ['color' => 'danger', 'icon' => '❌', 'text' => 'Đã hủy'],
                                        'failed' => ['color' => 'danger', 'icon' => '⚠️', 'text' => 'Thất bại'],
                                        'refunded' => ['color' => 'secondary', 'icon' => '💰', 'text' => 'Đã trả hàng'],
                                    ];
                                @endphp

                                <span class="badge bg-{{ $statusData[$status]['color'] ?? 'secondary' }}">
                                    {!! $statusData[$status]['icon'] ?? '❓' !!} {{ $statusData[$status]['text'] ?? 'Không xác định' }}
                                </span>


                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
