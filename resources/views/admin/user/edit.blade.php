@extends('admin.layout')

@section('title')
Chỉnh sửa Người Dùng | Quản trị Admin
@endsection

@section('title2')
Chỉnh sửa Người Dùng
@endsection

@section('content')
<form action="{{ route('user.update', $user->id) }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title">Chỉnh sửa người dùng</h3>
                <div class="tile-body">
                    <div class="row">
                        <div class="form-group col-md-3">
                            <label class="control-label">Tên đăng nhập</label>
                            <input class="form-control" type="text" name="username" value="{{ $user->username }}" required>
                        </div>
                        <div class="form-group col-md-3">
                            <label class="control-label">Mật khẩu</label>
                            <input class="form-control" type="password" name="password">
                            <small>Chỉ nhập khi bạn muốn thay đổi mật khẩu</small>
                        </div>
                        <div class="form-group col-md-3">
                            <label class="control-label">Họ và Tên</label>
                            <input class="form-control" type="text" name="fullname" value="{{ $user->fullname }}" required>
                        </div>
                        <div class="form-group col-md-3">
                            <label class="control-label">Email</label>
                            <input class="form-control" type="email" name="email" value="{{ $user->email }}" required>
                        </div>
                        <div class="form-group col-md-3">
                            <label class="control-label">Số điện thoại</label>
                            <input class="form-control" type="number" name="phone" value="{{ $user->phone }}" required>
                        </div>
                        <div class="form-group col-md-3">
                            <label class="control-label">Giới tính</label>
                            <select class="form-control" name="gender" required>
                                <option value="">-- Chọn giới tính --</option>
                                <option value="Male" @if($user->gender == 'Male') selected @endif>Nam</option>
                                <option value="Female" @if($user->gender == 'Female') selected @endif>Nữ</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label class="control-label">Địa chỉ</label>
                            <input class="form-control" type="text" name="address" value="{{ $user->address }}" required>
                        </div>
                        <div class="form-group col-md-3">
                            <label class="control-label">Chức vụ</label>
                            <select class="form-control" name="role" required>
                                <option value="">-- Chọn chức vụ --</option>
                                <option value="employee" @if($user->role == 'employee') selected @endif>Nhân viên</option>
                                <option value="user" @if($user->role == 'user') selected @endif>Khách hàng</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label class="control-label">Trạng thái</label>
                            <select class="form-control" name="status" required>
                                <option value="">-- Chọn trạng thái --</option>
                                <option value="1" @if($user->status == 1) selected @endif>Hoạt động</option>
                                <option value="0" @if($user->status == 0) selected @endif>Không hoạt động</option>
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
                    <a class="btn btn-cancel" href="{{ route('user.index') }}">Hủy bỏ</a>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection