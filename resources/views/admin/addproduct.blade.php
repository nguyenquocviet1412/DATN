@extends('admin.layout')
@section('title')
    Thêm sản phẩm | Quản trị Admin
@endsection
@section('title2')
    Thêm sản phẩm
@endsection
@section('content')
    <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <h3 class="tile-title">Tạo mới sản phẩm</h3>
                    <div class="tile-body">
                        <div class="row">


                            <div class="form-group col-md-3">
                                <label class="control-label">Tên sản phẩm</label>
                                <input class="form-control" type="text" name="name" required>
                            </div>

                            <div class="form-group col-md-3">
                                <label class="control-label">Giá bán</label>
                                <input class="form-control" type="number" name="price" required>
                            </div>

                            <div class="form-group col-md-3">
                                <label class="control-label">Số lượng</label>
                                <input class="form-control" type="number" name="quantity" required>
                            </div>

                            <div class="form-group col-md-3">
                                <label class="control-label">Tình trạng</label>
                                <select class="form-control" name="status">
                                    <option value="1">Còn hàng</option>
                                    <option value="0">Hết hàng</option>
                                </select>
                            </div>

                            <div class="form-group col-md-3">
                                <label class="control-label">Danh mục</label>
                                <select class="form-control" name="id_category" required>
                                    <option value="">-- Chọn danh mục --</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-12">
                                <label class="control-label">Ảnh sản phẩm</label>
                                <input type="file" name="images[]" multiple accept="image/*">
                            </div>

                            <div class="form-group col-md-12">
                                <label class="control-label">Mô tả sản phẩm</label>
                                <textarea class="form-control" name="description" id="mota"></textarea>
                                <script>
                                    CKEDITOR.replace('mota');
                                </script>
                            </div>
                        </div>

                        <button class="btn btn-save" type="submit">Lưu lại</button>
                        <a class="btn btn-cancel" href="{{ route('product.index') }}">Hủy bỏ</a>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
