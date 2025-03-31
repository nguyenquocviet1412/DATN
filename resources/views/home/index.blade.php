@extends('master.main')
@section('title', 'Trang chủ')
@section('main')

<style>
    .image-container {
        width: 300px;
        /* Đặt kích thước cố định cho khung */
        height: 300px;
        /* Đặt chiều cao cố định */
        overflow: hidden;
        /* Giữ ảnh trong khung, không để bị thò ra */
        display: flex;
        justify-content: center;
        align-items: center;
        border: 1px solid #ddd;
        /* Viền nhẹ để làm khung */
        border-radius: 10px;
        /* Bo góc */
        background: #f9f9f9;
        /* Màu nền để tránh nền trắng quá trống */
    }

    .main-image {
        width: 100%;
        /* Đảm bảo ảnh lấp đầy khung */
        height: 100%;
        /* Đảm bảo chiều cao phù hợp */
        object-fit: cover;
        /* Giữ tỷ lệ ảnh và cắt phần dư nếu cần */
        border-radius: 10px;
        /* Đảm bảo ảnh không bị méo */
    }
</style>
<main>

    <!-- Bootstrap Toast Container -->
    <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1050;">
        @if(session('success'))
        <div id="toastSuccess" class="toast align-items-center text-bg-success border-0"
            role="alert" aria-live="assertive" aria-atomic="true"
            data-bs-autohide="true" data-bs-delay="3000">
            <div class="d-flex">
                <div class="toast-body">
                    🎉 {{ session('success') }}
                </div>
                <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
        @endif

        @if(session('error'))
        <div id="toastError" class="toast align-items-center text-bg-danger border-0"
            role="alert" aria-live="assertive" aria-atomic="true"
            data-bs-autohide="true" data-bs-delay="3000">
            <div class="d-flex">
                <div class="toast-body">
                    ❌ {{ session('error') }}
                </div>
                <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
        @endif
    </div>
    <!-- hero slider area start -->
    <section class="slider-area">
        <!-- Hiển thị Slider -->
        <div class="hero-slider-active slick-arrow-style slick-arrow-style_hero slick-dot-style">
            @foreach ($sliders as $slider)
                <div class="hero-single-slide hero-overlay">
                    <div class="hero-slider-item bg-img" data-bg="{{ asset($slider->image) }}">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="hero-slider-content">
                                        <h2 class="slide-title">{{$slider->title}}</h2>
                                        <h4 class="slide-desc">{{ $slider->description }}</h4>
                                        <a href="{{ route('shop.index') }}" class="btn btn-hero">Khám phá ngay</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        </div>
    </section>
    <!-- service policy area start -->
    <div class="service-policy section-padding">
        <div class="container">
            <div class="row mtn-30">
                <div class="col-sm-6 col-lg-3">
                    <div class="policy-item">
                        <div class="policy-icon">
                            <i class="pe-7s-plane"></i>
                        </div>
                        <div class="policy-content">
                            <h6>Miễn phí vận chuyển</h6>
                            <p>Miễn phí vận chuyển mọi đơn hàng</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="policy-item">
                        <div class="policy-icon">
                            <i class="pe-7s-help2"></i>
                        </div>
                        <div class="policy-content">
                            <h6>Hỗ trợ 24/7</h6>
                            <p>Hỗ trợ khách hàng 24/7</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="policy-item">
                        <div class="policy-icon">
                            <i class="pe-7s-back"></i>
                        </div>
                        <div class="policy-content">
                            <h6>Hoàn tiền</h6>
                            <p>Hoàn trả miễn phí trong 30 ngày</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="policy-item">
                        <div class="policy-icon">
                            <i class="pe-7s-credit"></i>
                        </div>
                        <div class="policy-content">
                            <h6>Thanh toán an toàn 100%</h6>
                            <p>Chúng tôi đảm bảo thanh toán an toàn</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- service policy area end -->

    <!-- banner statistics area start -->
<div class="banner-statistics-area">
    <div class="container">
        <div class="row row-20 mtn-20">
            @foreach ($advertisements as $ad)
                <div class="col-sm-6">
                    <figure class="banner-statistics mt-20">
                        <a href="{{ route('shop.index') }}"><img src="{{ asset($ad->image) }}" alt="{{ $ad->title }}"></a>
                    </figure>
                </div>
            @endforeach
        </div>
    </div>
