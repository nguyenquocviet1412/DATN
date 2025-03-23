
@extends('master.main')
@section('title', 'Chi tiết sản phẩm')
@section('main')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<style>
    .quantity-box {
        max-width: 180px;
    }
    .quantity-btn {
        width: 40px;
        font-size: 20px;
        transition: all 0.2s ease-in-out;
    }
    .quantity-btn:hover {
        background-color: #007bff;
        color: white;
    }
    #quantityInput {
        max-width: 60px;
        font-size: 18px;
    }
</style>

<main>
    <div class="container mt-5">
        <div class="row">
            <!-- Hình ảnh sản phẩm chính -->
            <div class="col-md-6">
                <div class="position-relative">
                    <div id="productCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner" style="height: 400px; display: flex; align-items: center; background: #f8f9fa;">
                            @foreach ($product->variants as $variant)
                                @foreach ($variant->images as $key => $image)
                                    <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                        <img src="{{ asset($image->image_url) }}" class="d-block w-100" style="max-height: 400px; object-fit: contain;" alt="Ảnh sản phẩm">
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
            </div>

            <!-- Thông tin sản phẩm -->
            <div class="col-md-6">
                <h1>{{ $product->name }}</h1>
                <p><strong>Danh mục:</strong> <span class="badge bg-secondary">{{ $product->category->name ?? 'Không có danh mục' }}</span></p>
                <p>{{ $product->description }}</p>
                <h4 class="text-danger" id="productPrice">{{ number_format($product->price, 0, ',', '.') }} VNĐ</h4>

                <!-- Hiển thị điểm trung bình và số lượng đánh giá -->
                <div class="mb-3">
                    <span class="fw-bold">Điểm trung bình:</span>
                    <span class="text-warning">
                        @for ($i = 0; $i < 5; $i++)
                            @if ($i < $averageRating)
                                <i class="fas fa-star"></i>
                            @else
                                <i class="far fa-star"></i>
                            @endif
                        @endfor
                    </span>
                    <span>({{ $reviewsCount }} đánh giá)</span>
                </div>

                <!-- Chọn biến thể sản phẩm -->
                <label for="variantSelect" class="form-label fw-bold">Chọn kích thước & màu sắc</label>
                <div class="mb-3">
                    <label for=""></label>
                    <select id="variantSelect" class="form-select text-align" onchange="updateSelectedVariant()">
                        <option class="text-align" value="" data-price="{{ $product->price }}"><b class="text-align">Màu - Size</b></option>
                        @foreach ($product->variants as $variant)
                            <option value="{{ $variant->id }}" data-price="{{ $variant->price }}" data-stock="{{ $variant->quantity }}">
                                {{ optional($variant->color)->name }} - Size {{ optional($variant->size)->size }} (Còn {{ $variant->quantity }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Add a new input for custom quantity -->


                <div class="mb-3">
                    <label for="">số lượng</label>
                    <div class="input-group quantity-box">
                        <button class="btn btn-outline-primary quantity-btn" type="button" onclick="changeQuantity(-1)">−</button>
                        <input type="number" id="quantityInput" class="form-control text-center fw-bold" value="1" min="1" disabled>
                        <button class="btn btn-outline-primary quantity-btn" type="button" onclick="changeQuantity(1)">+</button>
                    </div>
                </div>


                <!-- Nút thêm vào giỏ hàng -->
                <div class="d-grid gap-3">
                    <button id="addToCartBtn" class="btn btn-primary btn-lg fw-bold shadow-lg py-3" onclick="addToBag()" disabled>🛒 Thêm vào giỏ hàng</button>
                </div>
            </div>
        </div>

        <!-- Hiển thị các đánh giá -->
        <div class="row mt-5">
            <div class="col-md-12">
                <h3 class="mb-4">Đánh giá sản phẩm</h3>
                <div class="list-group">
                    @foreach ($product->rates as $rate)
                        <div class="list-group-item review-item p-3 rounded shadow-sm mb-3 border">
                            <h5 class="mb-1 fw-bold">{{ $rate->user->fullname }}</h5>
                            <p class="mb-2 text-secondary">{{ $rate->review }}</p>
                            <div class="rating text-warning">
                                @for ($i = 0; $i < 5; $i++)
                                    @if ($i < $rate->rating)
                                        <i class="fas fa-star"></i>
                                    @else
                                        <i class="far fa-star"></i>
                                    @endif
                                @endfor
                            </div>
                            <small class="text-muted">Đánh giá vào ngày: {{ $rate->created_at->format('d/m/Y') }}</small>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

   {{-- // Hiển thị sản phẩm liên quan --}}
    <div class="row mt-5">
    <div class="col-md-12">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3>Sản phẩm liên quan</h3>
            @if(isset($product) && $product->category)
                <a href="{{ route('shop.index', $product->category->id) }}" class="btn btn-primary btn-sm">
                    Xem tất cả
                </a>
            @else
                <p class="text-muted">Không có danh mục liên kết</p>
            @endif
        </div>
        <div class="row g-4">
            @foreach ($relatedProducts as $relatedProduct)
                <div class="col-md-3">
                    <div class="card mb-4 shadow-sm">
                        <div class="overflow-hidden" style="height: 200px;">
                            <a href="{{ route('product.show', $relatedProduct->id) }}">
                                <img src="{{ asset($relatedProduct->image_url) }}"
                                     class="card-img-top"
                                     alt="{{ $relatedProduct->name }}"
                                     style="height: 100%; object-fit: cover;">
                            </a>
                        </div>
                        <div class="card-body text-center">
                            <a href="{{ route('product.show', $relatedProduct->id) }}" class="text-decoration-none text-dark">
                                <h5 class="card-title fw-bold">{{ $relatedProduct->name }}</h5>
                            </a>
                            <p class="card-text text-danger fw-bold">
                                {{ number_format($relatedProduct->price, 0, ',', '.') }} VNĐ
                            </p>
                            <p class="card-text">Đã bán {{ $relatedProduct->sold_count }}</p>

                            <!-- Hiển thị đánh giá sao vàng -->
                            <div class="mb-2">
                                @for ($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star {{ $i <= $relatedProduct->average_rating ? 'text-warning' : 'text-secondary' }}"></i>
                                @endfor
                            </div>

                            <a href="{{ route('product.show', $relatedProduct->id) }}"
                               class="btn btn-sm btn-outline-secondary">
                                Xem chi tiết
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
    </div>
</main>

<script>
    let selectedVariant = null;
    let stockQuantity = 0;

    function updateSelectedVariant() {
        let select = document.getElementById('variantSelect');
        let selectedOption = select.options[select.selectedIndex];

        if (!selectedOption || selectedOption.value === "") {
            selectedVariant = null;
            stockQuantity = 0;
            document.getElementById('quantityInput').disabled = true;
            document.getElementById('addToCartBtn').disabled = true;
            return;
        }

        selectedVariant = select.value;
        stockQuantity = parseInt(selectedOption.getAttribute('data-stock'));
        let newPrice = selectedOption.getAttribute('data-price');

        document.getElementById('productPrice').innerText = `₫${parseFloat(newPrice).toLocaleString('vi-VN')}`;
        document.getElementById('quantityInput').disabled = false;
        document.getElementById('addToCartBtn').disabled = false;
    }

    function changeQuantity(amount) {
        let quantityInput = document.getElementById('quantityInput');
        let newQuantity = parseInt(quantityInput.value) + amount;
        if (newQuantity >= 1 && newQuantity <= stockQuantity) {
            quantityInput.value = newQuantity;
        }
    }

    function addToBag() {
        if (!selectedVariant) {
            alert("Vui lòng chọn biến thể trước khi thêm vào giỏ hàng.");
            return;
        }

        if (!{{ Auth::check() ? 'true' : 'false' }}) {
            alert("Bạn cần đăng nhập để thêm sản phẩm vào giỏ hàng.");
            window.location.href = "{{ route('login') }}";
            return;
        }

        let quantity = document.getElementById('quantityInput').value;

        fetch("{{ route('cart.add') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                id_variant: selectedVariant,
                quantity: quantity
            })
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
        })
        .catch(error => console.error("Lỗi:", error));
    }

    function filterReviews(star) {
        let reviews = document.querySelectorAll('.review-item');
        reviews.forEach(review => {
            if (star === 0 || review.getAttribute('data-rating') == star) {
                review.style.display = 'block';
            } else {
                review.style.display = 'none';
            }
        });
    }
</script>
@endsection
