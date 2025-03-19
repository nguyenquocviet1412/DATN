@extends('master.main')
@section('title', 'Chi tiết đơn hàng')
@section('main')

    <main>
        <div class="container">
            <h2 class="text-center my-4">Chi tiết đơn hàng #{{ $order->id }}</h2>

            <div class="card p-4">
                <h5>Họ tên: <strong>{{ $order->fullname }}</strong></h5>
                <h5>Điện thoại: <strong>{{ $order->phone }}</strong></h5>
                <h5>Địa chỉ giao hàng: <strong>{{ $order->shipping_address }}</strong></h5>
                <h5>Phương thức thanh toán: <strong>{{ ucfirst($order->payment_method) }}</strong></h5>
                <h5>Trạng thái: <span class="badge bg-warning">{{ ucfirst($order->payment_status) }}</span></h5>
            </div>

            <table class="table table-bordered mt-4">
                <thead class="table-dark">
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Số lượng</th>
                        <th>Giá</th>
                        <th>Tổng</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->orderItems as $item)
                        <tr>
                            <td>{{ $item->variant->product->name }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ number_format($item->price) }}₫</td>
                            <td>{{ number_format($item->subtotal) }}₫</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <h4 class="text-end text-danger">Tổng đơn hàng: <strong>{{ number_format($order->total_price) }}₫</strong></h4>

            <a href="{{ route('user.orders') }}" class="btn btn-secondary">Quay lại</a>
        </div>
    </main>
@endsection
