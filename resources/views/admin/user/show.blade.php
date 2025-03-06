@extends('admin.layout')
@section('title', 'Chi tiết Nhân viên | Quản trị Admin')
@section('title2', 'Chi tiết Nhân viên')

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <div class="tile-body">

                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                @if(session('success'))
                <script>
                    Swal.fire({
                        title: 'Thành công!',
                        text: '{{ session("success") }}',
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 4000,
                        backdrop: true
                    });
                </script>
                @endif

                @if(session('error'))
                <script>
                    Swal.fire({
                        title: 'Lỗi!',
                        text: '{{ session("error") }}',
                        icon: 'error',
                        showConfirmButton: true,
                        confirmButtonText: 'Đóng',
                        backdrop: true
                    });
                </script>
                @endif

                <div class="card mb-4 shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Thông Tin Người Dùng</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tr><th>Vai trò:</th><td>{{ $user->role ?? 'Không có dữ liệu' }}</td></tr>
                            <tr><th>Họ và Tên:</th><td>{{ $user->fullname ?? 'Không có dữ liệu' }}</td></tr>
                            <tr><th>Email:</th><td>{{ $user->email ?? 'Không có dữ liệu' }}</td></tr>
                            <tr><th>Số điện thoại:</th><td>{{ $user->phone ?? 'Không có dữ liệu' }}</td></tr>
                            <tr><th>Địa chỉ:</th><td>{{ $user->address ?? 'Không có dữ liệu' }}</td></tr>
                            <tr><th>Ngày tạo:</th><td>{{ $user->created_at ?? 'Không có dữ liệu' }}</td></tr>
                            <tr>
                                <th>Trạng thái:</th>
                                <td>
                                    <span class="badge {{ $user->status ? 'badge-success' : 'badge-danger' }}">
                                        {{ $user->status ? 'Hoạt động' : 'Không hoạt động' }}
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="card mb-4 shadow-sm">
                    <div class="card-header bg-success text-white">
                        <h4 class="mb-0">Thông Tin Ví Tiền</h4>
                    </div>
                    <div class="card-body">
                        @if($wallet)
                            <table class="table table-bordered">
                                <tr>
                                    <th>Số dư:</th>
                                    <td><strong>{{ number_format($wallet->balance, 0, ',', '.') }} VNĐ</strong></td>
                                </tr>
                                <tr>
                                    <th>Trạng thái ví:</th>
                                    <td>
                                        <span class="badge {{ $wallet->status ? 'badge-success' : 'badge-danger' }}">
                                            {{ $wallet->status ? 'Đang hoạt động' : 'Bị khóa' }}
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        @else
                            <p class="text-danger">Người dùng chưa có ví.</p>
                        @endif
                    </div>
                </div>

                <div class="card shadow-sm">
                    <div class="card-header bg-dark text-white">
                        <h4 class="mb-0">Lịch Sử Giao Dịch</h4>
                    </div>
                    <div class="card-body">
                        @if($wallet && $wallet_transactions->isNotEmpty())
                            <table class="table table-hover table-bordered">
                                <thead>
                                    <tr class="text-center">
                                        <th>Loại giao dịch</th>
                                        <th>Số tiền</th>
                                        <th>Mô tả</th>
                                        <th>Trạng thái</th>
                                        <th>Ngày tạo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($wallet_transactions as $transaction)
                                    <tr class="align-middle text-center">
                                        <td>
                                            <span class="badge badge-{{ $transaction->transaction_type == 'deposit' ? 'success' : ($transaction->transaction_type == 'withdrawal' ? 'danger' : ($transaction->transaction_type == 'purchase' ? 'primary' : 'warning')) }}">
                                                {{ ucfirst($transaction->transaction_type) }}
                                            </span>
                                        </td>
                                        <td><strong>{{ number_format($transaction->amount, 0, ',', '.') }} VNĐ</strong></td>
                                        <td>{{ $transaction->description ?? 'Không có mô tả' }}</td>
                                        <td>
                                            <span class="badge badge-{{ $transaction->status == 'success' ? 'success' : ($transaction->status == 'pending' ? 'warning' : 'danger') }}">
                                                {{ ucfirst($transaction->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $transaction->created_at }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <p class="text-muted text-center">Chưa có giao dịch nào</p>
                        @endif
                    </div>
                </div>

                <a href="{{ route('user.index') }}" class="btn btn-primary mt-3">Quay lại danh sách</a>
            </div>
        </div>
    </div>
</div>

<style>
    .card {
        border-radius: 10px;
        overflow: hidden;
    }
    .table th {
        background-color: #f8f9fa;
    }
    .badge {
        font-size: 14px;
        padding: 5px 10px;
    }
</style>

@endsection
