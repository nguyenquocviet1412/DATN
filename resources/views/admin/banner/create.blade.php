@extends('admin.layout')
@section('title2', 'Tạo Banner')
@section('content')
<div class="container">
    <h2>Thêm Banner Mới</h2>
    <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Tiêu đề</label>
            <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
            @error('title')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Ảnh Banner</label>
            <input type="file" name="image" class="form-control" accept="image/*" required>
            @error('image')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Mô tả</label>
            <textarea name="description" class="form-control">{{ old('description') }}</textarea>
            @error('description')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="type" class="form-label">Loại Banner</label>
            <select name="type" class="form-control">
                <option value="slider" {{ old('type') == 'slider' ? 'selected' : '' }}>Slider</option>
                <option value="advertisement" {{ old('type') == 'advertisement' ? 'selected' : '' }}>Quảng cáo</option>
                <option value="middle" {{ old('type') == 'middle' ? 'selected' : '' }}>Banner giữa</option>
                <option value="bottom" {{ old('type') == 'bottom' ? 'selected' : '' }}>Banner dưới</option>
            </select>
            @error('type')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Trạng thái</label>
            <select name="status" class="form-control">
                <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Hoạt động</option>
                <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Ẩn</option>
            </select>
            @error('status')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Lưu</button>
        <a href="{{ route('admin.banners.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
@endsection
