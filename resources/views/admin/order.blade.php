@extends('admin.layout')
@section('title', 'Danh sách đơn hàng | Quản trị Admin')
@section('title2', 'Danh sách đơn hàng')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <div class="tile-body">
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

                <h3>Danh sách đơn hàng</h3>
                <table class="table table-bordered table-hover js-copytextarea" cellpadding="0" cellspacing="0" border="0"
                id="sampleTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Mã đơn hàng</th>
                            <th>Khách hàng</th>
                            <th>Sản phẩm</th>
                            <th>Tổng số lượng</th>
                            <th>Tổng tiền</th>
                            <th>Trạng thái</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($listOrder as $index => $order)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $order->id }}</td>
                                <td>{{ $order->user->fullname ?? 'Không xác định' }}</td>
                                <td>
                                    @foreach ($order->orderItems as $item)
                                        <p>{{ $item->variant->product->name ?? 'Sản phẩm không tồn tại' }}</p>
                                    @endforeach
                                </td>
                                <td>{{ $order->orderItems->sum('quantity') }}</td>
                                <td>{{ number_format($order->orderItems->sum('subtotal')) }} VNĐ</td>
                                <td>
                                    @switch($order->payment_status)
                                        @case('pending')
                                            <span class="badge badge-warning">Chờ xử lý</span>
                                            @break
                                        @case('shipping')
                                            <span class="badge badge-info">Đang giao</span>
                                            @break
                                        @case('completed')
                                            <span class="badge badge-success">Hoàn thành</span>
                                            @break
                                        @case('failed')
                                            <span class="badge badge-danger">Thất bại</span>
                                            @break
                                        @default
                                            <span class="badge badge-secondary">Không xác định</span>
                                    @endswitch
                                </td>
                                <td>
                                    <a href="{{ route('order.show', $order->id) }}" class="btn btn-info">Xem</a>
                                    <a href="{{ route('order.edit', $order->id) }}" class="btn btn-warning">Sửa</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
