@extends('master.main')
@section('title', 'Trang chủ')
@section('main')

<link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico">
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap JS (kèm Popper.js) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>\
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- slick Slider JS -->
<script src="assets/js/plugins/slick.min.js"></script>
<!-- Countdown JS -->
<script src="assets/js/plugins/countdown.min.js"></script>
<!-- Nice Select JS -->
<script src="assets/js/plugins/nice-select.min.js"></script>
<!-- jQuery UI JS -->
<script src="assets/js/plugins/jqueryui.min.js"></script>
<!-- Image zoom JS -->
<script src="assets/js/plugins/image-zoom.min.js"></script>
<!-- Images loaded JS -->
<script src="assets/js/plugins/imagesloaded.pkgd.min.js"></script>
<!-- Mailchimp JS -->
<script src="assets/js/plugins/ajaxchimp.js"></script>
<!-- Contact form JS -->
<script src="assets/js/plugins/ajax-mail.js"></script>
<!-- Google Map API -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCfmCVTjRI007pC1Yk2o2d_EhgkjTsFVN8"></script>
<!-- Google Map Active JS -->
<script src="assets/js/plugins/google-map.js"></script>
<!-- Main JS -->
<script src="assets/js/main.js"></script>


<main>
    <div class="container mt-5">
        <div class="row">
            <!-- Hình ảnh sản phẩm chính -->
            <div class="col-md-6">
                <div id="productCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        @foreach ($product->variants as $variant)
                            @foreach ($variant->images as $key => $image)
                                <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                    <img src="{{ asset($image->image_url) }}" class="d-block w-100" alt="Variant Image">
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
            
            <!-- Thông tin sản phẩm -->
            <div class="col-md-6">
                <h1>{{ $product->name }}</h1>
                <p><strong>Category:</strong> {{ $product->category->name }}</p>
                <p>{{ $product->description }}</p>
                <h4 class="text-danger">${{ number_format($product->price, 2) }}</h4>
                <p><strong>Views:</strong> {{ $product->view }}</p>
                <p><strong>Status:</strong> <span class="badge bg-{{ $product->status ? 'success' : 'danger' }}">
                    {{ $product->status ? 'Available' : 'Out of Stock' }}
                </span></p>
                
                <!-- Chọn biến thể -->
                <div class="mb-3">
                    <label for="variantSelect" class="form-label">Choose Variant:</label>
                    <select id="variantSelect" class="form-select">
                        @foreach ($product->variants as $variant)
                            <option value="{{ $variant->id }}">
                                {{ $variant->color->name }} - Size {{ $variant->size->size }} (${{ number_format($variant->price, 2) }})
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Nút thêm vào giỏ hàng -->
                <button class="btn btn-dark w-100">Add to Bag</button>
                <button class="btn btn-outline-secondary w-100 mt-2">Favourite ♥</button>
            </div>
        </div>
    </div>
</main>


@endsection