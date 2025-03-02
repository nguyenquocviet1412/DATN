@extends('admin.layout')
@section('title', 'Chi tiết đơn hàng | Quản trị Admin')
@section('title2', 'Chi tiết đơn hàng')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">

                    {{-- Hiển thị thông báo --}}
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

                    @if (session('error'))
                        <script>
                            Swal.fire({
                                title: 'Lỗi!',
                                text: '{{ session('error') }}',
                                icon: 'error',
                                showConfirmButton: true,
                                confirmButtonText: 'Đóng'
                            });
                        </script>
                    @endif

                    <div class="row">
                        <div class="col-md-6">
                            <h3>Thông tin khách hàng</h3>
                            <table class="table">
                                <tr>
                                    <th>Họ tên:</th>
                                    <td>{{ $order->user->fullname }}</td>
                                </tr>
                                <tr>
                                    <th>Phone:</th>
                                    <td>{{ $order->user->phone }}</td>
                                </tr>
                                <tr>
                                    <th>Địa chỉ:</th>
                                    <td>{{ $order->shipping_address }}</td>
                                </tr>
                                <tr>
                                    <th>Ngày đặt:</th>
                                    <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>Tổng tiền trước giảm giá:</th>
                                    <td>{{ number_format($order->orderItems->sum('subtotal')) }} VNĐ</td>
                                </tr>
                                <tr>
                                    <th>Mã khuyến mại:</th>
                                    <td>
                                        @if ($order->voucher)
                                            {{ $order->voucher->code }}
                                            (Giảm:
                                            @if ($order->voucher->discount_type === 'percentage')
                                                {{-- Tính số tiền giảm giá --}}
                                                @php
                                                    $cartTotal = $order->orderItems->sum('subtotal');
                                                    $discountValue = ($cartTotal * $order->voucher->discount_value) / 100;
                                                    if ($order->voucher->max_discount) {
                                                        $discountValue = min($discountValue, $order->voucher->max_discount);
                                                    }
                                                @endphp
                                                {{ $order->voucher->discount_value }}%
                                                - {{ number_format($discountValue) }} VNĐ
                                            @else
                                                {{ number_format($order->voucher->discount_value) }} VNĐ
                                            @endif
                                            )
                                        @else
                                            Không có
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Tổng tiền sau giảm giá:</th>
                                    <td>{{ number_format($order->total_price_after_discount) }} VNĐ</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <h3>Thông tin sản phẩm</h3>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Mã sản phẩm</th>
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
                                    <td>{{ $item->variant->id_product }}</td>
                                    <td>{{ $item->variant->product->name ?? 'N/A' }}</td>
                                    <td>
                                        @if ($item->variant->images->isNotEmpty())
                                            <img src="{{ asset($item->variant->images->first()->image_url) }}" alt="Ảnh sản phẩm" width="50">
                                        @else
                                            <img src="{{ asset('default-image.jpg') }}" alt="Ảnh mặc định" width="50">
                                        @endif
                                    </td>
                                    <td>{{ $item->variant->size->name ?? 'Không có' }}</td>
                                    <td>{{ $item->variant->color->name ?? 'Không có' }}</td>
                                    <td>{{ number_format($item->quantity) }}</td>
                                    <td>{{ number_format($item->price) }} VNĐ</td>
                                    <td>{{ number_format($item->subtotal) }} VNĐ</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
