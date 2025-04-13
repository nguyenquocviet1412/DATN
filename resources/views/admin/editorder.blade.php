@extends('admin.layout')
@section('title', 'Chỉnh sửa đơn hàng | Quản trị Admin')
@section('title2', 'Chỉnh sửa đơn hàng')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="tile p-4">
{{-- thông báo thêm thành công --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if(session('success'))
    <script>
        Swal.fire({
            title: 'Thành công!',
            text: '{{ session("success") }}',
            icon: 'success',
            showConfirmButton: false,
            timer: 4000,
            backdrop: true  // Làm tối nền
        });
    </script>
@endif


{{-- Thông báo lỗi --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if(session('error'))
        <script>
            Swal.fire({
                title: 'Lỗi!',
                text: '{{ session("error") }}',
                icon: 'error',
                showConfirmButton: true,  // Hiển thị nút đóng
                confirmButtonText: 'Đóng',  // Nội dung nút đóng
                backdrop: true  // Làm tối nền
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
                                        <img src="{{ asset($item->variant->images->first()->image_url) }}" width="50" class="rounded">
                                    @else
                                        <img src="{{ asset('default-image.jpg') }}" width="50" class="rounded">
                                    @endif
                                </td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ number_format($item->price,0, ',', '.') }} VNĐ</td>
                                <td>{{ number_format($item->subtotal,0, ',', '.') }} VNĐ</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @php
                    $statusFlow = config('order_status.flow');
                    $labels = config('order_status.labels');
                    $colors = config('order_status.colors');
                    $icons = config('order_status.icons');
                    $currentStatus = $order->payment_status;
                    $allowedStatuses = $statusFlow[$currentStatus] ?? [];
                @endphp
                <div class="row mt-4">
                    {{-- Trạng thái đơn hàng --}}
                    <div class="col-md-6 mb-4">
                        <h3 class="text-info mb-2">🚚 Trạng thái đơn hàng</h3>
                        <select class="form-control" name="payment_status">
                            <option value="{{ $currentStatus }}" selected disabled>
                                {{ $labels[$currentStatus] ?? $currentStatus }}
                            </option>
                            @foreach ($allowedStatuses as $nextStatus)
                                <option value="{{ $nextStatus }}">
                                    {{ $labels[$nextStatus] ?? $nextStatus }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Trạng thái thanh toán --}}
                    <div class="col-md-6 mb-4">
                        <h3 class="text-success mb-2">💰 Trạng thái thanh toán</h3>
                        <select class="form-control" name="status">
                            <option value="unpaid" {{ $order->status == 'unpaid' ? 'selected' : '' }}>Chưa thanh toán</option>
                            <option value="pay" {{ $order->status == 'pay' ? 'selected' : '' }}>Đã thanh toán</option>
                        </select>
                    </div>

                    {{-- Phương thức thanh toán (chỉ hiển thị) --}}
                    <div class="col-md-6 mb-4">
                        <h3 class="text-warning fw-bold mb-2">💳 Phương thức thanh toán</h3>
                        <div class="border rounded-3 p-3 bg-light shadow-sm d-flex align-items-center">
                            <i class="fas fa-credit-card fa-lg text-warning me-3"></i>
                            <span class="fs-5 text-dark mb-0">
                                @switch($order->payment_method)
                                    @case('COD') Thanh toán khi nhận hàng @break
                                    @case('cod') Thanh toán khi nhận hàng @break
                                    @case('momo') Thanh toán qua Momo @break
                                    @default Không xác định
                                @endswitch
                            </span>
                        </div>
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
