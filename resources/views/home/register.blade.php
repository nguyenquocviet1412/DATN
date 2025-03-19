@extends('master.main')
@section('title', 'Đăng ký')
@section('main')

<main>
    <!-- Breadcrumb -->
    <div class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb-wrap">
                        <nav aria-label="breadcrumb">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home.index') }}"><i class="fa fa-home"></i></a></li>
                                <li class="breadcrumb-item active" aria-current="page">Đăng ký</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Form đăng ký -->
    <div class="login-register-wrapper section-padding">
        <div class="container">
            <div class="member-area-from-wrap">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="login-reg-form-wrap sign-up-form">
                            <h5>Đăng ký tài khoản</h5>
                            @if(session('message'))
                                <div class="alert alert-success">{{ session('message') }}</div>
                            @endif
                            <form action="{{ route('postRegister') }}" method="POST">
                                @csrf
                                <div class="single-input-item">
                                    <label>Họ và Tên</label>
                                    <input type="text" name="fullname" value="{{ old('fullname') }}" placeholder="Nhập họ và tên" required />
                                    @error('fullname')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="single-input-item">
                                    <label>Email</label>
                                    <input type="email" name="email" value="{{ old('email') }}" placeholder="Nhập email" required />
                                    @error('email')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="single-input-item">
                                    <label>Số điện thoại</label>
                                    <input type="text" name="phone" value="{{ old('phone') }}" placeholder="Nhập số điện thoại" required />
                                    @error('phone')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="single-input-item">
                                    <label>Địa chỉ</label>
                                    <input type="text" name="address" value="{{ old('address') }}" placeholder="Nhập địa chỉ" required />
                                    @error('address')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="single-input-item">
                                    <label>Giới tính</label>
                                    <select name="gender" required>
                                        <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Nam</option>
                                        <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Nữ</option>
                                        <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Khác</option>
                                    </select>
                                    @error('gender')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="single-input-item">
                                            <label>Mật khẩu</label>
                                            <input type="password" name="password" placeholder="Nhập mật khẩu" required />
                                            @error('password')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="single-input-item">
                                            <label>Nhập lại mật khẩu</label>
                                            <input type="password" name="password_confirmation" placeholder="Nhập lại mật khẩu" required />
                                        </div>
                                    </div>
                                </div>

                                <div class="single-input-item">
                                    <button class="btn btn-sqr">Đăng ký</button>
                                </div>
                            </form>

                            <p>Bạn đã có tài khoản? <a href="{{ route('login') }}">Đăng nhập ngay</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@endsection
