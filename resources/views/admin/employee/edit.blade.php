@extends('admin.layout')

@section('title')
Chỉnh sửa Nhân Viên | Quản trị Admin
@endsection

@section('title2')
Chỉnh sửa Nhân Viên
@endsection

@section('content')

{{-- Thông báo --}}
{{-- thông báo thêm thành công --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if(session('success'))
<script>
    Swal.fire({
        title: 'Thành công!',
        text: '{{ session("success") }}',
        icon: 'success',
        showConfirmButton: false,
        timer: 4000,
        backdrop: true // Làm tối nền
    });
</script>
@endif


{{-- Thông báo lỗi --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if(session('error'))
<script>
    Swal.fire({
        title: 'Lỗi!',
        text: '{{ session("error") }}',
        icon: 'error',
        showConfirmButton: true, // Hiển thị nút đóng
        confirmButtonText: 'Đóng', // Nội dung nút đóng
        backdrop: true // Làm tối nền
    });
</script>
@endif

@php
    if ($employee->role === 'admin')
        $checkRole = 'disabled';
    else
        $checkRole = '';
@endphp

<form action="{{ route('employee.update', $employee->id) }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title">Chỉnh sửa nhân viên</h3>
                <div class="tile-body">
                    <div class="row">
                        <div class="form-group col-md-3">
                            <label class="control-label">Tên đăng nhập</label>
                            <input class="form-control" type="text" name="username" value="{{ $employee->username }}" required >
                        </div>
                        <div class="form-group col-md-3">
                            <label class="control-label">Mật khẩu</label>
                            <input class="form-control" type="password" name="password">
                            <small>Chỉ nhập khi bạn muốn thay đổi mật khẩu</small>
                        </div>
                        <div class="form-group col-md-3">
                            <label class="control-label">Họ và tên</label>
                            <input class="form-control" type="text" name="fullname" value="{{ $employee->fullname }}" required >
                        </div>
                        <div class="form-group col-md-3">
                            <label class="control-label">Email</label>
                            <input class="form-control" type="email" name="email" value="{{ $employee->email }}" required>
                        </div>
                        @if ($employee->role === 'superadmin')
                            <div class="form-group col-md-3">
                                <label class="control-label">Vai trò</label>
                                <select class="form-control" name="role" required {{ $checkRole }}>
                                    <option value="">-- Chọn vai trò --</option>
                                    <option value="admin" @if($employee->role == 'admin') selected @endif>Nhân viên</option>
                                    <option value="superadmin" @if($employee->role == 'superadmin') selected @endif>Quản lý</option>
                                </select>
                            </div>
                        @endif

                        <div class="form-group col-md-3">
                            <label class="control-label">Số điện thoại</label>
                            <input class="form-control" type="number" name="phone" value="{{ $employee->phone }}" required>
                        </div>
                        <div class="form-group col-md-3">
                            <label class="control-label">Giới tính</label>
                            <select class="form-control" name="gender" required>
                                <option value="">-- Chọn giới tính --</option>
                                <option value="Male" @if($employee->gender == 'Male') selected @endif>Nam</option>
                                <option value="Female" @if($employee->gender == 'Female') selected @endif>Nữ</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label class="control-label">Ngày sinh</label>
                            <input class="form-control" type="date" name="date_of_birth" value="{{ $employee->date_of_birth }}" required>
                        </div>
                        <div class="form-group col-md-3">
                            <label class="control-label">Địa chỉ</label>
                            <input class="form-control" type="text" name="address" value="{{ $employee->address }}" required>
                        </div>
                        @if ($employee->role === 'superadmin')
                            <div class="form-group col-md-3">
                                <label class="control-label">Chức vụ</label>
                                <input class="form-control" type="text" name="position" value="{{ $employee->position }}" required {{ $checkRole }}>
                            </div>
                            <div class="form-group col-md-3">
                                <label class="control-label">Trạng thái</label>
                                <select class="form-control" name="status" required {{ $checkRole }}>
                                    <option value="">-- Chọn trạng thái --</option>
                                    <option value="active" @if($employee->status == 'active') selected @endif>Hoạt động</option>
                                    <option value="inactive" @if($employee->status == 'inactive') selected @endif>Vô hiệu hóa</option>
                                </select>
                            </div>
                        @endif


                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                    </div>
                    <button class="btn btn-save" type="submit">Lưu lại</button>
                    <a class="btn btn-cancel" href="{{ route('employee.index') }}">Hủy bỏ</a>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
