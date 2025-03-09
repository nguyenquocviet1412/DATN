@extends('master.main')
@section('title', 'Trang chủ')
@section('main')

<main>
    <div class="container mt-5">
        <div class="row">
            <!-- Hình ảnh sản phẩm chính -->
            <div class="col-md-6">
                <div id="productCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        @foreach ($product->variants as $variant)
                            @foreach ($variant->images as $key => $image)
                                <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                    <img src="{{ asset($image->image_url) }}" class="d-block w-100" alt="Variant Image">
                                </div>
                            @endforeach
                        @endforeach
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    </button>
                </div>
            </div>

            <!-- Thông tin sản phẩm -->
            <div class="col-md-6">
                <h1>{{ $product->name }}</h1>
                <p><strong>Category:</strong> {{ $product->category->name }}</p>
                <p>{{ $product->description }}</p>
                <h4 class="text-danger">${{ number_format($product->price, 2) }}</h4>
                <p><strong>Views:</strong> {{ $product->view }}</p>
                <p><strong>Status:</strong> <span class="badge bg-{{ $product->status ? 'success' : 'danger' }}">
                    {{ $product->status ? 'Available' : 'Out of Stock' }}
                </span></p>

                <!-- Chọn biến thể -->
                <div class="mb-3">
                    <label for="variantSelect" class="form-label">Choose Variant:</label>
                    <select id="variantSelect" class="form-select">
                        @foreach ($product->variants as $variant)
                            <option value="{{ $variant->id }}">
                                {{ $variant->color->name }} - Size {{ $variant->size->size }} (${{ number_format($variant->price, 2) }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Nút thêm vào giỏ hàng -->
                <button class="btn btn-dark w-100">Add to Bag</button>
                <button class="btn btn-outline-secondary w-100 mt-2">Favourite ♥</button>
            </div>
        </div>
    </div>
</main>



@endsection
