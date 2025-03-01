@extends('admin.layout')
@section('title', 'Thêm Sản phẩm & Biến Thể | Quản trị Admin')
@section('title2', 'Thêm Sản phẩm & Biến Thể')
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

<div class="card">
    <div class="card-header bg-primary text-white">
        <h3>Thêm sản phẩm</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label class="form-label">Tên sản phẩm</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Mô tả</label>
                <textarea name="description" class="form-control" rows="4" required></textarea>
            </div>
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
        </form>
    </div>
</div>

<script>
    document.getElementById('add-variant').addEventListener('click', function () {
        let container = document.getElementById('variant-container');
        let index = container.querySelectorAll('.variant-item').length;
        let newVariant = `
            <div class="variant-item border p-3 mt-2">
                <div class="row">
                    <div class="col-md-3">
                        <label class="form-label">Màu sắc</label>
                        <select name="variants[${index}][id_color]" class="form-control">
                            @foreach($colors as $color)
                                <option value="{{ $color->id }}">{{ $color->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Size</label>
                        <select name="variants[${index}][id_size]" class="form-control">
                            @foreach($sizes as $size)
                                <option value="{{ $size->id }}">{{ $size->size }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Giá</label>
                        <input type="number" name="variants[${index}][price]" class="form-control" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Số lượng</label>
                        <input type="number" name="variants[${index}][quantity]" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Hình ảnh</label>
                        <input type="file" name="variants[${index}][images][]" class="form-control" multiple>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="button" class="btn btn-danger remove-variant">Xóa</button>
                    </div>
                </div>
            </div>`;
        container.insertAdjacentHTML('beforeend', newVariant);
    });

    document.getElementById('variant-container').addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-variant')) {
            e.target.closest('.variant-item').remove();
        }
    });
</script>
@endsection
