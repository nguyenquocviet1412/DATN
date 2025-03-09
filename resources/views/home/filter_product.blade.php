@extends('master.main')

@section('main')
<div class="container mt-4">
    <h2 class="mb-4">Lọc Sản Phẩm</h2>

    <form method="GET" action="{{ route('filter-product') }}" class="mb-4">
        <div class="row">
            <div class="col-md-4">
                <select name="category" class="form-control">
                    <option value="">Chọn danh mục</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <input type="text" name="keyword" class="form-control" placeholder="Tìm kiếm..." value="{{ request('keyword') }}">
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary">Lọc</button>
            </div>
        </div>
    </form>

    <div class="row">
        @foreach($products as $product)
            <div class="col-md-3 mb-4">
                <div class="card">
                    <img src="{{ asset($product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text">Giá: {{ number_format($product->price) }} VNĐ</p>
                        <a href="#" class="btn btn-sm btn-success">Xem chi tiết</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="d-flex justify-content-center">
        {{ $products->links() }}
    </div>
</div>
@endsection
