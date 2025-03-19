@extends('admin.layout')
@section('title', 'Thêm Bài Viết | Quản trị Admin')
@section('title2', 'Thêm Bài Viết')
@section('content')

<form action="{{ route('post.store') }}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title">Tạo mới bài viết</h3>
                <div class="tile-body">

                    {{-- Hiển thị lỗi --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label class="control-label">Tiêu đề</label>
                            <input class="form-control" type="text" name="title" value="{{ old('title') }}" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="control-label">Trạng thái</label>
                            <select class="form-control" name="status" required>
                                <option value="">-- Chọn trạng thái --</option>
                                <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Công khai</option>
                                <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Nháp</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Nội dung</label>
                        <textarea class="form-control" name="content" rows="5" required>{{ old('content') }}</textarea>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Hình ảnh</label>
                        <input class="form-control" type="file" name="image" accept="image/*">
                    </div>
                    <button class="btn btn-save" type="submit">Lưu lại</button>
                    <a class="btn btn-cancel" href="{{ route('post.index') }}">Hủy bỏ</a>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection