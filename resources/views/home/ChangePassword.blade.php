@extends('master.main')
@section('title', 'Đổi mật khẩu')
@section('main')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg rounded-3 border-0">
                <div class="card-body p-4">
                    <h2 class="card-title mb-4 text-center text-primary">Đổi mật khẩu</h2>

                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <form action="{{ route('user.change-password') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Mật khẩu hiện tại</label>
                            <input type="password" name="current_password" class="form-control">
                            @error('current_password')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Mật khẩu mới</label>
                            <input type="password" name="new_password" class="form-control">
                            @error('new_password')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nhập lại mật khẩu mới</label>
                            <input type="password" name="new_password_confirmation" class="form-control">
                        </div>

                        <div class="d-flex justify-content-center mt-4">
                            <button type="submit" class="btn btn-primary btn-lg px-5 py-2 rounded-pill shadow-sm"
                                    style="background-color: #4a90e2; border-color: #4a90e2; transition: all 0.3s;">
                                Đổi mật khẩu
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
