
@extends('admin.layout')
@section('title')
Danh sách bình luận | Quản trị Admin
@endsection
@section('title2')
Danh sách bình luận
@endsection
@section('content')

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comments</title>
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"> --}}
    <style>
        body {
            background-color: #f0f2f5;
        }
        .table-responsive {
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 24px;
            margin-top: 20px;
        }
        .navbar {
            margin-bottom: 30px;
            background: linear-gradient(135deg, #007bff, #0056b3);
        }
        .navbar-brand, .nav-link {
            color: #ffffff !important;
        }
        footer {
            margin-top: 40px;
            padding: 24px 0;
            background-color: #343a40;
            color: #ffffff;
        }
        .btn {
            margin-right: 6px;
        }
        h1 {
            font-weight: bold;
            color: #007bff;
        }
    </style>
</head>
<body>
    {{-- thông báo thêm thành công --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if(session('success'))
    <script>
        Swal.fire({
            title: 'Thành công!',
            text: '{{ session("success") }}',
            icon: 'success',
            showConfirmButton: false,
            timer: 4000,
            backdrop: true // Làm tối nền
        });
    </script>
    @endif


    {{-- Thông báo lỗi --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if(session('error'))
    <script>
        Swal.fire({
            title: 'Lỗi!',
            text: '{{ session("error") }}',
            icon: 'error',
            showConfirmButton: true, // Hiển thị nút đóng
            confirmButtonText: 'Đóng', // Nội dung nút đóng
            backdrop: true // Làm tối nền
        });
    </script>
    @endif
    <!-- Main Content -->
    <div class="container">
        <h1 class="mb-4 text-center">Bình luận</h1>
        <div class="table-responsive">
            <table class="table table-hover table-bordered" id="sampleTable">
                <thead class="table-primary">
                    <tr>
                        <th>ID</th>
                        <th>Người bình luận</th>
                        <th>ID bài viết</th>
                        <th>Nội dung</th>
                        <th>Ngày bình luận</th>
                        <th>Ngày Cập nhật</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($comment as $comment)
                    <tr>
                        <td>{{ $comment->id }}</td>
                        <td>{{ $comment->user->fullname }}</td>
                        <td>{{ $comment->id_post }}</td>
                        <td>{{ $comment->is_hidden ? 'Hidden' : $comment->note }}</td>
                        <td>{{ $comment->created_at }}</td>
                        <td>{{ $comment->updated_at }}</td>
                        <td>
                            <form action="{{ route('comment.hide', $comment->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm btn-secondary">
                                    {{ $comment->is_hidden ? 'Hiển thị' : 'Ẩn' }}
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

@endsection
