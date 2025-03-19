@extends('admin.layout')
@section('title', 'Chi tiết bài viết | Quản trị Admin')
@section('title2', 'Chi tiết bài viết')

@section('content')

{{-- thông báo thêm thành công --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if (session('success'))
    <script>
        Swal.fire({
            title: 'Thành công!',
            text: '{{ session('success') }}',
            icon: 'success',
            showConfirmButton: false,
            timer: 4000,
            backdrop: true // Làm tối nền
        });
    </script>
@endif

{{-- Thông báo lỗi --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if (session('error'))
    <script>
        Swal.fire({
            title: 'Lỗi!',
            text: '{{ session('error') }}',
            icon: 'error',
            showConfirmButton: true, // Hiển thị nút đóng
            confirmButtonText: 'Đóng', // Nội dung nút đóng
            backdrop: true // Làm tối nền
        });
    </script>
@endif
<div class="container mt-4">
    <div class="card shadow-lg p-4 rounded">
        <h2 class="text-center text-primary mb-4">Chi Tiết Bài Viết</h2>

        <div class="row">
            <div class="col-md-6">
                <p><strong>Người đăng:</strong>
                    @if (isset($post->employee->username))
                        {{ $post->employee->username }}
                    @else
                        <span class="text-muted">Không xác định</span>
                    @endif
                </p>
                <p><strong>Tiêu đề:</strong> {{ $post->title }}</p>
                <p><strong>Nội dung:</strong> {{ $post->content }}</p>
                <p><strong>Ngày tạo:</strong> {{ $post->created_at->format('d/m/Y H:i') }}</p>
                <p><strong>Trạng thái:</strong>
                    <span class="badge bg-{{ $post->status == 'published' ? 'success' : 'danger' }}">
                        {{ $post->status == 'published' ? 'Công khai' : 'Nháp' }}
                    </span>
                </p>
            </div>
            <div class="col-md-6 text-center">
                <p><strong>Hình ảnh:</strong></p>
                @if($post->image)
                    <img src="{{ asset('storage/' . $post->image) }}" class="img-fluid rounded" alt="Hình ảnh bài viết" style="max-width: 100%; height: auto;">
                @else
                    <p class="text-muted">Không có hình ảnh</p>
                @endif
            </div>
        </div>

        <div class="text-center mt-3">
            <a href="{{ route('post.index') }}" class="btn btn-secondary">Quay lại danh sách</a>
        </div>
    </div>
</div>
@endsection