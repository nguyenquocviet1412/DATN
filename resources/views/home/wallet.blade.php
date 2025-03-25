@extends('master.main')
@section('title', 'Ví Tiền Của Tôi')

@section('main')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

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
                                <li class="breadcrumb-item">Ví tiền</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb area end -->

    <div class="container mt-5">
        <div class="row justify-content-center">
            <!-- Sidebar -->
            <div class="col-md-3">
                <div class="list-group shadow-sm rounded-3 overflow-hidden">
                    <a href="{{ route('user.profile') }}" class="list-group-item list-group-item-action  d-flex align-items-center">
                        <i class="bi bi-person-circle me-2"></i> Hồ Sơ
                    </a>
                    <a href="{{route('walletclient.index')}}" class="list-group-item list-group-item-action active d-flex align-items-center">
                        <i class="bi bi-wallet2 me-2"></i> Ví tiền
                    </a>
                    <a href="{{ route('user.orders') }}" class="list-group-item list-group-item-action d-flex align-items-center">
                        <i class="bi bi-card-list me-2"></i> Đơn Hàng
                    </a>
                </div>
            </div>
            <div class="col-md-8">
                <!-- Thông tin số dư -->
                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-body text-center p-4">
                        <h2 class="fw-bold text-primary">Ví Tiền Của Tôi</h2>
                        <h5 class="text-muted mt-2">Số dư hiện tại</h5>
                        <h1 class="text-success fw-bold mt-2 display-5">{{ number_format($wallet->balance ?? 0, 0) }} {{ $wallet->currency ?? 'VND' }}</h1>
                    </div>
                </div>

                <!-- Lịch sử giao dịch -->
                <div class="card mt-4 shadow-lg border-0 rounded-4">
                    <div class="card-body">
                        <h3 class="fw-bold text-dark text-center">Lịch sử giao dịch</h3>
                        <div class="table-responsive">
                            <table class="table table-hover mt-3 align-middle">
                                <thead class="bg-primary text-white">
                                    <tr>
                                        <th>Loại</th>
                                        <th>Số tiền</th>
                                        <th>Trước</th>
                                        <th>Sau</th>
                                        <th>Mô tả</th>
                                        <th>Trạng thái</th>
                                        <th>Ngày</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($transactions as $transaction)
                                    <tr>
                                        <td>
                                            @php
                                                $types = [
                                                    'deposit' => ['bg-success', 'fa-solid fa-arrow-down', 'Nạp tiền'],
                                                    'withdrawal' => ['bg-danger', 'fa-solid fa-arrow-up', 'Rút tiền'],
                                                    'purchase' => ['bg-warning text-dark', 'fa-solid fa-shopping-cart', 'Mua hàng'],
                                                    'refund' => ['bg-info text-dark', 'fa-solid fa-undo-alt', 'Hoàn tiền']
                                                ];
                                            @endphp

                                            <span class="badge {{ $types[$transaction->transaction_type][0] }}">
                                                <i class="{{ $types[$transaction->transaction_type][1] }}"></i>
                                                {{ $types[$transaction->transaction_type][2] }}
                                            </span>
                                        </td>
                                        <td class="fw-bold text-primary">{{ number_format($transaction->amount, 0) }} VND</td>
                                        <td>{{ number_format($transaction->balance_before, 0) }} VND</td>
                                        <td>{{ number_format($transaction->balance_after, 0) }} VND</td>
                                        <td>{{ $transaction->description }}</td>
                                        <td>
                                            <span class="badge {{ $transaction->status == 'completed' ? 'bg-success' : 'bg-secondary' }}">
                                                {{ $transaction->status == 'completed' ? 'Hoàn thành' : 'Đang xử lý' }}
                                            </span>
                                        </td>
                                        <td>{{ $transaction->created_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Phân trang -->
                        <div class="d-flex justify-content-center mt-3">
                            {{ $transactions->links('vendor.pagination.bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</main>

<!-- Thêm Font Awesome nếu chưa có -->
@section('scripts')
<!-- Thay thế FontAwesome bằng CDN mới -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
@endsection


@endsection
