@extends('admin.layout')
@section('title', 'Danh sách sản phẩm | Quản trị Admin')
@section('title2', 'Danh sách sản phẩm')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Danh sách sản phẩm đã bị xóa</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('product.index') }}" class="btn btn-secondary mb-3">← Quay lại danh sách sản phẩm</a>

    @if($trashedProducts->count() > 0)
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>SKU</th>
                    <th>Ảnh</th>
                    <th>Tên sản phẩm</th>
                    
                    <th>Danh mục</th>
                    <th>Giá</th>
                    <th>Ngày xóa</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($trashedProducts as $product)
                    <tr>
                        <td>{{ $product->sku }}</td>

                        <td>
                            @php
                            $variant = $product->variants->first(); // Lấy biến thể đầu tiên nếu có
                            $image = optional($variant?->images->first())->image_url; // Lấy ảnh đầu tiên nếu có
                            $imageSrc = $image ? (filter_var($image, FILTER_VALIDATE_URL) ? $image : asset($image)) : asset('default-image.jpg');
                            @endphp
                            <img src="{{ $imageSrc }}" width="80px" height="80px" class="rounded shadow-sm" alt="Ảnh sản phẩm">

                        </td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->category->name ?? 'Không có' }}</td>
                        <td>{{ number_format($product->price) }} đ</td>
                        <td>{{ $product->deleted_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <form action="{{ route('product.restore', $product->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Khôi phục sản phẩm này?')">Khôi phục</button>
                            </form>

                           
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $trashedProducts->links() }}
    @else
        <p>Không có sản phẩm nào trong thùng rác.</p>
    @endif
</div>
@endsection
