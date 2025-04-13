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
                            <tr><th>Họ và Tên:</th><td>{{ $user->fullname ?? 'Không có dữ liệu' }}</td></tr>
                            <tr><th>Ngày sinh:</th><td>{{ $user->birthday ?? 'Không có dữ liệu' }}</td></tr>
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
