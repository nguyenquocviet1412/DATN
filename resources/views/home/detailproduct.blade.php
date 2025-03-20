@extends('master.main')
@section('title', 'Chi tiết sản phẩm')
@section('main')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

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
                <div class="mb-3">
                    <label for="variantSelect" class="form-label fw-bold">Chọn kích thước & màu sắc</label>
                    <select id="variantSelect" class="form-select" onchange="updateSelectedVariant()">
                        <option value="" data-price="{{ $product->price }}">Chọn biến thể</option>
                        @foreach ($product->variants as $variant)
                            <option value="{{ $variant->id }}" data-price="{{ $variant->price }}" data-stock="{{ $variant->quantity }}">
                                {{ optional($variant->color)->name }} - Size {{ optional($variant->size)->size }} (Còn {{ $variant->quantity }} sản phẩm)
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Ô nhập số lượng -->
                <div class="mb-3">
                    <label for="quantityInput" class="form-label fw-bold">Số lượng</label>
                    <div class="input-group">
                        <button class="btn btn-outline-secondary" type="button" onclick="changeQuantity(-1)">-</button>
                        <input type="number" id="quantityInput" class="form-control text-center" value="1" min="1" disabled>
                        <button class="btn btn-outline-secondary" type="button" onclick="changeQuantity(1)">+</button>
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
                <h3>Đánh giá sản phẩm</h3>
                <div class="list-group">
                    @foreach ($product->rates as $rate)
                        <div class="list-group-item">
                            <h5 class="mb-1">{{ $rate->user->name }}</h5>
                            <p class="mb-1">{{ $rate->review }}</p>
                            <small class="text-muted">
                                @for ($i = 0; $i < 5; $i++)
                                    @if ($i < $rate->rating)
                                        <i class="fas fa-star"></i>
                                    @else
                                        <i class="far fa-star"></i>
                                    @endif
                                @endfor
                            </small>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Hiển thị các sản phẩm liên quan -->
        <div class="row mt-5">
            <div class="col-md-12">
                <h3>Sản phẩm liên quan</h3>
                <div class="row">
                    @foreach ($relatedProducts as $relatedProduct)
                        <div class="col-md-3">
                            <div class="card mb-4 shadow-sm">
                                <img src="{{ asset($relatedProduct->image_url) }}" class="card-img-top" alt="{{ $relatedProduct->name }}">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $relatedProduct->name }}</h5>
                                    <p class="card-text">{{ number_format($relatedProduct->price, 0, ',', '.') }} VNĐ</p>
                                    <p class="card-text">Đã bán {{ $relatedProduct->sold_count }}</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="btn-group">
                                            <a href="{{ route('product.show', $relatedProduct->id) }}" class="btn btn-sm btn-outline-secondary">Xem chi tiết</a>
                                        </div>
                                        <small class="text-muted">
                                            @for ($i = 0; $i < 5; $i++)
                                                @if ($i < $relatedProduct->average_rating)
                                                    <i class="fas fa-star"></i>
                                                @else
                                                    <i class="far fa-star"></i>
                                                @endif
                                            @endfor
                                        </small>
                                    </div>
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
    function changeMainImage(imageUrl) {
        document.getElementById('mainImage').src = imageUrl;
    }

    function openFullScreen(imageUrl) {
        window.open(imageUrl, "_blank");
    }

    function addToCart() {
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
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({
                id_variant: selectedVariant,
                quantity: quantity
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === "success") {
                alert(data.message);
                // Cập nhật giao diện nếu cần
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            console.error("Lỗi khi thêm vào giỏ hàng:", error);
            alert("Có lỗi xảy ra, vui lòng thử lại!");
        });
    }
</script>
@endsection