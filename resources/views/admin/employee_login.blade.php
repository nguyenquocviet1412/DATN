<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Nhập Quản Trị</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #4b6cb7, #182848);
            height: 100vh;
        }
        .login-container {
            max-width: 400px;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease-in-out;
        }
        .login-container:hover {
            transform: scale(1.02);
        }
    </style>
</head>

{{-- Lời chào khi đăng xuất --}}
<!-- Thêm thư viện SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        @if (session('logout_success'))
            Swal.fire({
                title: "Chào tạm biệt!",
                text: "Hẹn gặp lại lần sau!",
                icon: "success",
                background: "#2c2c2c", // Nền tối
                color: "#fff", // Màu chữ trắng
                timer: 5000, // Tự động đóng sau 3 giây
                showConfirmButton: false,
                toast: true,
                position: "top-end"
            });
        @endif
    });
</script>


<body class="d-flex justify-content-center align-items-center">

    <div class="login-container">
        <h3 class="text-center text-primary">Đăng Nhập Admin</h3>
        <form action="{{ route('admin.login') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" id="email" name="email" class="form-control" placeholder="Nhập email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Mật khẩu</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="Nhập mật khẩu" required>
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" id="remember" name="remember" class="form-check-input">
                <label for="remember" class="form-check-label">Nhớ đăng nhập</label>
            </div>
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            <button type="submit" class="btn btn-primary w-100">Đăng Nhập</button>
        </form>
        <div class="text-center mt-3">
            <a href="#" class="text-decoration-none">Quên mật khẩu?</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
