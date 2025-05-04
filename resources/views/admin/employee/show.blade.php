@extends('admin.layout')
@section('title', 'Chi tiết nhân viên')
@section('content')

{{-- Thông báo thêm thành công --}}
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

{{-- Thông báo lỗi --}}
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

<div class="container mt-4">
    <div class="card shadow-lg p-4 rounded">
        <h2 class="text-center text-primary mb-4">Thông Tin Nhân Viên</h2>
        <div class="row">
            <div class="col-md-6">
                <p><strong>Tên đăng nhập:</strong> {{ $employee->username }}</p>
                <p><strong>Họ và Tên:</strong> {{ $employee->fullname }}</p>
                <p><strong>Email:</strong> {{ $employee->email }}</p>
                <p><strong>Số điện thoại:</strong> {{ $employee->phone }}</p>
                <p><strong>Giới tính:</strong> {{ $employee->gender }}</p>
            </div>
            <div class="col-md-6">
                <p><strong>Ngày sinh:</strong> {{ $employee->date_of_birth }}</p>
                <p><strong>Địa chỉ:</strong> {{ $employee->address }}</p>
                <p><strong>Chức vụ:</strong> {{ $employee->position }}</p>
                <p><strong>Trạng thái:</strong>
                    <span class="badge bg-{{ $employee->status ? 'success' : 'danger' }}">
                        {{ $employee->status ? 'Hoạt động' : 'Ngừng hoạt động' }}
                    </span>
                </p>
                <p><strong>Vai trò:</strong>
                    <span class="badge bg-{{ $employee->role == 'admin' ? 'danger' : 'info' }}">
                        {{ $employee->role == 'admin' ? 'Nhân viên thường' : 'Quản trị cấp cao' }}
                    </span>
                </p>
            </div>
        </div>
        <a href="{{ route('employee.index') }}" class="btn btn-secondary mt-3">Quay lại danh sách</a>
    </div>
</div>

<div class="container mt-5">
    <div class="card shadow-lg p-4 rounded">
        <h2 class="text-center text-primary">Lịch Sử Thao Tác</h2>

        <!-- Tìm kiếm -->
        <form method="GET" action="" class="mb-3 d-flex">
            <input type="text" name="search" class="form-control" placeholder="Tìm kiếm thao tác..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary ms-2">Tìm kiếm</button>
        </form>

        <table class="table table-striped table-hover text-center">
            <thead class="table-dark">
                <tr>
                    <th>Thời gian</th>
                    <th>Hành động</th>
                    <th>IP</th>
                    <th>Chi tiết</th>
                </tr>
            </thead>
            <tbody>
                @if($logs->isNotEmpty())
                    @foreach ($logs as $log)
                        <tr>
                            <td>{{ $log->created_at }}</td>
                            <td>{{ $log->action }}</td>
                            <td>{{ $log->ip_address }}</td>
                            <td>{{ $log->details }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="4" class="text-muted">Không có lịch sử thao tác</td>
                    </tr>
                @endif
            </tbody>
        </table>

        <!-- Phân trang -->
        <div class="d-flex justify-content-center mt-3">
            {{ $logs->appends(['search' => request('search')])->links() }}
        </div>
    </div>
</div>

<style>
    .card {
        border-radius: 12px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    }
    .table-hover tbody tr:hover {
        background-color: #f1f1f1;
    }
    .btn-primary {
        background-color: #007bff;
        border: none;
    }
    .btn-primary:hover {
        background-color: #0056b3;
    }
</style>
@endsection
