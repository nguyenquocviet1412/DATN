@extends('admin.layout')
@section('title', 'Chỉnh sửa đơn hàng | Quản trị Admin')
@section('title2', 'Chỉnh sửa đơn hàng')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <div class="tile-body">
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

                    {{-- Thông tin tài khoản người đặt hàng --}}
                    <h3>Thông tin tài khoản</h3>
                    <table class="table table-bordered">
                        <tr>
                            <th>ID tài khoản:</th>
                            <td>{{ $order->user->id }}</td>
                        </tr>
                        <tr>
                            <th>Họ tên:</th>
                            <td>{{ $order->user->fullname }}</td>
                        </tr>
                        <tr>
                            <th>Email:</th>
                            <td>{{ $order->user->email }}</td>
                        </tr>
                        <tr>
                            <th>Số điện thoại:</th>
                            <td>{{ $order->user->phone }}</td>
                        </tr>
                    </table>

                    {{-- Thông tin người nhận --}}
                    <h3>Thông tin người nhận</h3>
                    <table class="table table-bordered">
                        <tr>
                            <th>Họ tên:</th>
                            <td>{{ $order->recipient_name ?? $order->user->fullname }}</td>
                        </tr>
                        <tr>
                            <th>Số điện thoại:</th>
                            <td>{{ $order->recipient_phone ?? $order->user->phone }}</td>
                        </tr>
                        <tr>
                            <th>Địa chỉ giao hàng:</th>
                            <td>{{ $order->shipping_address ?? 'Chưa có địa chỉ' }}</td>
                        </tr>
                    </table>

                    {{-- Thông tin sản phẩm --}}
                    <h3>Thông tin sản phẩm</h3>
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
                                    <td>{{ $item->variant->id_product }}</td>
                                    <td>{{ $item->variant->product->name ?? 'N/A' }}</td>
                                    <td>
                                        @if ($item->variant->images->isNotEmpty())
                                            <img src="{{ asset($item->variant->images->first()->image_url) }}" width="50">
                                        @else
                                            <img src="{{ asset('default-image.jpg') }}" width="50">
                                        @endif
                                    </td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>{{ number_format($item->price) }} VNĐ</td>
                                    <td>{{ number_format($item->subtotal) }} VNĐ</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{-- Cập nhật trạng thái đơn hàng --}}
                    <h3 class="mb-3">🚚 Trạng thái đơn hàng</h3>
                    <div class="form-group">
                        <label for="payment_status" class="fw-bold">📌 Trạng thái đơn hàng:</label>
                        <select class="form-select shadow-sm p-2 rounded" name="payment_status">
                            @foreach ([
                                'waiting_payment' => ['Chờ thanh toán', 'secondary', 'bi-wallet2'],
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
                            ] as $key => [$label, $badgeColor, $icon])
                                <option value="{{ $key }}"
                                    class="fw-bold text-{{ $badgeColor }}"
                                    {{ $order->payment_status == $key ? 'selected' : '' }}>
                                    <i class="bi {{ $icon }}"></i> {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>


                    {{-- Cập nhật phương thức thanh toán --}}
                    <h3>Phương thức thanh toán</h3>
                    <div class="form-group">
                        <label for="payment_method">Phương thức thanh toán:</label>
                        <select class="form-control" name="payment_method">
                            @foreach ([
                                'COD' => 'Thanh toán khi nhận hàng',
                                'Online' => 'Thanh toán trực tuyến'
                            ] as $key => $value)
                                <option value="{{ $key }}" {{ $order->payment_method == $key ? 'selected' : '' }}>
                                    {{ $value }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="d-flex justify-content-between">
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
</div>
@endsection
