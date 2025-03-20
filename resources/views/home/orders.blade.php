@extends('master.main')
@section('title', 'Lịch sử đơn hàng')

@section('main')
<main>
    <div class="container my-5">
        <h2 class="text-center mb-4">🛍️ Lịch Sử Đơn Hàng</h2>

        @if ($orders->isEmpty())
            <div class="alert alert-info text-center">Bạn chưa có đơn hàng nào.</div>
        @else
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>Mã Đơn</th>
                            <th>Ngày Đặt</th>
                            <th>Sản Phẩm</th>
                            <th>Tổng Tiền</th>
                            <th>Trạng Thái</th>
                            <th>Chi Tiết</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr>
                                <td>#{{ $order->id }}</td>
                                <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    <ul class="list-unstyled">
                                        @foreach ($order->orderItems as $item)
                                            <li>
                                                <strong>{{ $item->variant->product->name }}</strong>
                                                (Size: {{ $item->variant->size->size }}, Màu: {{ $item->variant->color->name }})
                                                x{{ $item->quantity }}
                                            </li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td><strong class="text-danger">{{ number_format($order->total_price) }}₫</strong></td>
                                <td>
                                    <span class="badge
                                        @if($order->payment_status == 'waiting_payment') bg-secondary
                                        @elseif($order->payment_status == 'pending') bg-warning
                                        @elseif($order->payment_status == 'shipping') bg-primary
                                        @elseif($order->payment_status == 'completed') bg-success
                                        @else bg-danger @endif">
                                        {{ \App\Models\Order::PAYMENT_STATUS[$order->payment_status] ?? 'Không xác định' }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('user.order.detail', $order->id) }}" class="btn btn-sm btn-info">Xem</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</main>
@endsection
