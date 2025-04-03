@extends('admin.layout')
@section('title', 'Chỉnh sửa đơn hàng | Quản trị Admin')
@section('title2', 'Chỉnh sửa đơn hàng')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="tile p-4">
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            @if (session('success'))
                <script>
                    Swal.fire({
                        title: 'Thành công!',
                        text: '{{ session('success') }}',
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 4000
                    });
                </script>
            @endif

            <form action="{{ route('order.update', $order->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row mb-4">
                    <div class="col-md-6">
                        <h3 class="text-primary">📌 Thông tin tài khoản</h3>
                        <table class="table table-bordered">
                            <tr><th>Họ tên:</th><td>{{ $order->user->fullname }}</td></tr>
                            <tr><th>Email:</th><td>{{ $order->user->email }}</td></tr>
                            <tr><th>Số điện thoại:</th><td>{{ $order->user->phone }}</td></tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h3 class="text-success">📦 Thông tin người nhận</h3>
                        <table class="table table-bordered">
                            <tr><th>Họ tên:</th><td>{{ $order->recipient_name ?? $order->user->fullname }}</td></tr>
                            <tr><th>Số điện thoại:</th><td>{{ $order->recipient_phone ?? $order->user->phone }}</td></tr>
                            <tr><th>Địa chỉ giao hàng:</th><td>{{ $order->shipping_address ?? 'Chưa có địa chỉ' }}</td></tr>
                        </table>
                    </div>
                </div>

                <h3 class="text-danger">🛍️ Thông tin sản phẩm</h3>
                <table class="table table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Mã SP</th>
                            <th>Tên sản phẩm</th>
                            <th>Hình ảnh</th>
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
                                        <img src="{{ asset($item->variant->images->first()->image_url) }}" width="50" class="rounded">
                                    @else
                                        <img src="{{ asset('default-image.jpg') }}" width="50" class="rounded">
                                    @endif
                                </td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ number_format($item->price,0, ',', '.') }} VNĐ</td>
                                <td>{{ number_format($item->subtotal,0, ',', '.') }} VNĐ</td>
                                <td class="text-center">
                                    <select class="form-select shadow-sm p-2 rounded" name="order_items[{{ $item->id }}][status]" {{ in_array($item->status, ['cancelled', 'refunded','failed']) ? 'disabled' : '' }}>
                                        @php
                                            $statusColors = [
                                                'pending' => ['Chờ xử lý', 'warning', 'bi-hourglass-split'],
                                                'confirmed' => ['Đã xác nhận', 'info', 'bi-check-circle'],
                                                'preparing' => ['Đang chuẩn bị hàng', 'primary', 'bi-box-seam'],
                                                'handed_over' => ['Đã bàn giao cho vận chuyển', 'dark', 'bi-truck'],
                                                'shipping' => ['Đang vận chuyển', 'primary', 'bi-truck'],
                                                'completed' => ['Giao hàng thành công', 'success', 'bi-check2-circle'],
                                                'return_processing' => ['Đang xử lý trả hàng hoàn tiền', 'warning', 'bi-arrow-clockwise'],
                                                'refunded' => ['Đã hoàn tiền', 'secondary', 'bi-arrow-counterclockwise'],
                                                'cancelled' => ['Đã hủy', 'danger', 'bi-x-circle'],
                                                'failed' => ['Thất bại', 'danger', 'bi-exclamation-triangle'],
                                            ];
                                        @endphp
                                        @foreach ($statusColors as $key => [$label, $badgeColor, $icon])
                                            <option value="{{ $key }}" class="fw-bold text-{{ $badgeColor }}" {{ $item->status == $key ? 'selected' : '' }}>
                                                <i class="bi {{ $icon }}"></i> {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="row mt-4">
                    <div class="col-md-6">
                        <h3 class="text-info">🚚 Trạng thái đơn hàng</h3>
                        <div class="form-control shadow-sm p-2 rounded fw-bold text-{{ $statusColors[$order->payment_status][1] }}">
                            {{ $statusColors[$order->payment_status][0] }}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h3 class="text-warning">💳 Phương thức thanh toán</h3>
                        <select class="form-control" name="payment_method">
                            @foreach ([
                                'COD' => 'Thanh toán khi nhận hàng',
                                'momo' => 'Thanh toán qua Momo',
                                'wallet' => 'Thanh toán bằng ví'
                            ] as $key => $value)
                                <option value="{{ $key }}" {{ $order->payment_method == $key ? 'selected' : '' }}>
                                    {{ $value }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('order.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Quay về
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Cập nhật đơn hàng
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
