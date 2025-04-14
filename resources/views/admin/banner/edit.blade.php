@extends('admin.layout')

@section('title2', 'Chỉnh sửa Banner')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if(session('success'))
        <script>
            Swal.fire({
                title: 'Thành công!',
                text: '{{ session("success") }}',
                icon: 'success',
                showConfirmButton: false,
                timer: 4000
            });
        </script>
    @endif
    @if(session('error'))
        <script>
            Swal.fire({
                title: 'Lỗi!',
                text: '{{ session("error") }}',
                icon: 'error',
                confirmButtonText: 'Đóng'
            });
        </script>
    @endif
<div class="container">
    <h2>Chỉnh sửa Banner</h2>

    <form action="{{ route('admin.banners.update', $banner->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Tiêu đề -->
        <div class="mb-3">
            <label for="title" class="form-label">Tiêu đề</label>
            <input type="text" name="title" class="form-control" value="{{ old('title', $banner->title) }}" required>
            @error('title')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Hình ảnh hiện tại -->
        <div class="mb-3">
            <label class="form-label">Ảnh hiện tại</label>
            <div>
                <img src="{{ asset('storage/' . $banner->image) }}" width="150">
            </div>
        </div>

        <!-- Chọn ảnh mới -->
        <div class="mb-3">
            <label for="image" class="form-label">Thay đổi ảnh (nếu có)</label>
            <input type="file" name="image" class="form-control" accept="image/*">
            @error('image')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Mô tả -->
        <div class="mb-3">
            <label for="description" class="form-label">Mô tả</label>
            <textarea name="description" class="form-control">{{  $banner->description }}</textarea>
            @error('description')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Loại Banner -->
        <div class="mb-3">
            <label for="type" class="form-label">Loại Banner</label>
            <select name="type" class="form-control">
                <option value="slider" {{ old('type', $banner->type) == 'slider' ? 'selected' : '' }}>Slider</option>
                <option value="top" {{ old('type', $banner->type) == 'top' ? 'selected' : '' }}>Banner top</option>
                <option value="middle" {{ old('type', $banner->type) == 'middle' ? 'selected' : '' }}>Banner giữa</option>
                <option value="bottom" {{ old('type', $banner->type) == 'bottom' ? 'selected' : '' }}>Banner dưới</option>
            </select>
            @error('type')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Trạng thái -->
        <div class="mb-3">
            <label for="status" class="form-label">Trạng thái</label>
            <select name="status" class="form-control">
                <option value="1" {{ old('status', $banner->status) == 1 ? 'selected' : '' }}>Hiển thị</option>
                <option value="0" {{ old('status', $banner->status) == 0 ? 'selected' : '' }}>Ẩn</option>
            </select>
            @error('status')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Nút lưu -->
        <button type="submit" class="btn btn-primary">Cập nhật</button>
        <a href="{{ route('admin.banners.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
@endsection
