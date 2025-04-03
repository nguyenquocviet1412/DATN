@extends('admin.layout')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4 text-center text-primary">Chi Tiết Giao Dịch</h1>

    <!-- Card để hiển thị thông tin giao dịch -->
    <div class="card">
        <div class="card-body">
            <h4 class="card-title mb-4">Thông tin giao dịch</h4>
            <div class="row">
                <!-- Dòng đầu tiên: ID giao dịch và Loại giao dịch -->
                <div class="col-md-6 mb-3">
                    <p><strong>ID Giao Dịch:</strong> <span class="text-muted">{{ $transaction->id }}</span></p>
                </div>
                <div class="col-md-6 mb-3">
                    <p><strong>Loại Giao Dịch:</strong>
                        @php
                            $transactionTypes = [
                                'deposit' => 'Nạp tiền',
                                'withdrawal' => 'Rút tiền',
                                'purchase' => 'Mua hàng',
                                'refund' => 'Hoàn trả'
                            ];
                        @endphp
                        <span class="badge bg-primary">{{ $transactionTypes[$transaction->transaction_type] ?? ucfirst($transaction->transaction_type) }}</span>
                    </p>
                </div>

                <!-- Dòng thứ hai: Số tiền và số dư -->
                <div class="col-md-6 mb-3">
                    <p><strong>Số Tiền:</strong> <span class="text-success">{{ number_format($transaction->amount, 0) }} VND</span></p>
                </div>
                <div class="col-md-6 mb-3">
                    <p><strong>Số Dư Trước:</strong> <span class="text-danger">{{ number_format($transaction->balance_before, 0) }} VND</span></p>
                </div>

                <!-- Dòng thứ ba: Số dư sau và trạng thái -->
                <div class="col-md-6 mb-3">
                    <p><strong>Số Dư Sau:</strong> <span class="text-primary">{{ number_format($transaction->balance_after, 0) }} VND</span></p>
                </div>
                <div class="col-md-6 mb-3">
                    <p><strong>Trạng Thái:</strong>
                        <span class="badge bg-{{ $transaction->status == 'completed' ? 'success' : ($transaction->status == 'pending' ? 'warning' : 'danger') }}">
                            {{ ucfirst($transaction->status) }}
                        </span>
                    </p>
                </div>

                <!-- Dòng cuối cùng: Mô tả và thời gian -->
                <div class="col-md-12 mb-3">
                    <p><strong>Mô Tả:</strong> <span class="text-muted">{{ $transaction->description ?? 'Chưa có mô tả' }}</span></p>
                </div>
                <div class="col-md-12 mb-3">
                    <p><strong>Thời Gian:</strong> <span class="text-muted">{{ $transaction->created_at->format('d/m/Y H:i') }}</span></p>
                </div>
            </div>

            <!-- Nút quay lại -->
            <a href="{{ route('admin.wallet_transactions.index') }}" class="btn btn-primary">
                <i class="bx bx-arrow-back"></i> Quay lại
            </a>
        </div>
    </div>
</div>
@endsection
