@extends('master.main')
@section('title', 'Lịch sử đơn hàng')
@section('main')

    <main>
        <div class="container">
            <h2 class="text-center my-4">Lịch sử đơn hàng</h2>

            @if ($orders->isEmpty())
                <p class="text-center">Bạn chưa có đơn hàng nào.</p>
            @else
                <table class="table table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>Mã đơn</th>
                            <th>Ngày đặt</th>
                            <th>Tổng tiền</th>
                            <th>Trạng thái</th>
                            <th>Chi tiết</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr>
                                <td>#{{ $order->id }}</td>
                                <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                <td>{{ number_format($order->total_price) }}₫</td>
                                <td><span class="badge bg-warning">{{ ucfirst($order->payment_status) }}</span></td>
                                <td><a href="{{ route('user.order.detail', $order->id) }}" class="btn btn-info btn-sm">Xem</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </main>
@endsection
