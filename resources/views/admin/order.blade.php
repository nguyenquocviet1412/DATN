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
                                <td>{{ number_format($order->total_price ,0, ',', '.') }} VNĐ</td>
                                <td>
                                    @switch($order->payment_status)
                                        @case('pending')
                                            <span class="badge bg-warning text-dark"><i class="bi bi-hourglass-split"></i> Chờ xử lý</span>
                                            @break
                                        @case('confirmed')
                                            <span class="badge bg-info"><i class="bi bi-check-circle"></i> Đã xác nhận</span>
                                            @break
                                        @case('preparing')
                                            <span class="badge bg-primary"><i class="bi bi-box-seam"></i> Đang chuẩn bị hàng</span>
                                            @break
                                        @case('handed_over')
                                            <span class="badge bg-dark"><i class="bi bi-truck"></i> Đã bàn giao vận chuyển</span>
                                            @break
                                        @case('shipping')
                                            <span class="badge bg-primary"><i class="bi bi-truck"></i> Đang giao hàng</span>
                                            @break
                                        @case('completed')
                                            <span class="badge bg-success"><i class="bi bi-check2-circle"></i> Giao hàng thành công</span>
                                            @break
                                        @case('cancelled')
                                            <span class="badge bg-danger"><i class="bi bi-x-circle"></i> Đã hủy</span>
                                            @break
                                        @case('failed')
                                            <span class="badge bg-danger"><i class="bi bi-exclamation-triangle"></i> Thất bại</span>
                                            @break
                                        @case('return_processing')
                                            <span class="badge bg-warning text-dark"><i class="bi bi-arrow-clockwise"></i> Đang xử lý trả hàng</span>
                                            @break
                                        @case('shop_refunded')
                                            <span class="badge bg-info text-dark"><i class="bi bi-cash-coin"></i> Shop đã hoàn tiền</span>
                                            @break
                                        @case('customer_confirmed_refund')
                                            <span class="badge bg-success"><i class="bi bi-check-circle"></i> Khách đã xác nhận nhận tiền</span>
                                            @break
                                        @case('refunded')
                                            <span class="badge bg-secondary"><i class="bi bi-arrow-counterclockwise"></i> Đã hoàn tiền (hoàn tất)</span>
                                            @break
                                        @default
                                            <span class="badge bg-secondary"><i class="bi bi-question-circle"></i> Không xác định</span>
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
