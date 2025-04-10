@extends('master.main')
@section('title', 'Đặt hàng thành công')
@section('main')

<main style="font-family: 'Poppins', sans-serif;">
    <div class="container py-5">

        <!-- Tiêu đề -->
        <div class="text-center mb-5">
            <h1 class="fw-bold" style="color: #d4af37; font-size: 2.8rem;">🎉 Đặt hàng thành công!</h1>
            <p class="text-dark fs-5">Cảm ơn bạn đã tin tưởng đặt hàng tại cửa hàng của chúng tôi.</p>
            <a href="{{ route('home.index') }}" class="btn btn-gold mt-3">Tiếp tục mua sắm</a>
        </div>

        <!-- Thông tin đơn hàng -->
        <div class="card shadow border-0 rounded-4 p-4 mb-4" style="background-color: #fff;">
            <h4 class="mb-4" style="color: #d4af37;">🧾 Thông tin đơn hàng #{{ $order->id }}</h4>
            <div class="row">
                <div class="col-md-6">
                    <p><strong>📅 Ngày đặt:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
                    <p><strong>💳 Thanh toán:</strong>
                        @switch($order->payment_method)
                            @case('COD') Thanh toán khi nhận hàng (COD) @break
                            @case('momo') Momo @break
                            @default Khác
                        @endswitch
                    </p>
                </div>
                <div class="col-md-6">
                    <p><strong>💰 Tổng tiền:</strong> <span class="text-gold">{{ number_format($order->total_price, 0, ',', '.') }} VNĐ</span></p>
                    @if ($order->id_voucher)
                        <p><strong>🎟 Mã giảm giá:</strong> <span class="badge bg-dark text-white">{{ $order->voucher->code }}</span></p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Thông tin người dùng -->
        <div class="row mb-4">
            <div class="col-md-6 mb-3">
                <div class="border border-dark rounded-3 p-4 h-100 bg-white">
                    <h5 class="mb-3 text-dark">👤 Người đặt hàng</h5>
                    <p><strong>Họ tên:</strong> {{ $order->user->fullname }}</p>
                    <p><strong>📞 SĐT:</strong> {{ $order->user->phone }}</p>
                    <p><strong>✉️ Email:</strong> {{ $order->user->email }}</p>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="border border-dark rounded-3 p-4 h-100 bg-white">
                    <h5 class="mb-3 text-dark">🚚 Người nhận hàng</h5>
                    <p><strong>Họ tên:</strong> {{ $order->fullname ?? $order->user->fullname }}</p>
                    <p><strong>📞 SĐT:</strong> {{ $order->phone ?? $order->user->phone }}</p>
                    <p><strong>📍 Địa chỉ:</strong> {{ $order->shipping_address }}</p>
                </div>
            </div>
        </div>

        <!-- Danh sách sản phẩm -->
        <div class="card border-0 shadow rounded-4 p-4 bg-white">
            <h5 class="mb-4 text-dark">🛍 Sản phẩm đã đặt</h5>
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead style="background-color: #000; color: #fff;">
                        <tr>
                            <th>#</th>
                            <th>Hình ảnh</th>
                            <th>Tên</th>
                            <th>Size</th>
                            <th>Màu</th>
                            <th>Số lượng</th>
                            <th>Đơn giá</th>
                            <th>Tổng</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->orderItems as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                @if ($item->variant && $item->variant->images->isNotEmpty())
                                    <img src="{{ asset($item->variant->images->first()->image_url) }}" width="60" class="rounded-2 shadow-sm">
                                @else
                                    <img src="{{ asset('default-image.jpg') }}" width="60" class="rounded-2 shadow-sm">
                                @endif
                            </td>
                            <td>{{ $item->variant->product->name ?? 'N/A' }}</td>
                            <td>{{ $item->variant->size->size ?? '-' }}</td>
                            <td>{{ $item->variant->color->name ?? '-' }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ number_format($item->price, 0, ',', '.') }} VNĐ</td>
                            <td>{{ number_format($item->subtotal, 0, ',', '.') }} VNĐ</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</main>

<!-- Custom style -->
<style>
    body {
        font-family: 'Poppins', sans-serif;
        background-color: #fdfdfd;
    }

    .text-gold {
        color: #d4af37;
    }

    .btn-gold {
        background-color: #d4af37;
        color: #000;
        font-weight: 500;
        padding: 12px 28px;
        border: none;
        border-radius: 50px;
        transition: all 0.3s ease;
    }

    .btn-gold:hover {
        background-color: #c49e2f;
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
    }

    th, td {
        vertical-align: middle;
    }

    .card {
        border: 1px solid #e0e0e0;
    }
</style>

@endsection
