<!-- shop_dashboard.blade.php -->
@extends('master.main')

@section('main')
    <!-- breadcrumb area start -->
    <div class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb-wrap">
                        <nav aria-label="breadcrumb">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home.index') }}"><i class="fa fa-home"></i></a>
                                </li>
                                <li class="breadcrumb-item active"><a href="{{ route('shop.index') }}">shop</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb area end -->
    <!-- responsive css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <div class="shop-main-wrapper section-padding">

        <div class="container">
            <div class="row g-4">
                <!-- Sidebar -->
                <div class="col-lg-3">
                    <aside class="sidebar-wrapper p-4 shadow-sm bg-white rounded border">
                        <form method="GET" action="{{ route('shop.index') }}">

                            <!-- Danh mục -->
                            <div class="sidebar-single mb-4 pb-3 border-bottom">
                                <h5 class="sidebar-title text-start ps-2 fw-bold mb-3 text-warning">Danh mục</h5>
                                <ul class="list-unstyled ps-2">
                                    @foreach ($categories as $category)
                                        <li class="py-1">
                                            <a href="?id_category={{ $category->id }}"
                                                class="text-dark text-decoration-none fw-semibold">
                                                {{ $category->name }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>

                            <!-- Màu sắc -->
                            <div class="sidebar-single mb-4 pb-3 border-bottom">
                                <h5 class="sidebar-title fw-bold mb-3 text-warning">Màu sắc</h5>
                                @foreach ($colors as $color)
                                    <div class="form-check">
                                        <input class="form-check-input border-warning" type="checkbox" name="id_color[]"
                                            value="{{ $color->id }}" id="color_{{ $color->id }}"
                                            {{ request()->has('id_color') && in_array($color->id, (array) request('id_color')) ? 'checked' : '' }}>
                                        <label class="form-check-label text-dark fw-semibold"
                                            for="color_{{ $color->id }}">
                                            {{ $color->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Kích thước -->
                            <div class="sidebar-single mb-4 pb-3 border-bottom">
                                <h5 class="sidebar-title fw-bold mb-3 text-warning">Kích thước</h5>
                                @foreach ($sizes as $size)
                                    <div class="form-check">
                                        <input class="form-check-input border-warning" type="checkbox" name="id_size[]"
                                            value="{{ $size->id }}" id="size_{{ $size->id }}"
                                            {{ request()->has('id_size') && in_array($size->id, (array) request('id_size')) ? 'checked' : '' }}>
                                        <label class="form-check-label text-dark fw-semibold"
                                            for="size_{{ $size->id }}">
                                            {{ $size->size }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Khoảng giá -->
                            <div class="sidebar-single mt-5 mb-4">
                                <h5 class="sidebar-title fw-bold mb-3 text-warning">Khoảng giá</h5>
                                <div class="d-flex justify-content-between">
                                    <span class="text-dark fw-semibold">0 VNĐ</span>
                                    <span id="maxPriceLabel" class="text-dark fw-semibold">10.000.000 VNĐ</span>
                                </div>
                                <input type="range" id="priceRange" min="0" max="10000000" step="100000"
                                    value="10000000" class="form-range border-warning" oninput="updatePrice()">
                                <input type="hidden" name="max_price" id="maxPriceInput" value="10000000">
                            </div>

                            <button type="submit" class="btn btn-dark w-100 fw-bold text-warning">Lọc</button>
                        </form>
                    </aside>
                </div>

                <!-- Danh sách sản phẩm -->
                <div class="col-lg-9">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold text-warning">Danh sách sản phẩm</h5>

                        <!-- Sort By -->
                        <div>
                            <label for="sort_by" class="me-2 fw-bold text-warning"> Sắp xếp </label><br>
                            <select id="sort_by" class="form-select border-warning" onchange="sortProducts()">
                                <option value="default" {{ request('sort_by') == 'default' ? 'selected' : '' }}>Mặc định
                                </option>
                                <option value="name_asc" {{ request('sort_by') == 'name_asc' ? 'selected' : '' }}>Tên (A -
                                    Z)</option>
                                <option value="name_desc" {{ request('sort_by') == 'name_desc' ? 'selected' : '' }}>Tên (Z
                                    - A)</option>
                                <option value="price_asc" {{ request('sort_by') == 'price_asc' ? 'selected' : '' }}>Giá
                                    (Thấp - Cao)</option>
                                <option value="price_desc" {{ request('sort_by') == 'price_desc' ? 'selected' : '' }}>Giá
                                    (Cao - Thấp)</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3 p-3 bg-light rounded shadow-sm">
                        <h6 class="fw-bold">Bộ lọc đang áp dụng:</h6>
                        <ul class="list-inline mb-0">
                            @if (request()->has('search'))
                                <li class="list-inline-item badge bg-primary p-2">Từ khóa: "{{ request('search') }}"</li>
                            @endif

                            @if (request()->has('id_category'))
                                @php
                                    $selectedCategory = $categories->where('id', request('id_category'))->first();
                                @endphp
                                @if ($selectedCategory)
                                    <li class="list-inline-item badge bg-success p-2">Danh mục:
                                        {{ $selectedCategory->name }}</li>
                                @endif
                            @endif

                            @if (request()->has('id_color'))
                                @php
                                    $selectedColors = $colors->whereIn('id', request('id_color'));
                                @endphp
                                @foreach ($selectedColors as $color)
                                    <li class="list-inline-item badge bg-danger p-2">Màu: {{ $color->name }}</li>
                                @endforeach
                            @endif

                            @if (request()->has('id_size'))
                                @php
                                    $selectedSizes = $sizes->whereIn('id', request('id_size'));
                                @endphp
                                @foreach ($selectedSizes as $size)
                                    <li class="list-inline-item badge bg-warning p-2">Size: {{ $size->size }}</li>
                                @endforeach
                            @endif

                            @if (request()->has('max_price'))
                                <li class="list-inline-item badge bg-info p-2">Giá tối đa:
                                    {{ number_format(request('max_price'), 0, ',', '.') }}₫</li>
                            @endif
                        </ul>
                    </div>

                    <div class="row row-cols-1 row-cols-md-3 g-4">
                        @if ($products->count() > 0)
                            @foreach ($products as $product)
                                <div class="col">
                                    <div class="card h-100 shadow-sm border-0">
                                        <div class="position-relative">
                                            <!-- Ảnh sản phẩm -->
                                            <a href="{{ route('product.show', $product->id) }}">
                                                <img src="{{ $product->getThumbnailAttribute() ?? asset('images/default-product.jpg') }}"
                                                    alt="{{ $product->name }}" class="product-image">
                                            </a>
                                        </div>

                                        <div class="card-body text-center">
                                            <h5 class="card-title fw-bold">
                                                <a href="{{ route('product.show', $product->id) }}" class="text-dark text-decoration-none">
                                                    {{ $product->name }}
                                                </a>
                                            </h5>

                                            <p class="text-danger fw-bold fs-5">
                                                {{ number_format($product->price, 0, ',', '.') }}₫
                                            </p>

                                            <p class="mb-0">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <i class="fa fa-star{{ $i <= $product->average_rating ? ' text-warning' : '-o' }}"></i>
                                                @endfor
                                                ({{ number_format($product->average_rating, 1) }} / 5)
                                            </p>

                                            <!-- Nút Xem chi tiết -->
                                            <a href="{{ route('product.show', $product->id) }}" class="view-details-btn">Xem chi tiết</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="col-12 text-center">
                                <p class="alert alert-warning">Không tìm thấy sản phẩm phù hợp với bộ lọc.</p>
                            </div>
                        @endif
                    </div>

                    <!-- Phân trang -->
                    <div class="mt-4 d-flex justify-content-center">
                        {{ $products->links() }}
                    </div>
                </div>

            </div>

            <script>
                function updatePrice() {
                    let priceRange = document.getElementById("priceRange");
                    let maxLabel = document.getElementById("maxPriceLabel");
                    let maxInput = document.getElementById("maxPriceInput");
                    let maxValue = parseInt(priceRange.value);

                    maxLabel.textContent = new Intl.NumberFormat('vi-VN').format(maxValue) + " VNĐ";
                    maxInput.value = maxValue;
                }

                document.addEventListener("DOMContentLoaded", function() {
                    document.getElementById("priceRange").value = 10000000;
                    updatePrice();
                });

                function sortProducts() {
                    let sort_by = document.getElementById("sort_by").value;
                    let url = new URL(window.location.href);
                    url.searchParams.set("sort_by", sort_by);
                    window.location.href = url.toString();
                }
            </script>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Lắng nghe sự kiện submit của các form yêu thích
            document.querySelectorAll('.favorite-form').forEach(form => {
                form.addEventListener('submit', function(event) {
                    event.preventDefault(); // Ngăn chặn hành vi submit mặc định

                    let formData = new FormData(this);
                    let productId = formData.get('product_id');
                    let heartIcon = this.querySelector('.fa-heart');

                    fetch(this.action, {
                            method: this.method,
                            body: formData,
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector(
                                    'meta[name="csrf-token"]').getAttribute('content')
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Thay đổi màu của biểu tượng trái tim
                                heartIcon.classList.toggle('text-danger');
                                // Hiển thị thông báo
                                showToast(data.message, data.added ? 'success' : 'error');
                            } else {
                                alert('Có lỗi xảy ra, vui lòng thử lại.');
                            }
                        })
                        .catch(error => console.error('Error:', error));
                });
            });

            function showToast(message, type) {
                let toastContainer = document.querySelector('.toast-container');
                let toastEl = document.createElement('div');
                toastEl.className = `toast align-items-center text-bg-${type} border-0`;
                toastEl.role = 'alert';
                toastEl.ariaLive = 'assertive';
                toastEl.ariaAtomic = 'true';
                toastEl.innerHTML = `
                <div class="d-flex">
                    <div class="toast-body">
                        ${message}
                    </div>
                    <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            `;
                toastContainer.appendChild(toastEl);
                let toast = new bootstrap.Toast(toastEl);
                toast.show();
            }
        });
    </script>
    <style>
        /* Sản phẩm và nút tìm kiếm */
            /* Đảm bảo hình ảnh luôn có khung cố định */
        .product-image {
            width: 100%;
            height: 250px;
            object-fit: cover;
            background-color: #f8f8f8; /* Màu nền xám nhạt nếu không có ảnh */
            border-radius: 8px;
            display: block;
        }

        .group-product-name {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            gap: 5px;
            white-space: nowrap;
        }

        .favorite-form {
            margin-left: 5px;
        }

        .favorite-form button {
            border: none;
            background: none;
            padding: 0;
            font-size: 18px;
            cursor: pointer;
            transition: color 0.3s ease-in-out;
        }

        .favorite-form .fa-heart {
            color: #ccc;
        }

        .favorite-form .fa-heart.text-danger {
            color: #ffcc00;
        }

        .text-danger {
            color: #ffcc00 !important;
        }

        .card {
            overflow: hidden;
            transition: transform 0.3s ease-in-out;
            position: relative;
            border: 1px solid #000;
            /* Viền đen tinh tế */
            background-color: #fff;
            /* Màu nền trắng */
        }

        .card:hover {
            transform: scale(1.05);
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.2);
        }

        /* Nút Xem chi tiết */
        .view-details-btn {
            position: absolute;
            bottom: -60px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #ffcc00;
            /* Màu vàng nổi bật */
            color: #000;
            /* Chữ đen */
            font-weight: bold;
            font-size: 16px;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            opacity: 0;
            transition: bottom 0.3s ease-in-out, opacity 0.3s ease-in-out;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
        }

        .card:hover .view-details-btn {
            bottom: 15px;
            opacity: 1;
        }

        .view-details-btn:hover {
            background-color: #e6b800;
            color: #fff;
        }

        /* Tùy chỉnh phân trang */
        .pagination {
            display: flex;
            list-style: none;
            padding: 0;
        }

        .pagination li {
            margin: 0 5px;
        }

        .pagination .page-link {
            color: #000;
            /* Màu chữ đen */
            background-color: #fff;
            /* Nền trắng */
            border: 1px solid #000;
            /* Viền đen */
            padding: 8px 15px;
            border-radius: 8px;
            transition: all 0.3s ease-in-out;
        }

        .pagination .page-link:hover {
            background-color: #ffcc00;
            /* Màu vàng nổi bật */
            color: #000;
            /* Chữ đen */
            border-color: #ffcc00;
        }

        .pagination .active .page-link {
            background-color: #ffcc00;
            /* Màu vàng */
            border-color: #ffcc00;
            color: #000;
            font-weight: bold;
        }
    </style>
@endsection
