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
                        @else
                            <span class="badge bg-primary">Thanh toán trực tuyến</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>📦 Trạng thái đơn hàng:</th>
                    <td>
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

                                // Trạng thái trả hàng hoàn tiền
                                'return_processing' => ['color' => 'warning', 'icon' => '🔄', 'text' => 'Đang xử lý trả hàng'],
                                'shop_refunded' => ['color' => 'info', 'icon' => '💸', 'text' => 'Shop đã hoàn tiền'],
                                'customer_confirmed_refund' => ['color' => 'success', 'icon' => '🤝', 'text' => 'Khách xác nhận đã nhận tiền'],
                                'refunded' => ['color' => 'secondary', 'icon' => '💰', 'text' => 'Đã hoàn tiền (hoàn tất)'],
                            ];
                        @endphp

                        <span class="badge bg-{{ $statusData[$status]['color'] ?? 'secondary' }}">
                            {!! $statusData[$status]['icon'] ?? '❓' !!} {{ $statusData[$status]['text'] ?? 'Không xác định' }}
                        </span>

                    </td>
                </tr>
                <tr>
                    <th>💸 Trạng thái thanh toán:</th>
                    <td>
                        @if ($order->status == 'unpaid')
                            <span class="badge bg-danger">Chưa thanh toán</span>
                        @elseif ($order->status == 'pay')
                            <span class="badge bg-success">Đã thanh toán</span>
                        @else
                            <span class="badge bg-secondary">Không xác định</span>
                        @endif
                    </td>
                </tr>

                {{-- Hiển thị mã giảm giá nếu có --}}
                @if ($order->id_voucher)
                <tr>
                    <th>🎟 Mã giảm giá:</th>
                    <td><span class="badge bg-warning">{{ $order->voucher->code }}</span></td>
                </tr>
                @endif

                {{-- Tổng tiền trước khi giảm giá --}}
                <tr>
                    <th>💰 Tổng tiền chưa giảm:</th>
                    <td><strong>{{ number_format($order->total_price + $order->discount_amount,0, ',', '.') }} VNĐ</strong></td>
                </tr>

                <tr>
                    <th>💲 Số tiền giảm giá:</th>
                    <td>- {{ number_format($order->discount_amount,0, ',', '.') }} VNĐ</td>
                </tr>
                <tr>
                    <th>🤑 Tổng tiền đơn hàng:</th>
                    <td><strong>{{ number_format($order->total_price,0, ',', '.') }} VNĐ </strong>(Đã tính phí vận chuyển)</td>
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
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->orderItems as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->variant->id_product ?? null }}</td>
                            <td>{{ $item->variant->product->name ?? 'N/A' }}</td>
                            <td>
                                @if ($item->variant && $item->variant->images->isNotEmpty())
                                    {{-- Hiển thị ảnh sản phẩm nếu có --}}
                                    <img src="{{ asset($item->variant->images->first()->image_url) }}" alt="Ảnh sản phẩm" width="50">
                                @else
                                    <img src="{{ asset('default-image.jpg') }}" alt="Ảnh mặc định" width="50">
                                @endif
                            </td>
                            <td>{{ $item->variant->size->size ?? 'Không có' }}</td>
                            <td>{{ $item->variant->color->name ?? 'Không có' }}</td>
                            <td>{{ number_format($item->quantity) }}</td>
                            <td>{{ number_format($item->price,0, ',', '.') }} VNĐ</td>
                            <td>{{ number_format($item->subtotal,0, ',', '.') }} VNĐ</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{-- Quay lại --}}
            <div class="text-center">
                <a href="{{ route('order.index') }}" class="btn btn-primary mt-3">Quay lại danh sách</a>
            </div>
        </div>
    </div>
</div>
@endsection
