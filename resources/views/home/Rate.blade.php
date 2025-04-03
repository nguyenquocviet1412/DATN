@extends('master.main')
@section('title', 'Thêm đánh giá')
@section('main')

<!-- Breadcrumb -->
<div class="breadcrumb-area">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb-wrap">
                    <nav aria-label="breadcrumb">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home.index') }}"><i class="fa fa-home"></i></a></li>
                            <li class="breadcrumb-item active">Đánh giá</li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Đánh giá sản phẩm -->
<div class="container mt-5">
    <div class="card review-card">
        <div class="card-header text-center">
            <span class="gradient-text">Đánh Giá Sản Phẩm</span>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-center align-items-center mb-4">
                @php
                    $variant = $product->variants->first();
                    $image = optional($variant?->images->first())->image_url;
                    $imageSrc = $image ? (filter_var($image, FILTER_VALIDATE_URL) ? $image : asset($image)) : asset('default-image.jpg');
                @endphp
                <img src="{{ $imageSrc }}" class="product-img" alt="Ảnh sản phẩm">
                <div class="ms-3 text-center">
                    <h5 class="mb-1">{{ $product->name }}</h5>
                    <p class="text-muted">Mã đơn hàng: <strong>#{{ $orderItem->order->id }}</strong></p>
                </div>
            </div>

            <form action="{{ route('client.rate.store', ['id' => $product->id]) }}" method="POST" id="rateForm">
                @csrf
                <input type="hidden" name="id_product" value="{{ $product->id }}">
                <input type="hidden" name="id_order_item" value="{{ $orderItem->id }}">

                <!-- Phần chọn sao -->
                <div class="mb-3 row">
                    <label for="rating" class="form-label">Chọn đánh giá:</label>
                    <div class="star-rating" id="rating">
                        <select id="ratingSelect" name="rating" class="form-select rating-select" required>
                            <option selected value="5" class="star-option" data-value="5">⭐⭐⭐⭐⭐ - Tuyệt vời</option>
                            <option value="4" class="star-option" data-value="4">⭐⭐⭐⭐ - Tốt</option>
                            <option value="3" class="star-option" data-value="3">⭐⭐⭐ - Bình thường</option>
                            <option value="2" class="star-option" data-value="2">⭐⭐ - Không hài lòng</option>
                            <option value="1" class="star-option" data-value="1">⭐ - Rất tệ</option>
                        </select>
                    </div>
                </div>

                <!-- Phần nhận xét -->
                <div class="mb-3">
                    <label for="review" class="form-label">Nhận xét của bạn:</label>
                    <textarea id="review" name="review" class="form-control review-box" rows="4"></textarea>
                </div>

                <button type="submit" class="btn btn-submit w-100"><span class="btn-text">Gửi Đánh Giá</span></button>
            </form>
        </div>
    </div>
</div>

<script>
    // Đảm bảo cập nhật màu sắc khi chọn sao
    const ratingSelect = document.getElementById('ratingSelect');

    ratingSelect.addEventListener('change', function () {
        const selectedValue = parseInt(ratingSelect.value);
        const options = ratingSelect.querySelectorAll('.star-option');

        options.forEach(option => {
            const optionValue = parseInt(option.getAttribute('data-value'));
            if (optionValue <= selectedValue) {
                option.classList.add('highlight');
            } else {
                option.classList.remove('highlight');
            }
        });
    });
</script>

<style>
    body {
        background-color: #f8f9fa;
    }

    .review-card {
        border: 1px solid #f8f9fa;
        border-radius: 12px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        background: #fff;
    }

    /* Header với hiệu ứng gradient chữ từ đen đến vàng */
    .card-header {
        background: #fff;
        padding: 15px;
        border-top-left-radius: 12px;
        border-top-right-radius: 12px;
        border: 1px solid #f8f9fa;
    }

    .gradient-text {
        font-size: 22px;
        font-weight: bold;
        background: linear-gradient(90deg, #000, #ffdd57);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    /* Ảnh sản phẩm */
    .product-img {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        box-shadow: 0px 2px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease-in-out;
    }

    .product-img:hover {
        transform: scale(1.1);
    }

    /* Đặt tên sản phẩm giữa */
    .text-center {
        text-align: center;
    }

    .rating-select {
        border-radius: 8px;
        border: 1px solid #ddd;
        padding: 1px;
        font-size: 16px;
        background: #fff;
        transition: all 0.3s ease-in-out;
        cursor: pointer;
    }

    .rating-select:hover {
        border-color: #ffc107;
    }

    .highlight {
        background-color: #ffdd57 !important;
        color: #fff;
    }

    .review-box {
        border-radius: 8px;
        border: 1px solid #ddd;
        padding: 12px;
        font-size: 16px;
        background: #fff;
        resize: none;
    }

    /* Nút gửi đánh giá với hiệu ứng gradient */
    .btn-submit {
        background: linear-gradient(135deg, #000, #ffffff);
        padding: 10px;
        border-radius: 8px;
        transition: all 0.3s ease-in-out;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow: hidden;
        font-size: 16px;
        font-weight: bold;
    }

    .btn-text {
        background: linear-gradient(90deg, #000, #ffdd57);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .btn-submit:hover {
        background: linear-gradient(135deg, #ffff5d, #ffffff);
    }
</style>
@endsection
