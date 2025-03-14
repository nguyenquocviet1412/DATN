<!-- filepath: c:\laragon\www\DATN\resources\views\home\detailproduct.blade.php -->
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

                <!-- Hiển thị điểm trung bình đánh giá -->
                <p><strong>Average Rating:</strong> 
                    @for ($i = 1; $i <= 5; $i++)
                        @if ($i <= $averageRating)
                            <i class="fa fa-star text-warning"></i>
                        @elseif ($i - $averageRating < 1)
                            <i class="fa fa-star-half-alt text-warning"></i>
                        @else
                            <i class="fa fa-star text-secondary"></i>
                        @endif
                    @endfor
                </p>

                <div class="mb-3 position-relative">
                    <button id="variantButton" class="btn btn-warning btn-lg fw-bold shadow-lg py-3 w-100 dropdown-toggle" 
                        type="button" data-bs-toggle="dropdown">
                        🔽 Choose Variant
                    </button>
                    <ul class="dropdown-menu w-100">
                        @foreach ($product->variants as $variant)
                            <li>
                                <a class="dropdown-item fw-bold" href="#" onclick="selectVariant('{{ $variant->id }}', '{{ $variant->color->name }} - Size {{ $variant->size->size }}')">
                                    {{ $variant->color->name }} - Size {{ $variant->size->size }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                
                <!-- Nút thêm vào giỏ hàng và yêu thích -->
                <div class="d-grid gap-3">
                    <button class="btn btn-primary btn-lg fw-bold shadow-lg py-3" onclick="addToBag()">🛒 Add to Bag</button>
                    <button class="btn btn-outline-danger btn-lg fw-bold shadow-sm py-3">❤️ Favourite</button>
                </div>
                
                           
            </div>
        </div>
    </div>
</main>

<script>
    let selectedVariant = null;

    function selectVariant(id, text) {
        document.getElementById('variantButton').innerText = text;
        selectedVariant = id; // Lưu ID biến thể đã chọn
    }

    function addToBag() {
        if (!selectedVariant) {
            alert("Please select a variant before adding to the bag.");
            return;
        }
        console.log("Added to bag:", selectedVariant);
        alert(`Added Variant ID: ${selectedVariant} to Bag`);
    }
</script>

@endsection