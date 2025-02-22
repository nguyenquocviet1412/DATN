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
                            <label class="control-label">Username</label>
                            <input class="form-control" type="text" name="username" required>
                        </div>
                        <div class="form-group col-md-3">
                            <label class="control-label">Password</label>
                            <input class="form-control" type="password" name="password" required>
                        </div>
                        <div class="form-group col-md-3">
                            <label class="control-label">Fullname</label>
                            <input class="form-control" type="text" name="fullname" required>
                        </div>
                        <div class="form-group col-md-3">
                            <label class="control-label">Email</label>
                            <input class="form-control" type="email" name="email" required>
                        </div>

                        <div class="form-group col-md-3">
                            <label class="control-label">Phone</label>
                            <input class="form-control" type="number" name="phone" required>
                        </div>
                        <div class="form-group col-md-3">
                            <label class="control-label">Gender</label>
                            <select class="form-control" name="gender" required>
                                <option value="">-- Choose gender --</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label class="control-label">Date of Birth</label>
                            <input class="form-control" type="date" name="date_of_birth" required>
                        </div>
                        <div class="form-group col-md-3">
                            <label class="control-label">Address</label>
                            <input class="form-control" type="text" name="address" required>
                        </div>
                        <div class="form-group col-md-3">
                            <label class="control-label">Position</label>
                            <input class="form-control" type="text" name="position" required>
                        </div>
                        <div class="form-group col-md-3">
                            <label class="control-label">Salary</label>
                            <input class="form-control" type="number" name="salary" required>
                        </div>
                        <div class="form-group col-md-3">
                            <label class="control-label">Status</label>
                            <select class="form-control" name="status" required>
                                <option value="">-- Choose status --</option>
                                <option value="Activity">Activity</option>
                                <option value="Disable">Disable</option>
                            </select>
                        </div>
                    </div>
                    <button class="btn btn-save" type="submit">Lưu lại</button>
                    <a class="btn btn-cancel" href="{{ route('employee.index') }}">Hủy bỏ</a>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection