<!-- shop_dashboard.blade.php -->
@extends('master.main')

@section('main')
<!-- responsive css -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
{{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"> --}}
{{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> --}}
<div class="shop-main-wrapper section-padding">
    <div class="container">
        <div class="row d-flex gap-3">
            <!-- Sidebar bộ lọc (Bên trái) -->
            <div class="col-lg-3">
                <aside class="sidebar-wrapper p-3 shadow-sm bg-light">
                    <form method="GET" action="{{ route('shop.index') }}">

                        <!-- Danh mục -->
                        <div class="sidebar-single mb-3">
                            <h5 class="sidebar-title text-start ps-2">Danh mục</h5>
                            <div class="sidebar-body">
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
                        </div>

                        <!-- Màu sắc -->
                        <div class="sidebar-single mb-3">
                            <h5 class="sidebar-title text-start ps-2">Màu sắc</h5>
                            <div class="sidebar-body">
                                <ul class="list-unstyled ps-2">
                                    @foreach ($colors as $color)
                                        <li class="py-1">
                                            <input type="checkbox" name="color_id[]" value="{{ $color->id }}" class="me-1">
                                            {{ $color->name }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                        <!-- Kích thước (Sửa lỗi dropdown và khoảng cách) -->
                        <div class="sidebar-single mb-4 pb-2"> <!-- Thêm mb-4 để tạo khoảng cách -->
                            <h5 class="sidebar-title text-start ps-2">Kích Thước</h5>
                            <div class="sidebar-body">
                                <select name="size_id" class="form-select border-0 ps-2">
                                    <option value="">Chọn kích thước</option>
                                    @foreach ($sizes as $size)
                                        <option value="{{ $size->id }}">{{ $size->size }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Khoảng giá -->
                        <div class="sidebar-single mt-5 mb-3">
                            <h5 class="sidebar-title text-start ps-2">Khoảng giá</h5>
                            <div class="sidebar-body ps-2">
                                <div class="d-flex justify-content-between">
                                    <span>0 VNĐ</span>
                                    <span id="maxPriceLabel">0 VNĐ</span>
                                </div>
                                <input type="range" id="priceRange" min="0" max="10000000" step="100000"
                                value="10000000" class="form-range" oninput="updatePrice()">
                                <input type="hidden" name="max_price" id="maxPriceInput" value="10000000">

                            </div>
                        </div>

                        <script>
                            function updatePrice() {
                                let priceRange = document.getElementById("priceRange");
                                let maxLabel = document.getElementById("maxPriceLabel");
                                let maxInput = document.getElementById("maxPriceInput");

                                let maxValue = parseInt(priceRange.value);

                                // Cập nhật giá trị hiển thị
                                maxLabel.textContent = new Intl.NumberFormat('vi-VN').format(maxValue) + " VNĐ";
                                maxInput.value = maxValue;
                            }

                            // Đảm bảo thanh trượt ở mức tối đa khi load trang
                            document.addEventListener("DOMContentLoaded", function() {
                                document.getElementById("priceRange").value = 10000000;
                                updatePrice();
                            });
                        </script>

                        <!-- Nút lọc -->
                        <button type="submit" class="btn btn-primary w-100">Lọc</button>
                    </form>
                </aside>
            </div>

            <!-- Hiển thị sản phẩm (Bên phải) -->
            <div class="col-lg-8">
                <div class="shop-product-wrapper">
                    <div class="row">
                        @foreach ($products as $product)
                            <div class="col-md-4 col-sm-6 mb-4">
                                <div class="product-item border rounded shadow-sm p-3 position-relative">
                                    <figure class="product-thumb position-relative">
                                        <!-- Hình ảnh sản phẩm -->
                                        <a href="{{ route('product.show', $product->id) }}" class="image-container d-block">
                                            <img src="{{ $product->thumbnail }}" class="img-fluid rounded" alt="{{ $product->name }}">
                                        </a>

                                        <!-- Huy hiệu "Mới" -->
                                        @if($product->is_new)
                                            <div class="product-badge">
                                                <span class="badge bg-danger position-absolute top-0 start-0 m-2">Mới</span>
                                            </div>
                                        @endif

                                        <!-- Nhóm nút thao tác -->
                                        <div class="button-group position-absolute top-0 end-0 m-2">
                                            <!-- Yêu thích -->
                                            <div class="button-group">
                                                <form action="{{ route('favorites.store') }}" method="POST" class="favorite-form">
                                                    @csrf
                                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                    <button type="submit" class="btn btn-add-to-wishlist" data-product-id="{{ $product->id }}" data-bs-toggle="tooltip" data-bs-placement="left" title="Thêm vào danh sách yêu thích">
                                                        <i class="fa fa-heart {{ in_array($product->id, $favoriteProductIds) ? 'text-danger' : '' }}"></i>
                                                    </button>
                                                </form>
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#quick_view">
                                                    <span data-bs-toggle="tooltip" data-bs-placement="left" title="Xem nhanh">
                                                        <i class="pe-7s-search"></i>
                                                    </span>
                                                </a>
                                            </div>
                                        </div>
                                    </figure>

                                    <!-- Thông tin sản phẩm -->
                                    <div class="product-caption text-center mt-3">
                                        <h6 class="product-name">
                                            <a href="{{ route('product.show', $product->id) }}" class="text-dark text-decoration-none">
                                                {{ $product->name }}
                                            </a>
                                        </h6>
                                        <div class="price-box">
                                            <span class="price-regular text-danger fw-bold">
                                                {{ number_format($product->price, 0, ',', '.') }} VND
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Phân trang -->
                    <div class="mt-4 d-flex justify-content-center">
                        {{ $products->links() }}
                    </div>
                </div>

            </div>
        </div>
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
