<!-- shop_dashboard.blade.php -->
@extends('master.main')

@section('main')
<!-- responsive css -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
{{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"> --}}
{{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> --}}
<div class="shop-main-wrapper section-padding">
    <div class="container">
        <div class="row g-4">
            <!-- Sidebar -->
            <div class="col-lg-3">
                <aside class="sidebar-wrapper p-4 shadow-sm bg-light rounded">
                    <form method="GET" action="{{ route('shop.index') }}">

                        <!-- Danh mục -->
                        <div class="sidebar-single mb-4 pb-3 border-bottom">
                            <h5 class="sidebar-title text-start ps-2 fw-bold mb-3">Danh mục</h5>
                            <ul class="list-unstyled ps-2">
                                @foreach ($categories as $category)
                                    <li class="py-1">
                                        <a href="?id_category={{ $category->id }}" class="text-dark text-decoration-none">
                                            {{ $category->name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <!-- Màu sắc -->
                        <div class="sidebar-single mb-4 pb-3 border-bottom">
                            <h5 class="sidebar-title fw-bold mb-3">Màu sắc</h5>
                            @foreach ($colors as $color)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="id_color[]"
                                        value="{{ $color->id }}" id="color_{{ $color->id }}"
                                        {{ request()->has('id_color') && in_array($color->id, (array) request('id_color')) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="color_{{ $color->id }}">
                                        {{ $color->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>

                        <!-- Kích thước -->
                        <div class="mb-5 pb-3 border-bottom">
                            <label for="sizeFilter" class="form-label fw-bold mb-3">Chọn kích thước</label>
                            <select name="id_size" id="sizeFilter" class="form-select">
                                <option value="">Tất cả kích thước</option>
                                @foreach($sizes as $size)
                                    <option value="{{ $size->id }}" {{ request('id_size') == $size->id ? 'selected' : '' }}>
                                        {{ $size->size }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Khoảng giá -->
                        <div class="sidebar-single mt-5 mb-4">
                            <h5 class="sidebar-title fw-bold mb-3">Khoảng giá</h5>
                            <div class="d-flex justify-content-between">
                                <span>0 VNĐ</span>
                                <span id="maxPriceLabel">10.000.000 VNĐ</span>
                            </div>
                            <input type="range" id="priceRange" min="0" max="10000000" step="100000"
                                value="10000000" class="form-range" oninput="updatePrice()">
                            <input type="hidden" name="max_price" id="maxPriceInput" value="10000000">
                        </div>

                        <button type="submit" class="btn btn-primary w-100 fw-bold">Lọc</button>
                    </form>
                </aside>

            </div>

            <!-- Danh sách sản phẩm -->
            <div class="col-lg-9">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold">Danh sách sản phẩm</h5>

                    <!-- Sort By -->
                    <div class="d-flex align-items-center">
                        <label for="sort_by" class="me-2 fw-bold">Sắp xếp:</label>
                        <select id="sort_by" class="form-select w-auto" onchange="sortProducts()">
                            <option value="default" {{ request('sort_by') == 'default' ? 'selected' : '' }}>Mặc định</option>
                            <option value="name_asc" {{ request('sort_by') == 'name_asc' ? 'selected' : '' }}>Tên (A - Z)</option>
                            <option value="name_desc" {{ request('sort_by') == 'name_desc' ? 'selected' : '' }}>Tên (Z - A)</option>
                            <option value="price_asc" {{ request('sort_by') == 'price_asc' ? 'selected' : '' }}>Giá (Thấp - Cao)</option>
                            <option value="price_desc" {{ request('sort_by') == 'price_desc' ? 'selected' : '' }}>Giá (Cao - Thấp)</option>
                        </select>
                    </div>
                </div>

                <div class="row row-cols-1 row-cols-md-3 g-4">
                    @if($products->count() > 0)
                        @foreach($products as $product)
                        <div class="col">
                            <div class="card h-100 shadow-sm border-0">
                                <div class="position-relative">
                                    <!-- Ảnh sản phẩm -->
                                    <a href="{{route('product.show',$product->id)}}">
                                        <img src="{{ $product->getThumbnailAttribute() }}" alt="{{ $product->name }}"style="height: 250px; object-fit: cover;">
                                    </a>
                                    <!-- Nút Thả Tym  -->
                                </div>

                                <div class="card-body text-center">
                                    <!-- Tên sản phẩm -->
                                    <h5 class="card-title fw-bold">
                                        <a href="{{ route('product.show', $product->id) }}" class="text-dark text-decoration-none">{{ $product->name }}</a>
                                        <div class="favorite">
                                            <form action="{{ route('favorites.store') }}" method="POST" class="favorite-form">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                <button type="submit" class="btn btn-add-to-wishlist" data-product-id="{{ $product->id }}" data-bs-toggle="tooltip" data-bs-placement="left" title="Thêm vào danh sách yêu thích">
                                                    <i class="fa fa-heart {{ in_array($product->id, $favoriteProductIds) ? 'text-danger' : '' }}"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </h5>

                                    <!-- Giá tiền -->
                                    <p class="text-danger fw-bold fs-5">{{ number_format($product->price, 0, ',', '.') }}₫</p>

                                  <!-- Đánh giá -->
                                <!-- filepath: c:\laragon\www\DATN\resources\views\home\shop.blade.php -->
                        <!-- Đánh giá -->
                        <p class="mb-0">
                            @for ($i = 1; $i <= 5; $i++)
                                <i class="fa fa-star{{ $i <= $product->average_rating ? ' text-warning' : '-o' }}"></i>
                            @endfor
                            ({{ number_format($product->average_rating, 1) }} / 5)
                        </p>
                                </div>
                            </div>
                        </div>

                        @endforeach
                    @else
                        <div class="col-12 text-center">
                            <p class="alert alert-warning">Không tìm thấy sản phẩm phù hợp với bộ lọc.</p>
                        </div>
                    @endif
                    <style>
                        .product-image {
                            width: 100px;  /* Điều chỉnh kích thước ảnh theo ý muốn */
                            height: 100px;
                            object-fit: cover; /* Giữ tỷ lệ ảnh mà không bị méo */
                            border-radius: 8px; /* Làm bo góc ảnh nếu cần */
                        }
                        .group-product-name {
                            display: flex;
                            align-items: center;
                            justify-content: flex-start; /* Căn về bên trái cùng với text */
                            gap: 5px; /* Giữ khoảng cách giữa tên sản phẩm và icon */
                            white-space: nowrap; /* Tránh xuống dòng */
                        }

                        .favorite-form {
                            margin-left: 5px; /* Dịch icon tim ra xa một chút */
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
                            color: #aaa; /* Màu xám mặc định */
                        }

                        .favorite-form .fa-heart.text-danger {
                            color: red; /* Khi đã yêu thích */
                        }
                    </style>
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
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
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
@endsection
