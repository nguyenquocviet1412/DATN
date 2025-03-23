@extends('master.main')
@section('title', 'Trang chủ')
@section('main')

    <main>
        <!-- breadcrumb area start -->
        <div class="breadcrumb-area">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="breadcrumb-wrap">
                            <nav aria-label="breadcrumb">
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.html"><i class="fa fa-home"></i></a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Blog </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- breadcrumb area end -->

        <!-- blog main wrapper start -->
        <div class="blog-main-wrapper section-padding">
            <div class="container">
                <div class="row">

                    <div class="blog-item-wrapper">
                        <!-- blog item wrapper end -->
                        <div class="row mbn-30">
                            <!-- blog post item start -->
                            @foreach ($posts as $post)
                                <div class="col-md-6">
                                    <div class="blog-post-item mb-3">
                                        <figure class="blog-thumb">
                                            <a href="{{ route('blogs.details', $post->id) }}">
                                                @if ($post->image)
                                                    {{-- @dd(("storage/app/public/' . $post->image")) --}}
                                                    <img src="{{ asset('storage/app/public/' . $post->image) }}"
                                                        class="img-fluid rounded" alt="Hình ảnh bài viết"
                                                        style="max-width: 100%; height: auto;">
                                                @else
                                                    <p class="text-muted">Không có hình ảnh</p>
                                                @endif
                                            </a>
                                        </figure>
                                        <div class="blog-content">
                                            <div class="blog-meta">
                                                <p>{{ $post->created_at->format('d/m/Y') }} |
                                                    <a href="">
                                                        @if (isset($post->employee->username))
                                                            {{ $post->employee->username }}
                                                        @else
                                                            <span class="text-muted">Không xác định</span>
                                                        @endif
                                                    </a>
                                                </p>
                                            </div>
                                            <h4 class="blog-title">
                                                <a href="{{ route('blogs.details', $post->id) }}">{{ $post->title }}</a>
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <!-- blog post item end -->
                        </div>
                        <!-- blog item wrapper end -->

                        <!-- start pagination area -->
                        <div class="paginatoin-area text-center">
                            {{ $posts->appends(request()->input())->links() }}
                        </div>
                        <!-- end pagination area -->
                    </div>
                </div>
            </div>
        </div>
        </div>
        <!-- blog main wrapper end -->
    </main>


    <!-- Scroll to top start -->
    <div class="scroll-top not-visible">
        <i class="fa fa-angle-up"></i>
    </div>
    <!-- Scroll to Top End -->

    <!-- footer area start -->

    <!-- footer area end -->

    <!-- Quick view modal start -->

    <!-- Quick view modal end -->

    <!-- offcanvas mini cart start -->
    <div class="offcanvas-minicart-wrapper">
        <div class="minicart-inner">
            <div class="offcanvas-overlay"></div>
            <div class="minicart-inner-content">
                <div class="minicart-close">
                    <i class="pe-7s-close"></i>
                </div>
                <div class="minicart-content-box">
                    <div class="minicart-item-wrapper">
                        <ul>
                            <li class="minicart-item">
                                <div class="minicart-thumb">
                                    <a href="product-details.html">
                                        <img src="assets/img/cart/cart-1.jpg" alt="product">
                                    </a>
                                </div>
                                <div class="minicart-content">
                                    <h3 class="product-name">
                                        <a href="product-details.html">Dozen White Botanical Linen Dinner Napkins</a>
                                    </h3>
                                    <p>
                                        <span class="cart-quantity">1 <strong>&times;</strong></span>
                                        <span class="cart-price">$100.00</span>
                                    </p>
                                </div>
                                <button class="minicart-remove"><i class="pe-7s-close"></i></button>
                            </li>
                            <li class="minicart-item">
                                <div class="minicart-thumb">
                                    <a href="product-details.html">
                                        <img src="assets/img/cart/cart-2.jpg" alt="product">
                                    </a>
                                </div>
                                <div class="minicart-content">
                                    <h3 class="product-name">
                                        <a href="product-details.html">Dozen White Botanical Linen Dinner Napkins</a>
                                    </h3>
                                    <p>
                                        <span class="cart-quantity">1 <strong>&times;</strong></span>
                                        <span class="cart-price">$80.00</span>
                                    </p>
                                </div>
                                <button class="minicart-remove"><i class="pe-7s-close"></i></button>
                            </li>
                        </ul>
                    </div>

                    <div class="minicart-pricing-box">
                        <ul>
                            <li>
                                <span>sub-total</span>
                                <span><strong>$300.00</strong></span>
                            </li>
                            <li>
                                <span>Eco Tax (-2.00)</span>
                                <span><strong>$10.00</strong></span>
                            </li>
                            <li>
                                <span>VAT (20%)</span>
                                <span><strong>$60.00</strong></span>
                            </li>
                            <li class="total">
                                <span>total</span>
                                <span><strong>$370.00</strong></span>
                            </li>
                        </ul>
                    </div>

                    <div class="minicart-button">
                        <a href="cart.html"><i class="fa fa-shopping-cart"></i> View Cart</a>
                        <a href="cart.html"><i class="fa fa-share"></i> Checkout</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- offcanvas mini cart end -->

    <!-- JS
                ============================================ -->

    <!-- Modernizer JS -->
    <script src="assets/js/vendor/modernizr-3.6.0.min.js"></script>
    <!-- jQuery JS -->
    <script src="assets/js/vendor/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="assets/js/vendor/bootstrap.bundle.min.js"></script>
    <!-- slick Slider JS -->
    <script src="assets/js/plugins/slick.min.js"></script>
    <!-- Countdown JS -->
    <script src="assets/js/plugins/countdown.min.js"></script>
    <!-- Nice Select JS -->
    <script src="assets/js/plugins/nice-select.min.js"></script>
    <!-- jquery UI JS -->
    <script src="assets/js/plugins/jqueryui.min.js"></script>
    <!-- Image zoom JS -->
    <script src="assets/js/plugins/image-zoom.min.js"></script>
    <!-- Images loaded JS -->
    <script src="assets/js/plugins/imagesloaded.pkgd.min.js"></script>
    <!-- mail-chimp active js -->
    <script src="assets/js/plugins/ajaxchimp.js"></script>
    <!-- contact form dynamic js -->
    <script src="assets/js/plugins/ajax-mail.js"></script>
    <!-- google map api -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCfmCVTjRI007pC1Yk2o2d_EhgkjTsFVN8"></script>
    <!-- google map active js -->
    <script src="assets/js/plugins/google-map.js"></script>
    <!-- Main JS -->
    <script src="assets/js/main.js"></script>
    <style>
        .blog-post-item {
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 30px;
            background-color: #fff;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .blog-thumb img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .blog-content {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .blog-title {
            font-size: 1.25rem;
            margin-top: 10px;
        }

        .blog-meta {
            font-size: 0.875rem;
            color: #888;
        }
    </style>

@endsection
