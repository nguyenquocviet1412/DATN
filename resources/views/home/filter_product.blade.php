@extends('master.main')

@section('main')
<div class="container mt-4">
    <!-- Danh sách sản phẩm -->
    <div class="row">
        @foreach($products as $product)
        <div class="col-md-3 mb-4">
            <div class="card shadow-sm">
                <img src="{{ $product->thumbnail ?? asset('default-image.jpg') }}"
                    class="card-img-top"
                    alt="{{ $product->name }}"
                    style="height: 180px; object-fit: cover;">

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

                <div class="card-body">
                    <h5 class="card-title text-primary">{{ $product->name }}</h5>
                    <p class="card-text text-danger fw-bold">{{ number_format($product->price) }} VNĐ</p>
                    <p class="small text-muted">
                        👁️ {{ $product->view ?? 0 }} lượt xem | ❤️ {{ $product->likes ?? 0 }} yêu thích
                    </p>
                    <a href="{{ route('product.show', ['id' => $product->id]) }}"
                        class="btn btn-sm btn-outline-success w-100">
                        Xem chi tiết
                    </a>
                </div>
            </div>
        </div>
        @endforeach

    </div>

    <div class="d-flex justify-content-center">
        {{ $products->links() }}
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