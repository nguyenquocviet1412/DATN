@extends('master.main')
@section('title', 'Đổi mật khẩu')
@section('main')
<div style="background: linear-gradient(to bottom right, #d4f1c5, #fbd3c3); padding: 30px; border-radius: 15px; max-width: 800px; margin: 50px auto;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card shadow-lg border-0 rounded-4 text-center" style="background: #ffffff; padding: 20px;">
                    <div class="card-body">
                        <div class="mb-4">
                            <div class="rounded-circle mx-auto" style="width: 80px; height: 80px; background: #f1f1f1; display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-person-circle" style="font-size: 40px; color: #b08d57;"></i> <!-- Changed color to match brown -->
                            </div>
                        </div>
                        <h2 class="card-title mb-4 text-uppercase fw-bold" style="color: #b08d57;">Đổi mật khẩu</h2>
                        @if (session('success'))
                            <div class="alert alert-success text-center">{{ session('success') }}</div>
                        @endif
                        <form action="{{ route('user.change-password') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="bi bi-lock"></i></span>
                                    <input type="password" name="current_password" class="form-control rounded-end" placeholder="Mật khẩu hiện tại" 
                                           style="background: #ffffff; border: 1px solid #ced4da; padding: 10px; transition: border-color 0.3s ease;" 
                                           onfocus="this.style.borderColor='#007bff';" 
                                           onblur="this.style.borderColor='#ced4da';">
                                </div>
                                @error('current_password')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="bi bi-shield-lock"></i></span>
                                    <input type="password" name="new_password" class="form-control rounded-end" placeholder="Mật khẩu mới" 
                                           style="background: #ffffff; border: 1px solid #ced4da; padding: 10px; transition: border-color 0.3s ease;" 
                                           onfocus="this.style.borderColor='#007bff';" 
                                           onblur="this.style.borderColor='#ced4da';">
                                </div>
                                @error('new_password')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="bi bi-shield-check"></i></span>
                                    <input type="password" name="new_password_confirmation" class="form-control rounded-end" placeholder="Nhập lại mật khẩu mới" 
                                           style="background: #ffffff; border: 1px solid #ced4da; padding: 10px; transition: border-color 0.3s ease;" 
                                           onfocus="this.style.borderColor='#007bff';" 
                                           onblur="this.style.borderColor='#ced4da';">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 py-2 rounded-pill" style="background: #b08d57; border: none;">Đổi mật khẩu</button> <!-- Changed background color to brown -->
                            <div class="mt-3">
                                <a href="#" class="text-decoration-none" style="color: #007bff;">Quay lại đăng nhập</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
