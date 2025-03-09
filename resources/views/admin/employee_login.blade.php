<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Nhập Quản Trị</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            background: linear-gradient(to right, #4b6cb7, #182848);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
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
            transform: scale(1.03);
        }
        .form-control:focus {
            border-color: #4b6cb7;
            box-shadow: 0 0 5px rgba(75, 108, 183, 0.8);
        }
    </style>
</head>
<body>
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
            <button type="submit" class="btn btn-primary w-100">Đăng Nhập</button>
        </form>
        <div class="text-center mt-3">
            <a href="#" class="text-decoration-none">Quên mật khẩu?</a>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            @if (session('logout_success'))
                Swal.fire({
                    title: "Chào tạm biệt!",
                    text: "Hẹn gặp lại lần sau!",
                    icon: "success",
                    background: "#2c2c2c",
                    color: "#fff",
                    timer: 5000,
                    showConfirmButton: false,
                    toast: true,
                    position: "top-end"
                });
            @endif

            @if(session('error'))
                Swal.fire({
                    title: "Lỗi đăng nhập!",
                    text: "{{ session('error') }}",
                    icon: "error",
                    background: "#ffebee",
                    color: "#d32f2f",
                    timer: 5000,
                    showConfirmButton: false,
                    toast: true,
                    position: "top-end"
                });
            @endif
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            @if (session('error'))
                Swal.fire({
                    title: "Đăng nhập thất bại!",
                    text: "{{ session('error') }}",
                    icon: "error",
                    confirmButtonColor: "#d33",
                    confirmButtonText: "Thử lại"
                });
            @endif
        });
    </script>
</body>
</html>
