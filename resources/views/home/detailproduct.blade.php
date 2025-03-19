@extends('master.main')
@section('title', 'Chi tiết sản phẩm')
@section('main')

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
                <p><strong>Danh mục:</strong> {{ $product->category->name }}</p>
                <p>{{ $product->description }}</p>
                <h4 class="text-danger" id="productPrice">{{ number_format($product->price, 0, ',', '.') }} VNĐ</h4>

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
</script>
@endsection
