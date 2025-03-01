@extends('admin.layout')

@section('content')
    <h1>Chi tiết giao dịch</h1>
    <p><strong>ID:</strong> {{ $transaction->id }}</p>
    <p><strong>Loại giao dịch:</strong> {{ $transaction->transaction_type }}</p>
    <p><strong>Số tiền:</strong> {{ number_format($transaction->amount, 0) }} VND</p>
    <p><strong>Số dư trước:</strong> {{ number_format($transaction->balance_before, 0) }} VND</p>
    <p><strong>Số dư sau:</strong> {{ number_format($transaction->balance_after, 0) }} VND</p>
    <p><strong>Trạng thái:</strong> {{ $transaction->status }}</p>
    <p><strong>Mô tả:</strong> {{ $transaction->description }}</p>
    <a href="{{ route('admin.wallet_transactions.index') }}">Quay lại</a>
@endsection
