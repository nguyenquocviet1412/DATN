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

<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <h3 class="tile-title">Chỉnh sửa sản phẩm</h3>
            <div class="tile-body">
                <form action="{{ route('product.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

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
                        <label class="form-label">Tình trạng</label>
                        <select name="status" class="form-control">
                            <option value="1" {{ $product->status ? 'selected' : '' }}>Còn hàng</option>
                            <option value="0" {{ !$product->status ? 'selected' : '' }}>Hết hàng</option>
                        </select>
                    </div>



                    <button type="submit" class="btn btn-success">Cập nhật</button>

                </form>
                <h4 class="mt-4">Biến thể sản phẩm</h4>
                    <div class="col-sm-6">
                        <a class="btn btn-add btn-sm" href="{{ route('variant.create',$product->id) }}">
                            <i class="fas fa-plus"></i> Tạo mới biến thể
                        </a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Màu sắc</th>
                                    <th>Kích thước</th>
                                    <th>Số lượng</th>
                                    <th>Giá tiền</th>
                                    <th>Ảnh</th>
                                    <th>Chức năng</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($product->variants as $variant)
                                <tr>
                                    <td>{{ $variant->color->name ?? 'Không có' }}</td>
                                    <td>{{ $variant->size->size ?? 'Không có' }}</td>
                                    <td>
                                        <input type="number" name="variant_quantity[{{ $variant->id }}]" value="{{ $variant->quantity }}" class="form-control">
                                    </td>
                                    <td>
                                        <input type="number" name="variant_price[{{ $variant->id }}]" value="{{ $variant->price }}" class="form-control">
                                    </td>
                                    <td>
                                        @if ($variant->images->isNotEmpty())
                                            <div class="d-flex flex-wrap">
                                                @foreach ($variant->images as $image)
                                                    <div class="position-relative m-1" style="display: inline-block;">
                                                        <img src="{{ asset($image->image_url) }}" width="80px" height="80px" class="rounded border shadow-sm">

                                                        <!-- Nút xóa ảnh -->
                                                        <form action="{{ route('variant.image.delete', $image->id) }}" method="POST"
                                                              class="position-absolute" style="top: 3px; right: 3px;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger p-0"
                                                                    style="width: 20px; height: 20px; display: flex; align-items: center; justify-content: center;"
                                                                    onclick="return confirm('Bạn có chắc chắn muốn xóa ảnh này?')">
                                                                <i class="fas fa-trash-alt" style="font-size: 12px;"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <p class="text-muted">Không có ảnh</p>
                                        @endif
                                    </td>
                                    <td>
                                        <form action="{{ route('variant.delete', $variant->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Xóa biến thể này?')">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                        <a href="{{ route('variant.edit', $variant->id) }}" class="btn btn-primary btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <a href="{{ route('product.index') }}" class="btn btn-secondary">Quay lại</a>
            </div>
        </div>
    </div>
</div>
@endsection
