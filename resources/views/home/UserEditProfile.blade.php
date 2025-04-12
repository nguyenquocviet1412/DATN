@extends('master.main')
@section('title', 'Cập nhật tài khoản')
@section('main')
<div style="background: linear-gradient(to bottom right, #d4f1c5, #fbd3c3); padding: 30px; border-radius: 15px; max-width: 800px; margin: 50px auto;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-lg rounded-3 border-0">
                    <div class="card-body p-4">
                        <h2 class="card-title mb-4 text-center" style="color: #b38b59;">Cập nhật thông tin cá nhân</h2>

                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <form action="{{ route('user.profile.update') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Tên</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name', $user->fullname) }}" placeholder="Nhập tên của bạn">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Địa chỉ</label>
                                <input type="text" name="address" class="form-control" value="{{ old('address', $user->address) }}" placeholder="Nhập địa chỉ của bạn">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Số điện thoại</label>
                                <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}" placeholder="Nhập số điện thoại của bạn">
                            </div>

                            <div class="mb-5">
                                <label class="form-label">Giới tính</label><br>
                                <select name="gender" class="form-select">
                                    <option value="Male" {{ $user->gender == 'Male' ? 'selected' : '' }}>Nam</option>
                                    <option value="Female" {{ $user->gender == 'Female' ? 'selected' : '' }}>Nữ</option>
                                    <option value="Other" {{ $user->gender == 'Other' ? 'selected' : '' }}>Khác</option>
                                </select><br>
                            </div>

                            <div class="d-flex justify-content-center mt-">
                                <button type="submit" class="btn btn-lg px-5 py-2 rounded-pill shadow-sm"
                                        style="background-color: #b38b59; border-color: #b38b59; transition: all 0.3s;">
                                    Cập nhật
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
