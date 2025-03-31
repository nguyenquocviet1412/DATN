@extends('admin.layout')
@section('title')
Thêm Nhân Viên | Quản trị Admin
@endsection
@section('title2')
Thêm Nhân Viên
@endsection
@section('content')
<form action="{{ route('employee.store') }}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title">Tạo mới nhân viên</h3>
                <div class="tile-body">
                    <div class="row">
                        <div class="form-group col-md-3">
                            <label class="control-label">Tên đăng nhập</label>
                            <input class="form-control" type="text" name="username" required>
                        </div>
                        <div class="form-group col-md-3">
                            <label class="control-label">Mật khẩu</label>
                            <input class="form-control" type="password" name="password" required>
                        </div>
                        <div class="form-group col-md-3">
                            <label class="control-label">Họ và tên</label>
                            <input class="form-control" type="text" name="fullname" required>
                        </div>
                        <div class="form-group col-md-3">
                            <label class="control-label">Email</label>
                            <input class="form-control" type="email" name="email" required>
                        </div>

                        <div class="form-group col-md-3">
                            <label class="control-label">Số điện thoại</label>
                            <input class="form-control" type="number" name="phone" required>
                        </div>
                        <div class="form-group col-md-3">
                            <label class="control-label">Giới tính</label>
                            <select class="form-control" name="gender" required>
                                <option value="">-- Chọn giới tính --</option>
                                <option value="Male">Nam</option>
                                <option value="Female">Nữ</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label class="control-label">Ngày sinh</label>
                            <input class="form-control" type="date" name="date_of_birth" required>
                        </div>
                        <div class="form-group col-md-3">
                            <label class="control-label">Địa chỉ</label>
                            <input class="form-control" type="text" name="address" required>
                        </div>
                        <div class="form-group col-md-3">
                            <label class="control-label">Chức vụ</label>
                            <input class="form-control" type="text" name="position" required>
                        </div>
                        <div class="form-group col-md-3">
                            <label class="control-label">Vai trò</label>
                            <select class="form-control" name="role" required>
                                <option value="">-- Chọn vai trò --</option>
                                <option value="1">Người dùng</option>
                                <option value="0">Nhân viên</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label class="control-label">Trạng thái</label>
                            <select class="form-control" name="status" required>
                                <option value="">-- Chọn trạng thái --</option>
                                <option value="1">Hoạt động</option>
                                <option value="0">Vô hiệu hóa</option>
                            </select>
                        </div>
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