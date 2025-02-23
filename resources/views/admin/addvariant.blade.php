@extends('admin.layout')
@section('title', 'Thêm Biến Thể Sản Phẩm | Quản trị Admin')
@section('title2', 'Thêm Biến Thể Sản Phẩm')
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

    <div class="card shadow-lg p-4">
        <div class="card-header bg-primary text-white text-center">
            <h4>Thêm Biến Thể Sản Phẩm</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('variant.store', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Màu sắc</label>
                            <select name="id_color" class="form-control">
                                @foreach ($colors as $color)
                                    @php
                                        $exists = $product->variants->where('id_color', $color->id)->pluck('id_size')->toArray();
                                    @endphp
                                    @if (count($exists) < $sizes->count())
                                        <option value="{{ $color->id }}">{{ $color->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Size</label>
                            <select name="id_size" class="form-control">
                                @foreach ($sizes as $size)
                                    @php
                                        $exists = $product->variants->where('id_size', $size->id)->pluck('id_color')->toArray();
                                    @endphp
                                    @if (count($exists) < $colors->count())
                                        <option value="{{ $size->id }}">{{ $size->size }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Giá</label>
                            <input type="number" class="form-control" name="price" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Số lượng</label>
                            <input type="number" class="form-control" name="quantity" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">Ảnh biến thể</label><br>
                        <input type="file" class="form-control mt-2" name="images[]" multiple>
                    </div>
                </div>
                <div class="d-flex justify-content-between">
                    <a href="{{ route('product.edit', $product->id) }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Quay lại sửa sản phẩm
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Thêm biến thể
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
