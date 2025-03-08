@extends('admin.layout')
@section('title')
    Thêm sản phẩm | Quản trị Admin
@endsection
@section('title2')
    Thêm sản phẩm
@endsection
@section('content')
<div class="card">
    <div class="card-header bg-primary text-white">
        <h3 class="mb-0">Thêm sản phẩm mới</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Tên sản phẩm</label>
                    <input type="text" class="form-control" name="name" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Danh mục</label>
                    <select class="form-select" name="id_category" required>
                        <option value="">-- Chọn danh mục --</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Giá bán</label>
                    <input type="number" class="form-control" name="price" required>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Tình trạng</label>
                    <select class="form-select" name="status">
                        <option value="1">Còn hàng</option>
                        <option value="0">Hết hàng</option>
                    </select>
                </div>
            </div>


            <div class="mb-3">
                <label class="form-label">Mô tả sản phẩm</label>
                <textarea class="form-control" name="description" id="mota"></textarea>
            </div>

            <script>
                CKEDITOR.replace('mota');
            </script>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-success me-2">Lưu lại</button>
                <a href="{{ route('product.index') }}" class="btn btn-secondary">Hủy bỏ</a>
            </div>
<<<<<<< HEAD
=======
            <div class="mb-3">
                <label class="form-label">Danh mục</label>
                <select name="id_category" class="form-select">
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Giá</label>
                <input type="number" name="price" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Trạng thái</label>
                <select name="status" class="form-select">
                    <option value="active">Hoạt động</option>
                    <option value="inactive">Ngừng hoạt động</option>
                </select>
            </div>
            <h4>Biến thể</h4>
            <div id="variant-container" class="mb-3">
                <button type="button" id="add-variant" class="btn btn-secondary">Thêm biến thể</button>
            </div>
            <button type="submit" class="btn btn-success">Lưu</button>
            <a href="{{ route('product.index') }}" class="btn btn-secondary">Quay lại</a>
>>>>>>> ec63204bb6e264bb3e6d3bccdde10ed7c439cbd2
        </form>
    </div>
</div>
@endsection
