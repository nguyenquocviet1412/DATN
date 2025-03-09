@extends('master.main')

@section('main')
<div class="container mt-4">

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
