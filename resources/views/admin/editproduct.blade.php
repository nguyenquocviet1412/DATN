@extends('admin.layout')
@section('title', 'Chỉnh sửa sản phẩm | Quản trị Admin')
@section('title2', 'Chỉnh sửa sản phẩm')
@section('content')
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $("#thumbimage").attr('src', e.target.result).show();
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>

    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title">Chỉnh sửa sản phẩm</h3>
                <div class="tile-body">
                    <form class="row" method="POST" action="{{ route('product.update', $product->id) }}"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Tên sản phẩm -->
                        <div class="form-group col-md-6">
                            <label class="control-label">Tên sản phẩm</label>
                            <input class="form-control" type="text" name="name"
                                value="{{ old('name', $product->name) }}">
                        </div>

                        <!-- Giá bán -->
                        <div class="form-group col-md-6">
                            <label class="control-label">Giá bán</label>
                            <input class="form-control" type="number" name="price"
                                value="{{ old('price', $product->price) }}">
                        </div>

                        <!-- Tình trạng -->
                        <div class="form-group col-md-6">
                            <label class="control-label">Tình trạng</label>
                            <select class="form-control" name="status">
                                <option value="1" {{ $product->status == 1 ? 'selected' : '' }}>Còn hàng</option>
                                <option value="0" {{ $product->status == 0 ? 'selected' : '' }}>Hết hàng</option>
                            </select>
                        </div>

                        <!-- Danh mục -->
                        <div class="form-group col-md-6">
                            <label class="control-label">Danh mục</label>
                            <select class="form-control" name="id_category">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ $product->id_category == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Biến thể sản phẩm -->
                        <div class="col-md-12">
                            <h4>Biến thể sản phẩm</h4>
                            @foreach ($product->variants as $index => $variant)
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label class="control-label">Số lượng biến thể {{ $index + 1 }}</label>
                                        <input type="number" class="form-control" name="variant_quantity[]"
                                            value="{{ $variant->quantity }}">
                                        <input type="hidden" name="variant_id[]" value="{{ $variant->id }}">
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label class="control-label">Giá biến thể</label>
                                        <input type="number" class="form-control" name="variant_price[]"
                                            value="{{ $variant->price }}">
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Ảnh sản phẩm -->
                        <div class="form-group col-md-12">
                            <label class="control-label">Ảnh sản phẩm</label>
                            <input type="file" name="image" onchange="readURL(this);">
                            <div id="thumbbox">
                                @if ($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" height="150" id="thumbimage" />
                                @else
                                    <img id="thumbimage" height="150" style="display: none;" />
                                @endif
                            </div>
                        </div>

                        <!-- Mô tả sản phẩm -->
                        <div class="form-group col-md-12">
                            <label class="control-label">Mô tả sản phẩm</label>
                            <textarea class="form-control" name="description">{{ old('description', $product->description) }}</textarea>
                        </div>

                        <!-- Nút hành động -->
                        <button class="btn btn-save" type="submit">Cập nhật</button>
                        <a class="btn btn-cancel" href="{{ route('product.index') }}">Hủy bỏ</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
