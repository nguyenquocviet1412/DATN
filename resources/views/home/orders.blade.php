@extends('master.main')
@section('title', 'Lịch sử đơn hàng')

@section('main')
<main>
    <div class="container my-5">
        <div class="card shadow-lg rounded-3">
            <div class="card-body">
                <div class="row">
                    <!-- Sidebar -->
                    <div class="col-md-3">
                        <div class="list-group shadow-sm rounded-3 overflow-hidden">
                            <a href="{{ route('user.profile') }}" class="list-group-item list-group-item-action active d-flex align-items-center">
                                <i class="bi bi-person-circle me-2"></i> Hồ Sơ
                            </a>
                            <a href="#" class="list-group-item list-group-item-action d-flex align-items-center">
                                <i class="bi bi-wallet2 me-2"></i> Ví tiền
                            </a>
                            <a href="{{ route('user.orders') }}" class="list-group-item list-group-item-action d-flex align-items-center">
                                <i class="bi bi-card-list me-2"></i> Đơn Hàng
                            </a>
                        </div>
                    </div>

                    <!-- Nội dung chính -->
                    <div class="col-md-9">
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
                                                    @if ($order->payment_status == 'shipping')
                                                        <form action="{{ route('user.order.receive', $order->id) }}" method="POST">
                                                            @csrf
                                                            <button type="submit" class="btn btn-sm btn-success d-flex align-items-center">
                                                                <i class="fas fa-box-open me-1"></i> Đã nhận hàng
                                                            </button>
                                                        </form>
                                                    @else
                                                        @php
                                                            $status = $order->payment_status;
                                                            $statusData = [
                                                                'pending' => ['color' => 'warning', 'icon' => '⏳', 'text' => 'Chờ xử lý'],
                                                                'confirmed' => ['color' => 'info', 'icon' => '✅', 'text' => 'Đã xác nhận'],
                                                                'preparing' => ['color' => 'primary', 'icon' => '📦', 'text' => 'Đang chuẩn bị hàng'],
                                                                'handed_over' => ['color' => 'dark', 'icon' => '📤', 'text' => 'Đã bàn giao'],
                                                                'shipping' => ['color' => 'info', 'icon' => '🚚', 'text' => 'Đang vận chuyển'],
                                                                'completed' => ['color' => 'success', 'icon' => '🎉', 'text' => 'Hoàn thành'],
                                                                'return_processing' => ['color' => 'warning', 'icon' => '🔄', 'text' => 'Đang xử lý trả hàng'],
                                                                'refunded' => ['color' => 'secondary', 'icon' => '💰', 'text' => 'Đã trả hàng'],
                                                                'cancelled' => ['color' => 'danger', 'icon' => '❌', 'text' => 'Đã hủy'],
                                                                'failed' => ['color' => 'danger', 'icon' => '⚠️', 'text' => 'Thất bại'],
                                                            ];
                                                        @endphp

                                                        <span class="badge bg-{{ $statusData[$status]['color'] ?? 'secondary' }} px-3 py-2">
                                                            {!! $statusData[$status]['icon'] ?? '❓' !!} {{ $statusData[$status]['text'] ?? 'Không xác định' }}
                                                        </span>
                                                    @endif
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
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
