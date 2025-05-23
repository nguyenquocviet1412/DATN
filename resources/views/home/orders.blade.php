@extends('master.main')
@section('title', 'Lịch sử đơn hàng')

@section('main')
<main>
    <!-- breadcrumb area start -->
    <div class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb-wrap">
                        <nav aria-label="breadcrumb">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('home.index')}}"><i class="fa fa-home"></i></a></li>
                                <li class="breadcrumb-item active"><a href="{{route('user.orders')}}">Đơn hàng</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb area end -->
    <div class="container my-5">
        <div class="card shadow-lg rounded-3 border-0">
            <div class="card-body">
                <div class="row">
                    <!-- Sidebar -->
                    <div class="col-md-3">
                        <div class="list-group shadow-sm rounded-3 overflow-hidden">
                            <a href="{{ route('user.profile') }}" class="list-group-item list-group-item-action d-flex align-items-center">
                                <i class="bi bi-person-circle me-2"></i> Hồ Sơ
                            </a>
                            <a href="{{ route('user.orders') }}" class="list-group-item list-group-item-action active d-flex align-items-center">
                                <i class="bi bi-card-list me-2"></i> Đơn Hàng
                            </a>
                        </div>
                    </div>

                    <!-- Nội dung chính -->
                    <div class="col-md-9">
                        <h2 class="text-center mb-4 fw-bold text-uppercase">🛍️ Lịch Sử Đơn Hàng</h2>

                        @if ($orders->isEmpty())
                            <div class="alert alert-info text-center">
                                <i class="bi bi-emoji-frown"></i> Bạn chưa có đơn hàng nào.
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="bg-dark text-white">
                                        <tr>
                                            <th># Mã Đơn</th>
                                            <th>Ngày Đặt</th>
                                            <th>Sản Phẩm</th>
                                            <th>Tổng Tiền</th>
                                            <th>Trạng Thái</th>
                                            <th>Thao Tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orders as $order)
                                            <tr class="align-middle">
                                                <td>#{{ $order->id }}</td>
                                                <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                                <td>
                                                    <ul class="list-unstyled">
                                                        @foreach ($order->orderItems as $item)
                                                        {{-- nếu không còn biến thể hoặc sản phẩm thì thông báo --}}
                                                        @if (!$item->variant || !$item->variant->product)
                                                            <li class="text-danger">Sản phẩm không còn tồn tại</li>
                                                        @endif
                                                        {{-- nếu có biến thể và sản phẩm thì hiển thị --}}
                                                        @if ($item->variant && $item->variant->product)
                                                            <li class="d-flex align-items-center">
                                                                <img src="{{ asset($item->variant->images->first()->image_url ?? 'default-image.jpg') }}" alt="{{ $item->variant->product->name }}" width="50" class="me-2 rounded">
                                                                <div>
                                                                    <strong>{{ $item->variant->product->name }}</strong>
                                                                    <small class="text-muted d-block">Size: {{ $item->variant->size->size }}, Màu: {{ $item->variant->color->name }}</small>
                                                                    <span class="text-muted">x{{ $item->quantity }}</span>
                                                                </div>
                                                            </li>
                                                        @endif
                                                        @endforeach
                                                    </ul>
                                                </td>
                                                <td>
                                                    <span class="fw-bold text-danger">{{ number_format($order->total_price, 0, ',', '.') }}₫</span>
                                                </td>
                                                <td>
                                                    @php
                                                        $status = $order->payment_status;
                                                        $statusData = [
                                                            'pending' => ['color' => 'warning', 'icon' => '⏳', 'text' => 'Chờ xử lý'],
                                                            'confirmed' => ['color' => 'info', 'icon' => '✅', 'text' => 'Đã xác nhận'],
                                                            'preparing' => ['color' => 'primary', 'icon' => '📦', 'text' => 'Đang chuẩn bị hàng'],
                                                            'handed_over' => ['color' => 'dark', 'icon' => '📤', 'text' => 'Đã bàn giao'],
                                                            'shipping' => ['color' => 'info', 'icon' => '🚚', 'text' => 'Đang vận chuyển'],
                                                            'completed' => ['color' => 'success', 'icon' => '🎉', 'text' => 'Hoàn thành'],
                                                            'cancelled' => ['color' => 'danger', 'icon' => '❌', 'text' => 'Đã hủy'],
                                                            'failed' => ['color' => 'danger', 'icon' => '⚠️', 'text' => 'Thất bại'],

                                                            // Các trạng thái hoàn tiền - hoàn tiền
                                                            'return_processing' => ['color' => 'warning', 'icon' => '🔄', 'text' => 'Đang xử lý hoàn tiền'],
                                                            'shop_refunded' => ['color' => 'info', 'icon' => '💸', 'text' => 'Shop đã hoàn tiền'],
                                                            'customer_confirmed_refund' => ['color' => 'success', 'icon' => '🤝', 'text' => 'Khách xác nhận đã nhận tiền'],
                                                            'refunded' => ['color' => 'secondary', 'icon' => '💰', 'text' => 'Đã hoàn tiền'],
                                                        ];
                                                    @endphp

                                                    <span class="badge bg-{{ $statusData[$status]['color'] ?? 'secondary' }} px-3 py-2">
                                                        {!! $statusData[$status]['icon'] ?? '❓' !!} {{ $statusData[$status]['text'] ?? 'Không xác định' }}
                                                    </span>
                                                </td>

                                                <td>
                                                    <div class="d-flex flex-column gap-2">
                                                        <!-- Nút xem chi tiết -->
                                                        <a href="{{ route('user.order.detail', $order->id) }}" class="btn btn-outline-primary btn-sm fw-bold d-flex align-items-center justify-content-center"
                                                           style="border-radius: 8px; transition: all 0.3s;">
                                                            <i class="bi bi-eye me-1"></i> Xem chi tiết
                                                        </a>

                                                        <!-- Nút hủy đơn hàng (nếu có thể hủy) -->
                                                        @if (in_array($order->payment_status, ['pending', 'confirmed', 'preparing']))
                                                            <button type="button" class="btn btn-outline-danger btn-sm fw-bold d-flex align-items-center justify-content-center"
                                                                style="border-radius: 8px; transition: all 0.3s;" onclick="confirmCancel('{{ route('orders.cancel', $order->id) }}')">
                                                                <i class="bi bi-x-circle me-1"></i> Hủy đơn
                                                            </button>
                                                        @endif

                                                        <!-- Nút xác nhận đã nhận hàng -->
                                                        @if ($order->payment_status == 'shipping')
                                                            <form action="{{ route('user.order.receive', $order->id) }}" method="POST">
                                                                @csrf
                                                                <button type="submit" class="btn btn-success btn-sm fw-bold d-flex align-items-center justify-content-center"
                                                                    style="border-radius: 8px; transition: all 0.3s;">
                                                                    <i class="fas fa-box-open me-1"></i> Đã nhận hàng
                                                                </button>
                                                            </form>
                                                        @endif
                                                        <!-- Nút yêu cầu hoàn tiền -->
                                                        @php
                                                            $status = $order->payment_status;
                                                            // Kiểm tra thời gian trả hàng (trong vòng 7 ngày kể từ khi giao hàng)
                                                            $orderDate = $order->updated_at;
                                                            $canReturn = now()->diffInDays($orderDate) ;
                                                        @endphp

                                                        @if ($status === 'completed' && 7 >= $canReturn )
                                                            <form action="{{ route('order.return-item', ['order' => $order->id, 'item' => $item->id]) }}" method="POST" class="mt-2">
                                                                @csrf
                                                                <button type="submit" class="btn btn-danger btn-sm"
                                                                    onclick="return confirm('Bạn có chắc muốn trả hàng sản phẩm này?')">
                                                                    🔄 Trả hàng
                                                                    {{$canReturn}} ngày
                                                                </button>
                                                            </form>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-center mt-4">
                                    {{ $orders->Links() }}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<script>
    function confirmCancel(url) {
        if (confirm("Bạn có chắc chắn muốn hủy đơn hàng này không?")) {
            let form = document.createElement("form");
            form.action = url;
            form.method = "POST";
            form.style.display = "none";

            let csrfToken = document.createElement("input");
            csrfToken.type = "hidden";
            csrfToken.name = "_token";
            csrfToken.value = "{{ csrf_token() }}";

            form.appendChild(csrfToken);
            document.body.appendChild(form);
            form.submit();
        }
    }
