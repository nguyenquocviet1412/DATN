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
                            <label class="control-label">Username</label>
                            <input class="form-control" type="text" name="username" value="{{ $user->username }}" required>
                        </div>
                        <div class="form-group col-md-3">
                            <label class="control-label">Password</label>
                            <input class="form-control" type="password" name="password">
                            <small>Chỉ nhập khi bạn muốn thay đổi mật khẩu</small>
                        </div>
                        <div class="form-group col-md-3">
                            <label class="control-label">Fullname</label>
                            <input class="form-control" type="text" name="fullname" value="{{ $user->fullname }}" required>
                        </div>
                        <div class="form-group col-md-3">
                            <label class="control-label">Email</label>
                            <input class="form-control" type="email" name="email" value="{{ $user->email }}" required>
                        </div>
                        <div class="form-group col-md-3">
                            <label class="control-label">Phone</label>
                            <input class="form-control" type="number" name="phone" value="{{ $user->phone }}" required>
                        </div>
                        <div class="form-group col-md-3">
                            <label class="control-label">Gender</label>
                            <select class="form-control" name="gender" required>
                                <option value="">-- Choose gender --</option>
                                <option value="Male" @if($user->gender == 'Male') selected @endif>Male</option>
                                <option value="Female" @if($user->gender == 'Female') selected @endif>Female</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label class="control-label">Address</label>
                            <input class="form-control" type="text" name="address" value="{{ $user->address }}" required>
                        </div>
                        <div class="form-group col-md-3">
                            <label class="control-label">Role</label>
                            <select class="form-control" name="role" required>
                                <option value="">-- Choose role --</option>
                                <option value="employee" @if($user->role == 'employee') selected @endif>Employee</option>
                                <option value="user" @if($user->role == 'user') selected @endif>User</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label class="control-label">Status</label>
                            <select class="form-control" name="status" required>
                                <option value="">-- Choose status --</option>
                                <option value="1" @if($user->status == 1) selected @endif>Activity</option>
                                <option value="0" @if($user->status == 0) selected @endif>Disable</option>
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