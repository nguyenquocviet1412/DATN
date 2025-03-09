@extends('admin.layout')

@section('title')
Chỉnh sửa Nhân Viên | Quản trị Admin
@endsection

@section('title2')
Chỉnh sửa Nhân Viên
@endsection

@section('content')
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
                            <label class="control-label">Username</label>
                            <input class="form-control" type="text" name="username" value="{{ $employee->username }}" required>
                        </div>
                        <div class="form-group col-md-3">
                            <label class="control-label">Password</label>
                            <input class="form-control" type="password" name="password">
                            <small>Chỉ nhập khi bạn muốn thay đổi mật khẩu</small>
                        </div>
                        <div class="form-group col-md-3">
                            <label class="control-label">Fullname</label>
                            <input class="form-control" type="text" name="fullname" value="{{ $employee->fullname }}" required>
                        </div>
                        <div class="form-group col-md-3">
                            <label class="control-label">Email</label>
                            <input class="form-control" type="email" name="email" value="{{ $employee->email }}" required>
                        </div>
                        <div class="form-group col-md-3">
                            <label class="control-label">Role</label>
                            <select class="form-control" name="role" required>
                                <option value="">-- Choose role --</option>
                                <option value="employee" @if($employee->role == 'employee') selected @endif>Employee</option>
                                <option value="user" @if($employee->role == 'user') selected @endif>User</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label class="control-label">Phone</label>
                            <input class="form-control" type="number" name="phone" value="{{ $employee->phone }}" required>
                        </div>
                        <div class="form-group col-md-3">
                            <label class="control-label">Gender</label>
                            <select class="form-control" name="gender" required>
                                <option value="">-- Choose gender --</option>
                                <option value="Male" @if($employee->gender == 'Male') selected @endif>Male</option>
                                <option value="Female" @if($employee->gender == 'Female') selected @endif>Female</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label class="control-label">Date of Birth</label>
                            <input class="form-control" type="date" name="date_of_birth" value="{{ $employee->date_of_birth }}" required>
                        </div>
                        <div class="form-group col-md-3">
                            <label class="control-label">Address</label>
                            <input class="form-control" type="text" name="address" value="{{ $employee->address }}" required>
                        </div>
                        <div class="form-group col-md-3">
                            <label class="control-label">Position</label>
                            <input class="form-control" type="text" name="position" value="{{ $employee->position }}" required>
                        </div>
                        <div class="form-group col-md-3">
                            <label class="control-label">Status</label>
                            <select class="form-control" name="status" required>
                                <option value="">-- Choose status --</option>
                                <option value="1" @if($employee->status == 1) selected @endif>Activity</option>
                                <option value="0" @if($employee->status == 0) selected @endif>Disable</option>
                            </select>
                        </div>
                        <!-- @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif -->
                    </div>
                    <button class="btn btn-save" type="submit">Lưu lại</button>
                    <a class="btn btn-cancel" href="{{ route('employee.index') }}">Hủy bỏ</a>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