</script>
<style>
    .btn {
    padding: 8px 12px;
    font-size: 14px;
}

.btn-outline-primary:hover {
    background: linear-gradient(90deg, #007bff, #6610f2);
    color: #fff !important;
    border-color: #6610f2;
}

.btn-outline-danger:hover {
    background: linear-gradient(90deg, #dc3545, #ff6b6b);
    color: #fff !important;
    border-color: #ff6b6b;
}

.btn-success:hover {
    background: linear-gradient(90deg, #28a745, #20c997);
    color: #fff !important;
    border-color: #20c997;
}
/* Tùy chỉnh phân trang */
.pagination {
            display: flex;
            list-style: none;
            padding: 0;
        }

        .pagination li {
            margin: 0 5px;
        }

        .pagination .page-link {
            color: #000;
            /* Màu chữ đen */
            background-color: #fff;
            /* Nền trắng */
            border: 1px solid #000;
            /* Viền đen */
            padding: 8px 15px;
            border-radius: 8px;
            transition: all 0.3s ease-in-out;
        }

        .pagination .page-link:hover {
            background-color: #ffcc00;
            /* Màu vàng nổi bật */
            color: #000;
            /* Chữ đen */
            border-color: #ffcc00;
        }

        .pagination .active .page-link {
            background-color: #ffcc00;
            /* Màu vàng */
            border-color: #ffcc00;
            color: #000;
            font-weight: bold;
        }

</style>
@endsection
