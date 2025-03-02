@extends('admin.layout')

@section('title', 'Chi tiết giao dịch')

@section('content')
<div class="container">
    <h2>Chi tiết giao dịch - Ví #{{ $wallet->id }}</h2>
    <p><strong>Số dư hiện tại:</strong> {{ number_format($wallet->balance, 0, ',', '.') }} {{ strtoupper($wallet->currency) }}</p>

    @if($transactions->isEmpty())
        <p class="text-center mt-3">Không có giao dịch nào.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>ID Mã giao dịch</th>
                    <th>Loại giao dịch</th>
                    <th>Số tiền</th>
                    <th>Số dư trước</th>
                    <th>Số dư sau</th>
                    <th>Mô tả</th>
                    <th>Trạng thái</th>
                    <th>Thời gian tạo</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transactions as $key => $transaction)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $transaction->id }}</td>
                    <td>
                        @php
                            $transactionTypes = [
                                'deposit' => 'Nạp tiền',
                                'withdrawal' => 'Rút tiền',
                                'purchase' => 'Mua hàng',
                                'refund' => 'Hoàn tiền'
                            ];
                        @endphp
                        <span class="badge 
                            @if($transaction->transaction_type === 'deposit') bg-success
                            @elseif($transaction->transaction_type === 'withdrawal') bg-danger
                            @elseif($transaction->transaction_type === 'purchase') bg-primary
                            @elseif($transaction->transaction_type === 'refund') bg-warning
                            @endif">
                            {{ $transactionTypes[$transaction->transaction_type] ?? 'Không xác định' }}
                        </span>
                    </td>
                    <td>{{ number_format($transaction->amount, 0, ',', '.') }} {{ strtoupper($wallet->currency) }}</td>
                    <td>{{ number_format($transaction->balance_before, 0, ',', '.') }}</td>
                    <td>{{ number_format($transaction->balance_after, 0, ',', '.') }}</td>
                    <td>{{ $transaction->description }}</td>
                    <td>
                        <span class="badge {{ $transaction->status === 'completed' ? 'bg-success' : 'bg-warning' }}">
                            {{ ucfirst($transaction->status) }}
                        </span>
                    </td>
                    <td>{{ \Carbon\Carbon::parse($transaction->created_at)->format('d/m/Y H:i:s') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
    <a href="{{ route('wallet.index') }}" class="btn btn-secondary">Quay lại</a>
</div>
@endsection
