@extends('admin.layout')
@section('title')
Thêm người dùng | Quản trị Admin
@endsection
@section('title2')
Thêm người dùng
@endsection
@section('content')
<form action="{{ route('user.store') }}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title">Tạo mới người dùng </h3>
                <div class="tile-body">
                    <div class="row">
                        <div class="form-group col-md-3">
                            <label class="control-label">Fullname</label>
                            <input class="form-control" type="text" name="fullname" required>
                        </div>
                        <div class="form-group col-md-3">
                            <label class="control-label">email</label>
                            <input class="form-control" type="email" name="email" required>
                        </div>
                        <div class="form-group col-md-3">
                            <label class="control-label">password</label>
                            <input class="form-control" type="text" name="password" required>
                        </div>
                        <div class="form-group col-md-3">
                            <label class="control-label">phone</label>
                            <input class="form-control" type="number" name="phone" required>
                        </div>

                        <div class="form-group col-md-3">
                            <label class="control-label">address</label>
                            <input class="form-control" type="text" name="address" required>
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
                            <label class="control-label">Status</label>
                            <select class="form-control" name="status" required>
                                <option value="">-- Choose status --</option>
                                <option value="Activity">Activity</option>
                                <option value="Disable">Disable</option>
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