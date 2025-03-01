@extends('admin.layout')

@section('title', 'Lịch Sử Giao Dịch')
@section('header', 'Lịch Sử Giao Dịch')
@section('title2', 'Lịch Sử Giao Dịch')

@section('content')
    <table class="table">
        <form method="GET" action="{{ route('admin.wallet_transactions.index') }}" style="display: flex; gap: 10px; align-items: center; margin-bottom: 20px;">
            <i class="app-menu__icon bx bx-filter"></i>
            <label for="transaction_type">Loại giao dịch:</label>
            <select name="transaction_type" id="transaction_type" style="padding: 5px; border-radius: 5px; border: 1px solid #ccc;">
                <option value="">Tất cả</option>
                <option value="withdraw">Rút tiền</option>
                <option value="transfer">Chuyển tiền</option>
                <option value="refund">Hoàn trả</option>
            </select>
        
            <label for="from_date">Từ ngày:</label>
            <input type="date" name="from_date" id="from_date" style="padding: 5px; border-radius: 5px; border: 1px solid #ccc;">
        
            <label for="to_date">Đến ngày:</label>
            <input type="date" name="to_date" id="to_date" style="padding: 5px; border-radius: 5px; border: 1px solid #ccc;">
        
            <button type="submit" style="padding: 7px 15px; border-radius: 5px; background-color: #007bff; color: white; border: none; cursor: pointer;">
                <i class="bx bx-search"></i> Lọc
            </button>
        </form>
        <thead>
            <tr>
                <th>ID</th>
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
                    <td>{{ ucfirst($transaction->transaction_type) }}</td>
                    <td>{{ number_format($transaction->amount, 0) }} VND</td>
                    <td>{{ number_format($transaction->balance_before, 0) }} VND</td>
                    <td>{{ number_format($transaction->balance_after, 0) }} VND</td>
                    <td>
                        <span class="badge bg-{{ $transaction->status == 'completed' ? 'success' : 'danger' }}">
                            {{ ucfirst($transaction->status) }}
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
@endsection
