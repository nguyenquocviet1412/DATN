@extends('master.main')
@section('title', 'Đăng nhập')
@section('main')


<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
@if(session('message'))
<script>
    document.addEventListener("DOMContentLoaded", function() {
        Swal.fire({
            title: "Thành công!",
            text: "{{ session('message') }}",
            icon: "success",
            showConfirmButton: false,
            timer: 4000
        });
    });
</script>
@endif
@if(session('warning'))
<script>
    document.addEventListener("DOMContentLoaded", function() {
        Swal.fire({
            title: "Thông báo!",
            text: "{{ session('warning') }}",
            icon: "warning",
            showConfirmButton: true
        });
    });
</script>
@endif
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <main>
        <!-- breadcrumb area start -->
        <div class="breadcrumb-area">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="breadcrumb-wrap">
                            <nav aria-label="breadcrumb">
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.html"><i class="fa fa-home"></i></a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Đăng nhập người dùng</li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- breadcrumb area end -->

        <!-- login register wrapper start -->
        <div class="login-register-wrapper section-padding">
            <div class="container">
                <div class="member-area-from-wrap">
                    <div class="row">
                        <!-- Login Content Start -->
                        <div class="col-lg-6">
                            <div class="login-reg-form-wrap">
                                <h5>Đăng nhập</h5>

                                <!-- Hiển thị thông báo -->
                                @if(session('error'))
                                    <div class="alert alert-danger">{{ session('error') }}</div>
                                @endif
                                @if(session('success'))
                                    <div class="alert alert-success">{{ session('success') }}</div>
                                @endif

                                <form action="{{ route('postLogin') }}" method="POST">
                                    @csrf
                                    <div class="single-input-item">
                                        <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required />
                                        @error('email')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="single-input-item">
                                        <input type="password" name="password" placeholder="Mật khẩu" required />
                                        @error('password')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="single-input-item">
                                        <div class="login-reg-form-meta d-flex align-items-center justify-content-between">
                                            <div class="remember-meta">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" name="remember" class="custom-control-input" id="rememberMe">
                                                    <label class="custom-control-label" for="rememberMe">Ghi nhớ mật khẩu</label>
                                                </div>
                                            </div>
                                            <a href="#" class="forget-pwd">Quên mật khẩu</a>
                                        </div>
                                    </div>
                                    <div class="single-input-item">
                                        <button class="btn btn-sqr" type="submit">Login</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- Login Content End -->

                    </div>
                </div>
            </div>
        </div>
        <!-- login register wrapper end -->
    </main>

@endsection
