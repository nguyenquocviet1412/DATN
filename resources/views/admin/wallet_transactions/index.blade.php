@extends('admin.layout')

@section('title', 'Lịch Sử Giao Dịch')
@section('header', 'Lịch Sử Giao Dịch')
@section('title2', 'Lịch Sử Giao Dịch')

@section('content')
    <table class="table table-hover table-bordered" id="sampleTable">
        <!-- Bộ lọc -->
        <form method="GET" action="{{ route('admin.wallet_transactions.index') }}"
            style="display: flex; gap: 10px; align-items: center; margin-bottom: 20px;">
            <i class="app-menu__icon bx bx-filter"></i>

            <!-- Lọc loại giao dịch -->
            <label for="transaction_type">Loại giao dịch:</label>
            <select name="transaction_type" id="transaction_type"
                style="padding: 5px; border-radius: 5px; border: 1px solid #ccc;">
                <option value="">Tất cả</option>
                <option value="deposit" {{ request('transaction_type') == 'deposit' ? 'selected' : '' }}>Nạp tiền</option>
                <option value="withdrawal" {{ request('transaction_type') == 'withdrawal' ? 'selected' : '' }}>Rút tiền</option>
                <option value="purchase" {{ request('transaction_type') == 'purchase' ? 'selected' : '' }}>Mua hàng</option>
                <option value="refund" {{ request('transaction_type') == 'refund' ? 'selected' : '' }}>Hoàn trả</option>
            </select>

            <!-- Lọc trạng thái -->
            <label for="status">Trạng thái:</label>
            <select name="status" id="status"
                style="padding: 5px; border-radius: 5px; border: 1px solid #ccc;">
                <option value="">Tất cả</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Đang chờ</option>
                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Hoàn tất</option>
                <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Thất bại</option>
            </select>

            <!-- Lọc theo thời gian -->
            <label for="from_date">Từ ngày:</label>
            <input type="date" name="from_date" id="from_date" value="{{ request('from_date') }}"
                style="padding: 5px; border-radius: 5px; border: 1px solid #ccc;">

            <label for="to_date">Đến ngày:</label>
            <input type="date" name="to_date" id="to_date" value="{{ request('to_date') }}"
                style="padding: 5px; border-radius: 5px; border: 1px solid #ccc;">

            <!-- Nút lọc -->
            <button type="submit"
                style="padding: 7px 15px; border-radius: 5px; background-color: #007bff; color: white; border: none; cursor: pointer;">
                <i class="bx bx-search"></i> Lọc
            </button>
        </form>

        <!-- Bảng dữ liệu -->
        <thead>
            <tr>
                <th>ID</th>
                <th>Tài khoản giao dịch</th>
                <th>Loại giao dịch</th>
                <th>Số tiền</th>
                <th>Số dư trước</th>
                <th>Số dư sau</th>
                <th>Trạng thái</th>
                <th>Thời gian</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transactions as $transaction)
                <tr>
                    <td>{{ $transaction->id }}</td>

                    <!-- Hiển thị tài khoản giao dịch -->
                    <td>
                        @if ($transaction->wallet && $transaction->wallet->user)
                            {{ $transaction->wallet->user->fullname }} ({{ $transaction->wallet->user->email }})
                        @else
                            <span class="text-muted">Không xác định</span>
                        @endif
                    </td>

                    <td>
                        @php
                            $transactionTypes = [
                                'deposit' => 'Nạp tiền',
                                'withdrawal' => 'Rút tiền',
                                'purchase' => 'Mua hàng',
                                'refund' => 'Hoàn trả'
                            ];
                        @endphp
                        {{ $transactionTypes[$transaction->transaction_type] ?? ucfirst($transaction->transaction_type) }}
                    </td>
                    <td>{{ number_format($transaction->amount, 0) }} VND</td>
                    <td>{{ number_format($transaction->balance_before, 0) }} VND</td>
                    <td>{{ number_format($transaction->balance_after, 0) }} VND</td>
                    <td>
                        @php
                            $statusLabels = [
                                'pending' => ['label' => 'Đang chờ', 'class' => 'warning'],
                                'completed' => ['label' => 'Hoàn tất', 'class' => 'success'],
                                'failed' => ['label' => 'Thất bại', 'class' => 'danger']
                            ];
                        @endphp
                        <span class="badge bg-{{ $statusLabels[$transaction->status]['class'] ?? 'secondary' }}">
                            {{ $statusLabels[$transaction->status]['label'] ?? ucfirst($transaction->status) }}
                        </span>
                    </td>
                    <td>{{ $transaction->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        <a href="{{ route('admin.wallet_transactions.show', $transaction->id) }}"
                            class="btn btn-sm btn-info">Xem</a>
                        <form action="{{ route('admin.wallet_transactions.destroy', $transaction->id) }}" method="POST"
                            class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>

    </table>

    <!-- Phân trang -->
    <div class="d-flex justify-content-center">
        {{ $transactions->appends(request()->query())->links('pagination::bootstrap-4') }}
    </div>
@endsection
