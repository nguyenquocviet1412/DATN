@extends('master.main')
@section('title', 'Trang chủ')
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
                                        <img src="{{ asset($image->image_url) }}" class="d-block w-100" style="max-height: 400px; object-fit: contain;" alt="Variant Image">
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
                    <!-- Ảnh nhỏ bên dưới -->
                    <div class="d-flex justify-content-center mt-3">
                        @foreach ($product->variants as $variant)
                            @foreach ($variant->images as $image)
                                <img src="{{ asset($image->image_url) }}" class="img-thumbnail mx-1" style="width: 70px; height: 70px; object-fit: contain; cursor: pointer;" onclick="changeMainImage('{{ asset($image->image_url) }}')">
                            @endforeach
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Thông tin sản phẩm -->
            <div class="col-md-6">
                <h1>{{ $product->name }}</h1>
                <p><strong>Category:</strong> {{ $product->category->name }}</p>
                <p>{{ $product->description }}</p>
                <h4 class="text-danger" id="productPrice">${{ number_format($product->price, 2) }}</h4>
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

                {{-- <div class="mb-3 position-relative">
                    <button id="variantButton" class="btn btn-warning btn-lg fw-bold shadow-lg py-3 w-100 dropdown-toggle"
                        type="button" data-bs-toggle="dropdown">
                        🔽 Choose Variant
                    </button>
                    <ul class="dropdown-menu w-100">
                        @foreach ($product->variants as $variant)
                            <li>
                                <a class="dropdown-item fw-bold" href="#" onclick="selectVariant('{{ $variant->id }}', '{{ optional($variant->color)->name }} - Size {{ optional($variant->size)->size }}')">
                                    {{ optional($variant->color)->name }} - Size {{ optional($variant->size)->size }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div> --}}

                <!-- Chọn biến thể sản phẩm -->
                <div class="mb-3">
                    <label for="variantSelect" class="form-label fw-bold">Choose Variant</label>
                    <select id="variantSelect" class="form-select" onchange="updateSelectedVariant()">
                        <option value="" data-price="{{ $product->price }}" data-image="{{ asset(optional($product->variants->first()->images->first())->image_url) }}">
                            Select Size & Color
                        </option>
                        @foreach ($product->variants as $variant)
                            <option value="{{ $variant->id }}"
                                data-price="{{ $variant->price }}"
                                data-image="{{ asset(optional($variant->images->first())->image_url) }}">
                                {{ optional($variant->color)->name }} - Size {{ optional($variant->size)->size }}
                            </option>
                        @endforeach
                    </select>
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
        selectedVariant = id;
    }

    function addToBag() {
        if (!selectedVariant) {
            alert("Please select a variant before adding to the bag.");
            return;
        }
        console.log("Added to bag:", selectedVariant);
        alert(`Added Variant ID: ${selectedVariant} to Bag`);
    }

    function changeMainImage(imageUrl) {
        document.querySelector('#productCarousel .carousel-item.active img').src = imageUrl;
    }



    //Thay đổi giá theo biến thể
    function updateSelectedVariant() {
    let select = document.getElementById('variantSelect');
    let selectedOption = select.options[select.selectedIndex];

    // Lấy giá và ảnh từ option đã chọn
    let newPrice = selectedOption.getAttribute('data-price');
    let newImage = selectedOption.getAttribute('data-image');

    // Cập nhật giá trên giao diện
    document.getElementById('productPrice').innerText = `$${parseFloat(newPrice).toFixed(2)}`;

    // Cập nhật ảnh chính nếu có ảnh mới
    if (newImage) {
        document.querySelector('#productCarousel .carousel-item.active img').src = newImage;
    }

    // Lưu biến thể đã chọn
    selectedVariant = select.value;
}

</script>
@endsection
