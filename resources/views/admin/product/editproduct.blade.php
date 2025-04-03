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

<script src="http://code.jquery.com/jquery.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">

<style>
    .variant-images {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }
    .variant-images img {
        width: 80px;
        height: 80px;
        border-radius: 5px;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
    }
</style>

<script>
    $(document).ready(function () {
        $(".Choicefile").click(function () {
            $("#uploadfile").click();
        });
        $(".removeimg").click(function () {
            $("#thumbimage").attr('src', '').hide();
            $("#myfileupload").html('<input type="file" id="uploadfile" name="image" onchange="readURL(this);" />');
            $(".removeimg").hide();
            $(".Choicefile").css({'background': '#14142B', 'cursor': 'pointer'});
        });
    });
</script>

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
            backdrop: true  // Làm tối nền
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
                showConfirmButton: true,  // Hiển thị nút đóng
                confirmButtonText: 'Đóng',  // Nội dung nút đóng
                backdrop: true  // Làm tối nền
            });
        </script>
    @endif

    <script>
        function readURL(input, preview) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $(preview).attr('src', e.target.result).show();
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>

    <script src="https://code.jquery.com/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .variant-images {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }
        .variant-images img {
            width: 80px;
            height: 80px;
            border-radius: 5px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }
    </style>

    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title">Chỉnh sửa sản phẩm</h3>
                <div class="tile-body">
                    <form action="{{ route('products.updateAll', $product->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Tên sản phẩm</label>
                            <input type="text" name="name" class="form-control" value="{{ $product->name }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Danh mục</label>
                            <select name="id_category" class="form-control">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ $product->id_category == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Giá tiền</label>
                            <input type="number" name="price" class="form-control" value="{{ $product->price }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Trạng thái</label>
                            <select name="status" class="form-control">
                                <option value="1" {{ $product->status == 1 ? 'selected' : '' }}>Hoạt động</option>
                                <option value="0" {{ $product->status == 0 ? 'selected' : '' }}>Không hoạt động</option>
                            </select>
                        </div>

                        <h4 class="mt-4">Biến thể sản phẩm</h4>
                        {{-- Sang trang thêm biến thể --}}
                        <a href="{{ route('variant.create', $product->id) }}" class="btn btn-primary">Thêm biến thể</a>

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Màu sắc</th>
                                    <th>Kích thước</th>
                                    <th>Số lượng</th>
                                    <th>Giá tiền</th>
                                    <th>Ảnh biến thể</th>
                                    <th>Thêm ảnh</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($product->variants as $variant)
                                <tr>
                                    <input type="hidden" name="variants[{{ $variant->id }}][id]" value="{{ $variant->id }}">
                                    <td>
                                        <select name="variants[{{ $variant->id }}][id_color]" class="form-control">
                                            @foreach ($colors as $color)
                                                @php
                                                    $existingColors = $product->variants->where('id_size', $variant->id_size)->where('id', '!=', $variant->id)->pluck('id_color')->toArray();
                                                    $isDisabled = in_array($color->id, $existingColors);
                                                @endphp
                                                <option value="{{ $color->id }}" {{ $variant->id_color == $color->id ? 'selected' : '' }} {{ $isDisabled ? 'disabled' : '' }}>
                                                    {{ $color->name }} {{ $isDisabled ? '(Đã tồn tại)' : '' }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <select name="variants[{{ $variant->id }}][id_size]" class="form-control">
                                            @foreach ($sizes as $size)
                                                @php
                                                    $existingSizes = $product->variants->where('id_color', $variant->id_color)->where('id', '!=', $variant->id)->pluck('id_size')->toArray();
                                                    $isDisabled = in_array($size->id, $existingSizes);
                                                @endphp
                                                <option value="{{ $size->id }}" {{ $variant->id_size == $size->id ? 'selected' : '' }} {{ $isDisabled ? 'disabled' : '' }}>
                                                    {{ $size->size }} {{ $isDisabled ? '(Đã tồn tại)' : '' }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" name="variants[{{ $variant->id }}][quantity]" value="{{ $variant->quantity }}" class="form-control">
                                    </td>
                                    <td>
                                        <input type="number" name="variants[{{ $variant->id }}][price]" value="{{ $variant->price }}" class="form-control">
                                    </td>
                                    <td class="variant-images">
                                        @foreach ($variant->images as $image)
                                            <div>
                                                <img src="{{ asset($image->image_url) }}" width="80" height="80">
                                                <input type="checkbox" name="deleted_images[]" value="{{ $image->id }}"> Xóa
                                            </div>
                                        @endforeach
                                    </td>
                                    <td>
                                        <input type="file" name="variant_images[{{ $variant->id }}][]" multiple>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <button type="submit" class="btn btn-primary">Cập nhật tất cả</button>
                        <a href="{{ route('product.index') }}" class="btn btn-secondary">Quay lại</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