</div>

    <!-- product area start -->
    <section class="product-area section-padding">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <!-- section title start -->
                    <div class="section-title text-center">
                        <h2 class="title">Sản phẩm mới nhất</h2>
                        <p class="sub-title">Thêm sản phẩm mới từ cửa hàng của chúng tôi</p>
                    </div>
                    <!-- section title end -->
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="product-container">
                        <!-- product tab content start -->
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="tab1">
                                <div class="product-carousel-4 slick-row-10 slick-arrow-style">
                                    @foreach($latestProducts as $product)
                                    <div class="product-item">
                                        <figure class="product-thumb">
                                            <a href="{{route('product.show',$product->id)}}" class="image-container">
                                                <img class="pri-img main-image" src="{{ $product->thumbnail }}" alt="{{ $product->name }}">
                                                <img class="sec-img main-image" src="{{ $product->thumbnail }}" alt="{{ $product->name }}">
                                            </a>
                                            <div class="product-badge">
                                                <div class="product-label new">
                                                    <span>Mới</span>
                                                </div>
                                            </div>
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
                                            <div class="cart-hover">
                                                <button class="btn btn-cart">Thêm vào giỏ</button>
                                            </div>
                                        </figure>
                                        <div class="product-caption text-center">
                                            <h6 class="product-name">
                                                <a href="{{route('product.show',$product->id)}}">{{ $product->name }}</a>
                                            </h6>
                                            <div class="price-box">
                                                <span class="price-regular">{{ number_format($product->price, 0, ',', '.') }}VND</span>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <!-- product tab content end -->
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- product area end -->

    <!-- product banner statistics area start -->
    <section class="product-banner-statistics">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="product-banner-carousel slick-row-10">
                        <!-- banner single slide start -->
                        <div class="banner-slide-item">
                            <figure class="banner-statistics">
                                <a href="#">
                                    <img src="assets/img/banner/banner-nho-9.png" alt="product banner">
                                </a>
                                <div class="banner-content banner-content_style2">
                                    <h5 class="banner-text3"><a href="#">BRACELATES</a></h5>
                                </div>
                            </figure>
                        </div>
                        <!-- banner single slide start -->
                        <!-- banner single slide start -->
                        <div class="banner-slide-item">
                            <figure class="banner-statistics">
                                <a href="#">
                                    <img src="assets/img/banner/banner-nho-8.png" alt="product banner">
                                </a>
                                <div class="banner-content banner-content_style2">
                                    <h5 class="banner-text3"><a href="#">EARRINGS</a></h5>
                                </div>
                            </figure>
                        </div>
                        <!-- banner single slide start -->
                        <!-- banner single slide start -->
                        <div class="banner-slide-item">
                            <figure class="banner-statistics">
                                <a href="#">
                                    <img src="assets/img/banner/banner-nho-7.png" alt="product banner">
                                </a>
                                <div class="banner-content banner-content_style2">
                                    <h5 class="banner-text3"><a href="#">NECJLACES</a></h5>
                                </div>
                            </figure>
                        </div>
                        <!-- banner single slide start -->
                        <!-- banner single slide start -->
                        <div class="banner-slide-item">
                            <figure class="banner-statistics">
                                <a href="#">
                                    <img src="assets/img/banner/banner-nho-6.png" alt="product banner">
                                </a>
                                <div class="banner-content banner-content_style2">
                                    <h5 class="banner-text3"><a href="#">RINGS</a></h5>
                                </div>
                            </figure>
                        </div>
                        <!-- banner single slide start -->
                        <!-- banner single slide start -->
                        <div class="banner-slide-item">
                            <figure class="banner-statistics">
                                <a href="#">
                                    <img src="assets/img/banner/banner-nho-5.png" alt="product banner">
                                </a>
                                <div class="banner-content banner-content_style2">
                                    <h5 class="banner-text3"><a href="#">PEARLS</a></h5>
                                </div>
                            </figure>
                        </div>
                        <!-- banner single slide start -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- product banner statistics area end -->

    <!-- featured product area start -->
    <section class="product-area section-padding">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <!-- section title start -->
                    <div class="section-title text-center">
                        <h2 class="title">Sản phẩm nổi bật</h2>
                        <p class="sub-title">Những sản phẩm nổi bật từ cửa hàng của chúng tôi</p>
                    </div>
                    <!-- section title end -->
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="product-container">
                        <!-- product tab content start -->
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="tab1">
                                <div class="product-carousel-4 slick-row-10 slick-arrow-style">
                                    @foreach($mostViewedProducts as $product)
                                    <div class="product-item">
                                        <figure class="product-thumb">
                                            <a href="{{route('product.show',$product->id)}}">
                                                <img class="pri-img" src="{{ $product->thumbnail }}" alt="{{ $product->name }}">
                                                <img class="sec-img" src="{{ $product->thumbnail }}" alt="{{ $product->name }}">
                                            </a>
                                            <div class="product-badge">
                                                <div class="product-label new">
                                                    <span>Nổi bật</span>
                                                </div>
                                            </div>
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
                                        </figure>
                                        <div class="product-caption text-center">
                                            <h6 class="product-name">
                                                <a href="{{route('product.show',$product->id)}}">{{ $product->name }}</a>
                                            </h6>
                                            <div class="price-box">
                                                <span class="price-regular">{{ number_format($product->price, 0, ',', '.') }} VND</span>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <!-- product tab content end -->
                    </div>
                </div>
            </div>
        </div>
    </section>



    <!-- featured product area end -->

    <!-- testimonial area start -->
    <section class="testimonial-area section-padding bg-img" data-bg="assets/img/testimonial/testimonials-bg.jpg">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <!-- Tiêu đề -->
                    <div class="section-title text-center">
                        <h2 class="title">Cảm nhận của khách hàng</h2>
                        <p class="sub-title">Họ nói gì về chúng tôi?</p>
                    </div>
                    <!-- Kết thúc tiêu đề -->
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="testimonial-thumb-wrapper">
                        <div class="testimonial-thumb-carousel">
                            @foreach ($reviews as $item)
                                <div class="testimonial-thumb">
                                    <a href="{{route('product.show',$item->product->id)}}">
                                    <img src="{{$item->product->thumbnail}}" alt="{{$item->product->name}}">
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="testimonial-content-wrapper">
                        <div class="testimonial-content-carousel">
                            @foreach ($reviews as $item)
                            <div class="testimonial-content">
                                <p>{{$item->review}}</p>
                                <div class="ratings">
                                    @for ($i = 1; $i <= $item->rating; $i++)
                                    <span><i class="fa fa-star"></i></span>
                                    @endfor
                                </div>
                                <h5 class="testimonial-author">{{$item->user->fullname}}</h5>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- testimonial area end -->

    <!-- group product start -->
    <section class="group-product-area section-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="group-product-banner">
                        <figure class="banner-statistics">
                            <a href="#">
                                <img src="assets/img/banner/banner-vua.jpg" alt="Banner sản phẩm">
                            </a>
                        </figure>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="categories-group-wrapper">
                        <!-- Tiêu đề danh mục -->
                        <div class="section-title-append">
                            <h4>Sản phẩm bán chạy</h4>
                            <div class="slick-append"></div>
                        </div>
                        <!-- Kết thúc tiêu đề danh mục -->

                        <!-- Bắt đầu danh sách sản phẩm bán chạy -->
                        <div class="group-list-item-wrapper">
                            <div class="group-list-carousel">

                                @foreach($bestSellingProducts as $product)
                                <div class="group-slide-item">
                                    <div class="group-item">
                                        <div class="group-item-thumb">
                                            <a href="{{route('product.show',$product->id)}}">
                                                <img src="{{ asset($product->thumbnail ?? 'default-image.jpg') }}" alt="{{ $product->name }}">
                                            </a>
                                        </div>
                                        <div class="group-item-desc">
                                            <h5 class="group-product-name">
                                                <a href="{{route('product.show',$product->id)}}">{{ $product->name }}</a>
                                            </h5>
                                            <div class="price-box">
                                                <span class="price-regular">{{ number_format($product->price, 0, ',', '.') }} VND</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="favorite">
                                        <form action="{{ route('favorites.store') }}" method="POST" class="favorite-form">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <button type="submit" class="btn btn-add-to-wishlist" data-product-id="{{ $product->id }}" data-bs-toggle="tooltip" data-bs-placement="left" title="Thêm vào danh sách yêu thích">
                                                <i class="fa fa-heart {{ in_array($product->id, $favoriteProductIds) ? 'text-danger' : '' }}"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <!-- Kết thúc danh sách sản phẩm -->

                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="categories-group-wrapper">
                        <div class="section-title-append">
                            <h4>Sản phẩm đánh giá cao</h4>
                            <div class="slick-append"></div>
                        </div>
                        <div class="group-list-item-wrapper">
                            <div class="group-list-carousel">
                                @foreach($topRatedProducts as $product)
                                <div class="group-slide-item">
                                    <div class="group-item">
                                        <div class="group-item-thumb">
                                            <a href="{{route('product.show',$product->id)}}">
                                                <img src="{{ $product->getThumbnailAttribute() }}" alt="{{ $product->name }}">
                                            </a>
                                        </div>
                                        <div class="group-item-desc">
                                            <h5 class="group-product-name">
                                                <a href="{{route('product.show',$product->id)}}">{{ $product->name }}</a>
                                            </h5>
                                            <div class="price-box">
                                                <span class="price-regular">{{ number_format($product->price, 0, ',', '.') }}₫</span>
                                            </div>

                                            <div class="favorite">
                                                <form action="{{ route('favorites.store') }}" method="POST" class="favorite-form">
                                                    @csrf
                                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                    <button type="submit" class="btn btn-add-to-wishlist" data-product-id="{{ $product->id }}" data-bs-toggle="tooltip" data-bs-placement="left" title="Thêm vào danh sách yêu thích">
                                                        <i class="fa fa-heart {{ in_array($product->id, $favoriteProductIds) ? 'text-danger' : '' }}"></i>
                                                    </button>
                                                </form>
                                            </div>

                                            <div class="rating">
                                                ⭐ {{ number_format($product->avg_rating, 1) }} / 5
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- group product end -->

    <!-- latest blog area start -->
    <section class="latest-blog-area section-padding pt-0">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title text-center">
                        <h2 class="title">Bài viết mới nhất</h2>
                        <p class="sub-title">Những tin tức và xu hướng giày mới nhất</p>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach($latestPosts as $post)
                <div class="col-md-4">
                    <div class="blog-post-item">
                        <figure class="blog-thumb">
                            <a href="">
                                <img src="{{ $post->image ?? asset('assets/img/blog/default.jpg') }}" alt="{{ $post->title }}" style="width: 100%; height: 200px; object-fit: cover;">
                            </a>
                        </figure>
                        <div class="blog-content">
                            <div class="blog-meta">
                                <p>{{ $post->created_at->format('d/m/Y') }}</p>
                            </div>
                            <h5 class="blog-title">
                                <a href="">{{ $post->title }}</a>
                            </h5>
                            <p class="blog-excerpt">
                                {{ Str::limit($post->content, 100, '...') }}
                            </p>
                            <a href="" class="read-more">Đọc thêm</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- latest blog area end -->

    <!-- brand logo area start -->
    <div class="brand-logo section-padding pt-0">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="brand-logo-carousel slick-row-10 slick-arrow-style">
                        <!-- single brand start -->
                        <div class="brand-item">
                            <a href="#">
                                <img src="assets/img/brand/1.png" alt="">
                            </a>
                        </div>
                        <!-- single brand end -->

                        <!-- single brand start -->
                        <div class="brand-item">
                            <a href="#">
                                <img src="assets/img/brand/2.png" alt="">
                            </a>
                        </div>
                        <!-- single brand end -->

                        <!-- single brand start -->
                        <div class="brand-item">
                            <a href="#">
                                <img src="assets/img/brand/3.png" alt="">
                            </a>
                        </div>
                        <!-- single brand end -->

                        <!-- single brand start -->
                        <div class="brand-item">
                            <a href="#">
                                <img src="assets/img/brand/4.png" alt="">
                            </a>
                        </div>
                        <!-- single brand end -->

                        <!-- single brand start -->
                        <div class="brand-item">
                            <a href="#">
                                <img src="assets/img/brand/5.png" alt="">
                            </a>
                        </div>
                        <!-- single brand end -->

                        <!-- single brand start -->
                        <div class="brand-item">
                            <a href="#">
                                <img src="assets/img/brand/6.png" alt="">
                            </a>
                        </div>
                        <!-- single brand end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- brand logo area end -->
</main>

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
