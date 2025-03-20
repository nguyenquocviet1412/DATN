@extends('master.main')

@section('main')
<div class="container mt-4">
    <!-- Danh sách sản phẩm -->
    <div class="row">
        @foreach($products as $product)
        <div class="col-md-3 mb-4">
            <div class="card shadow-sm">
                <img src="{{ $product->thumbnail ?? asset('default-image.jpg') }}"
                     class="card-img-top"
                     alt="{{ $product->name }}"
                     style="height: 180px; object-fit: cover;">

                <div class="card-body">
                    <h5 class="card-title text-primary">{{ $product->name }}</h5>
                    <p class="card-text text-danger fw-bold">{{ number_format($product->price) }} VNĐ</p>
                    <p class="small text-muted">
                        👁️ {{ $product->view ?? 0 }} lượt xem | ❤️ {{ $product->likes ?? 0 }} yêu thích
                    </p>
                    <a href="{{ route('product.show', ['id' => $product->id]) }}"
                       class="btn btn-sm btn-outline-success w-100">
                        Xem chi tiết
                    </a>
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
