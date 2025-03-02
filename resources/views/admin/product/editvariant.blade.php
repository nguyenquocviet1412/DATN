@extends('admin.layout')
@section('title', 'Chỉnh sửa biến thể sản phẩm | Quản trị Admin')
@section('title2', 'Chỉnh sửa biến thể sản phẩm')
@section('content')

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


<form action="{{ route('variant.update', $variant->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label for="id_color" class="form-label">Màu sắc</label>
        <select class="form-control" name="id_color" required>
            @foreach ($colors as $color)
                <option value="{{ $color->id }}" {{ $variant->id_color == $color->id ? 'selected' : '' }}>
                    {{ $color->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="id_size" class="form-label">Kích thước</label>
        <select class="form-control" name="id_size" required>
            @foreach ($sizes as $size)
                <option value="{{ $size->id }}" {{ $variant->id_size == $size->id ? 'selected' : '' }}>
                    {{ $size->size }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="price" class="form-label">Giá tiền</label>
        <input type="number" class="form-control" name="price" value="{{ $variant->price }}" required>
    </div>

    <div class="mb-3">
        <label for="quantity" class="form-label">Số lượng</label>
        <input type="number" class="form-control" name="quantity" value="{{ $variant->quantity }}" required>
    </div>

    <div class="mb-3">
        <label for="status" class="form-label">Trạng thái</label>
        <select class="form-control" name="status" required>
            <option value="1" {{ $variant->status ? 'selected' : '' }}>Còn hàng</option>
            <option value="0" {{ !$variant->status ? 'selected' : '' }}>Hết hàng</option>
        </select>
    </div>

    <div class="mb-3">
        <label for="images" class="form-label">Ảnh biến thể</label><br>

        {{-- Hiển thị tất cả ảnh đã có --}}
@if ($variant->images->isNotEmpty())
<div class="d-flex flex-wrap">
    @foreach ($variant->images as $image)
        <div class="position-relative m-1 image-container" data-image-id="{{ $image->id }}">
            <img src="{{ asset($image->image_url) }}" width="80px" height="80px" class="rounded border shadow-sm">

            <!-- Nút xóa ảnh -->
            <button class="btn btn-sm btn-danger p-0 delete-image-btn"
                    style="width: 20px; height: 20px; display: flex; align-items: center; justify-content: center; position: absolute; top: 3px; right: 3px;"
                    data-image-id="{{ $image->id }}">
                <i class="fas fa-trash-alt" style="font-size: 12px;"></i>
            </button>
        </div>
    @endforeach
</div>
@else
<p class="text-muted">Không có ảnh</p>
@endif

{{-- Script AJAX để xóa ảnh --}}
<script>
document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll('.delete-image-btn').forEach(button => {
        button.addEventListener('click', function() {
            let imageId = this.getAttribute('data-image-id');

            if (!confirm('Bạn có chắc chắn muốn xóa ảnh này?')) {
                return;
            }

            fetch(`/admin/variant/variant/image/${imageId}`, {
                method: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Content-Type": "application/json",
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.querySelector(`.image-container[data-image-id='${imageId}']`).remove();
                } else {
                    alert("Xóa ảnh thất bại!");
                }
            })
            .catch(error => console.error("Lỗi:", error));
        });
    });
});
</script>
        {{-- Cho phép chọn nhiều ảnh --}}
        <input type="file" class="form-control mt-2" name="images[]" multiple>
    </div>

    <button type="submit" class="btn btn-primary">Cập nhật</button>
    <a href="{{ route('product.edit', $variant->id_product) }}" class="btn btn-secondary">Hủy</a>
</form>
@endsection
