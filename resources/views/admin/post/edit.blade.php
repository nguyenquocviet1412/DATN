@extends('admin.layout')

@section('title', 'Chỉnh sửa Bài Viết | Quản trị Admin')
@section('title2', 'Chỉnh sửa Bài Viết')

@section('content')

<style>
    .alert-danger {
        border-left: 5px solid #dc3545;
        padding: 15px;
        border-radius: 5px;
    }
</style>

{{-- Thông báo thành công --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if(session('success'))
<script>
    Swal.fire({
        title: 'Thành công!',
        text: '{{ session("success") }}',
        icon: 'success',
        showConfirmButton: false,
        timer: 4000,
        backdrop: true
    });
</script>
@endif

{{-- Thông báo lỗi --}}
@if(session('error'))
<script>
    Swal.fire({
        title: 'Lỗi!',
        text: '{{ session("error") }}',
        icon: 'error',
        showConfirmButton: true,
        confirmButtonText: 'Đóng',
        backdrop: true
    });
</script>
@endif

<div class="container mt-4">
    <div class="card shadow p-4 rounded">
        <h2 class="text-center text-primary mb-4">Chỉnh sửa bài viết</h2>

        {{-- Hiển thị lỗi --}}
        @if($errors->any())
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                Swal.fire({
                    title: 'Lỗi!',
                    html: `{!! implode('<br>', $errors->all()) !!}`,
                    icon: 'error',
                    showConfirmButton: true,
                    confirmButtonText: 'Đóng',
                    backdrop: true
                });
            });
        </script>
        @endif

        <form action="{{ route('post.update', $post->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Tiêu đề bài viết --}}
            <div class="mb-3">
                <label class="form-label">Tiêu đề bài viết</label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title', $post->title) }}" required>
                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Nội dung bài viết --}}
            <div class="mb-3">
                <label class="form-label">Nội dung</label>
                <textarea class="form-control @error('content') is-invalid @enderror" name="content" rows="5" required>{{ old('content', $post->content) }}</textarea>
                @error('content')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Ảnh bài viết --}}
            <div class="mb-3">
                <label class="form-label">Ảnh bài viết</label>
                <input type="file" class="form-control @error('image') is-invalid @enderror" name="image" accept="image/*" onchange="previewImage(event)">
                @error('image')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div class="mt-3">
                    <img id="image-preview" src="{{ $post->image ? asset('storage/' . $post->image) : 'https://via.placeholder.com/200' }}" class="img-fluid rounded" style="max-width: 200px;">
                </div>
            </div>

            {{-- Trạng thái bài viết --}}
            <div class="mb-3">
                <label class="form-label">Trạng thái</label>
                <div>
                    <input type="radio" name="status" value="published" {{ old('status', $post->status) == 'published' ? 'checked' : '' }}> Xuất bản
                    <input type="radio" name="status" value="draft" {{ old('status', $post->status) == 'draft' ? 'checked' : '' }}> Nháp
                </div>
                @error('status')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            {{-- Nút hành động --}}
            <div class="d-flex justify-content-between">
                <a href="{{ route('post.index') }}" class="btn btn-secondary">Quay lại</a>
                <button type="submit" class="btn btn-primary">Lưu bài viết</button>
            </div>
        </form>
    </div>
</div>

{{-- Xem trước ảnh trước khi upload --}}
<script>
    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function () {
            var output = document.getElementById('image-preview');
            output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>

@endsection
