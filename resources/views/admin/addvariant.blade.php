@extends('admin.layout')
@section('title')
Thêm biến thể sản phẩm | Quản trị Admin
@endsection
@section('title2')
Thêm biến thể sản phẩm
@endsection
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
<form action="{{ route('variant.store', $product->id) }}" method="POST">
    @csrf

    <div class="mb-3">
        <label>Màu sắc</label>
        <select name="id_color" class="form-control">
            @foreach ($colors as $color)
                @php
                    $exists = $product->variants->where('id_color', $color->id)->pluck('id_size')->toArray();
                @endphp
                @if (count($exists) < $sizes->count()) <!-- Chỉ hiển thị nếu còn size chưa được chọn -->
                    <option value="{{ $color->id }}">{{ $color->name }}</option>
                @endif
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label>Size</label>
        <select name="id_size" class="form-control">
            @foreach ($sizes as $size)
                @php
                    $exists = $product->variants->where('id_size', $size->id)->pluck('id_color')->toArray();
                @endphp
                @if (count($exists) < $colors->count()) <!-- Chỉ hiển thị nếu còn màu chưa được chọn -->
                    <option value="{{ $size->id }}">{{ $size->size }}</option>
                @endif
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label>Giá</label>
        <input type="number" class="form-control" name="price" required>
    </div>

    <div class="mb-3">
        <label>Số lượng</label>
        <input type="number" class="form-control" name="quantity" required>
    </div>

    <button type="submit" class="btn btn-primary">Thêm biến thể</button>

@endsection
