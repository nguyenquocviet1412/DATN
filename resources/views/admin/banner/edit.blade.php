@extends('admin.layout')

@section('title2', 'Chỉnh sửa Banner')

@section('content')
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
            <textarea name="description" class="form-control">{{ old('description', $banner->description) }}</textarea>
            @error('description')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Loại Banner -->
        <div class="mb-3">
            <label for="type" class="form-label">Loại Banner</label>
            <select name="type" class="form-control">
                <option value="slider" {{ old('type', $banner->type) == 'slider' ? 'selected' : '' }}>Slider</option>
                <option value="advertisement" {{ old('type', $banner->type) == 'advertisement' ? 'selected' : '' }}>Quảng cáo</option>
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
