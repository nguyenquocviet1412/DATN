<!doctype html>
<html class="no-js" lang="en">


<!-- Mirrored from htmldemo.net/corano/corano/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 29 Jun 2024 09:53:03 GMT -->

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>@yield('title')</title>
    <meta name="robots" content="noindex, follow" />
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('assets/img/favicon.ico')}}">

    <!-- CSS
	============================================ -->
    <!-- google fonts -->
    <link href="https://fonts.googleapis.com/css?family=Lato:300,300i,400,400i,700,900" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{asset('assets/css/vendor/bootstrap.min.css')}}">
    <!-- Pe-icon-7-stroke CSS -->
    <link rel="stylesheet" href="{{asset('assets/css/vendor/pe-icon-7-stroke.css')}}">
    <!-- Font-awesome CSS -->
    <link rel="stylesheet" href="{{asset('assets/css/vendor/font-awesome.min.css')}}">
    <!-- Slick slider css -->
    <link rel="stylesheet" href="{{asset('assets/css/plugins/slick.min.css')}}">
    <!-- animate css -->
    <link rel="stylesheet" href="{{asset('assets/css/plugins/animate.css')}}">
    <!-- Nice Select css -->
    <link rel="stylesheet" href="{{asset('assets/css/plugins/nice-select.css')}}">
    <!-- jquery UI css -->
    <link rel="stylesheet" href="{{asset('assets/css/plugins/jqueryui.min.css')}}">
    <!-- main style css -->
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">


</head>

<body>
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

        @if(session('warning'))
    <div class="toast align-items-center text-bg-warning border-0 shadow-lg fade show"
        role="alert" aria-live="assertive" aria-atomic="true"
        data-bs-autohide="true" data-bs-delay="4000">
        <div class="d-flex">
            <div class="toast-body d-flex align-items-center">
                <i class="fa-solid fa-triangle-exclamation text-white me-2 toast-icon pulse"></i>  <!-- Icon cảnh báo động -->
                <span>{{ session('warning') }}</span>
            </div>
            <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
    @endif

    @if(session('message'))
    <div class="toast align-items-center text-bg-info border-0 shadow-lg fade show"
        role="alert" aria-live="assertive" aria-atomic="true"
        data-bs-autohide="true" data-bs-delay="3500">
        <div class="d-flex">
            <div class="toast-body d-flex align-items-center">
                <i class="fa-solid fa-circle-info text-white me-2 toast-icon rotate"></i>  <!-- Icon thông tin động -->
                <span>{{ session('message') }}</span>
            </div>
            <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
    @endif
    </div>

    <!-- JavaScript: Hiển thị Toast -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let toastElements = document.querySelectorAll(".toast");

            toastElements.forEach(toastEl => {
                let toast = new bootstrap.Toast(toastEl);
                toast.show(); // Hiển thị ngay lập tức
            });
        });
    </script>
    <!-- Bootstrap Bundle (đã có Popper.js) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- CSS Animation -->
<style>
    /* Hiệu ứng rung nhẹ khi hiển thị */
    .toast-icon {
        font-size: 1.5rem;
    }
    .shake {
        animation: shake 0.5s ease-in-out infinite alternate;
    }
    .pulse {
        animation: pulse 1s ease-in-out infinite;
    }
    .rotate {
        animation: rotate 1s linear infinite;
    }

    @keyframes shake {
        0% { transform: translateX(-2px); }
        100% { transform: translateX(2px); }
    }

    @keyframes pulse {
        0% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.1); opacity: 0.9; }
        100% { transform: scale(1); opacity: 1; }
    }

    @keyframes rotate {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>

    <!-- Start Header Area -->
    <header class="header-area header-wide">
        <!-- main header start -->
        <div class="main-header d-none d-lg-block">
            <!-- header middle area start -->
            <div class="header-main-area sticky">
                <div class="container">
                    <div class="row align-items-center position-relative">

                        <!-- start logo area -->
                        <div class="col-lg-2">
                            <div class="logo">
                                <a href="{{ route('home.index') }}">
                                    <img src="{{ asset('assets/img/logo/logo.png') }}" alt="Brand Logo">
                                </a>
                            </div>
                        </div>
                        <!-- start logo area -->
                        <!-- main menu area start -->
                        <div class="col-lg-6 position-static">
                            <div class="main-menu-area">
                                <div class="main-menu">
                                    <!-- main menu navbar start -->
                                    <nav class="desktop-menu">
                                        <ul>
                                            <li class=""><a href="{{route('home.index')}}">Trang chủ <i class="fa"></i></a>
                                            </li>
                                            <li>
                                                <a href="">Danh mục <i class="fa"></i></a>
                                                <ul class="dropdown">
                                                    @foreach ($categories as $category)
                                                    <li><a href="{{ route('shop.index', ['category' => $category->id]) }}">{{ $category->name }}</a></li>
                                                    @endforeach
                                                </ul>
                                            </li>
                                            <li><a href="{{route('shop.index')}}">Cửa hàng <i class="fa"></i></a> </li>
                                            <li><a href="{{route('blogs.index')}}">Blog </a> </li>
                                            <li><a href="contact-us.html">Liên hệ</a></li>
                                        </ul>
                                    </nav>
                                    <!-- main menu navbar end -->
                                </div>
                            </div>
                        </div>
                        <!-- main menu area end -->

                        <!-- mini cart area start -->
                        <div class="col-lg-4">
                            <div class="header-right d-flex align-items-center justify-content-xl-between justify-content-lg-end">
                                <div class="header-search-container">
                                    <button class="search-trigger d-xl-none d-lg-block"><i class="pe-7s-search"></i></button>
                                    <form class="header-search-box d-lg-none d-xl-block" method="GET" action="{{ route('shop.index') }}">
                                        <input type="text" name="keyword" placeholder="Tìm kiếm..." value="{{ request('search') }}" class="header-search-field">
                                        <button class="header-search-btn"> <i class="pe-7s-search"></i></button>
                                    </form>
                                </div>
                                <div class="header-configure-area">
                                    <ul class="nav justify-content-end">
                                        <li class="user-hover">
                                            <a href="#"><i class="pe-7s-user"></i></a>
                                            <ul class="dropdown-list">
                                                @if(Auth::guard('web')->check())
                                                {{-- Người dùng (User) đã đăng nhập --}}
                                                <li><a href="{{ route('user.profile')}}">Tài khoản của tôi</a></li>
                                                <li><a href="{{route('user.orders')}}">Đơn hàng</a></li>
                                                <li>
                                                    <a href="{{ route('logout') }}"
                                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                        Đăng xuất
                                                    </a>
                                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                        @csrf
                                                    </form>
                                                </li>
                                                @else
                                                {{-- Chưa đăng nhập --}}
                                                <li><a href="{{ route('login') }}">Đăng nhập</a></li>
                                                <li><a href="{{ route('register') }}">Đăng ký</a></li>
                                                @endif
                                            </ul>
                                        </li>
                                        <li>
                                            <a href="{{route('favorite.index')}}">
                                                <i class="pe-7s-like"></i>
                                                <div class="notification">0</div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" class="minicart-btn">
                                                <i class="pe-7s-shopbag"></i>
                                                <div class="notification">2</div>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- mini cart area end -->

                    </div>
                </div>
            </div>
            <!-- header middle area end -->
        </div>
        <!-- main header start -->

        <!-- mobile header start -->
        <!-- mobile header start -->
        <div class="mobile-header d-lg-none d-md-block sticky">
            <!--mobile header top start -->
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-12">
                        <div class="mobile-main-header">
                            <div class="mobile-logo">
                                <a href="index.html">
                                    <img src="{{asset('assets/img/logo/logo.png" alt="Brand Logo')}}">
                                </a>
                            </div>
                            <div class="mobile-menu-toggler">
                                <div class="mini-cart-wrap">
                                    <a href="cart.html">
                                        <i class="pe-7s-shopbag"></i>
                                        <div class="notification"></div>
                                    </a>
                                </div>
                                <button class="mobile-menu-btn">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- mobile header top start -->
        </div>
        <!-- mobile header end -->
        <!-- mobile header end -->

        <!-- offcanvas mobile menu start -->
        <!-- off-canvas menu start -->
        <aside class="off-canvas-wrapper">
            <div class="off-canvas-overlay"></div>
            <div class="off-canvas-inner-content">
                <div class="btn-close-off-canvas">
                    <i class="pe-7s-close"></i>
                </div>

                <div class="off-canvas-inner">
                    <!-- search box start -->
                    <div class="search-box-offcanvas">
                        <form>
                            <input type="text" placeholder="Search Here...">
                            <button class="search-btn"><i class="pe-7s-search"></i></button>
                        </form>
                    </div>
                    <!-- search box end -->

                    <!-- mobile menu start -->
                    <div class="mobile-navigation">

                        <!-- mobile menu navigation start -->
                        <nav>
                            <ul class="mobile-menu">
                                <li class="menu-item-has-children"><a href="index.html">Home</a>
                                </li>
                                <li class="menu-item-has-children"><a href="#">pages</a>
                                    <ul class="megamenu dropdown">
                                        <li class="mega-title menu-item-has-children"><a href="#">column 01</a>
                                            <ul class="dropdown">
                                                <li><a href="shop.html">shop grid left sidebar</a></li>
                                            </ul>
                                        </li>
                                        <li class="mega-title menu-item-has-children"><a href="#">column 02</a>
                                            <ul class="dropdown">
                                                <li><a href="product-details.html">product details</a></li>

                                            </ul>
                                        </li>
                                        <li class="mega-title menu-item-has-children"><a href="#">column 03</a>
                                            <ul class="dropdown">
                                                <li><a href="cart.html">cart</a></li>

                                            </ul>
                                        </li>
                                        <li class="mega-title menu-item-has-children"><a href="#">column 04</a>
                                            <ul class="dropdown">
                                                <li><a href="my-account.html">my-account</a></li>
                                                <li><a href="login-register.html">login-register</a></li>
                                                <li><a href="about-us.html">about us</a></li>
                                                <li><a href="contact-us.html">contact us</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                                <li class="menu-item-has-children "><a href="#">shop</a>
                                    <ul class="dropdown">
                                        <li class="menu-item-has-children"><a href="#">shop grid layout</a>
                                            <ul class="dropdown">
                                                <li><a href="shop.html">shop grid left sidebar</a></li>
                                                <li><a href="shop-grid-right-sidebar.html">shop grid right sidebar</a></li>
                                                <li><a href="shop-grid-full-3-col.html">shop grid full 3 col</a></li>
                                                <li><a href="shop-grid-full-4-col.html">shop grid full 4 col</a></li>
                                            </ul>
                                        </li>
                                        <li class="menu-item-has-children"><a href="#">shop list layout</a>
                                            <ul class="dropdown">
                                                <li><a href="shop-list-left-sidebar.html">shop list left sidebar</a></li>
                                                <li><a href="shop-list-right-sidebar.html">shop list right sidebar</a></li>
                                                <li><a href="shop-list-full-width.html">shop list full width</a></li>
                                            </ul>
                                        </li>
                                        <li class="menu-item-has-children"><a href="#">products details</a>
                                            <ul class="dropdown">
                                                <li><a href="product-details.html">product details</a></li>
                                                <li><a href="product-details-affiliate.html">product details affiliate</a></li>
                                                <li><a href="product-details-variable.html">product details variable</a></li>
                                                <li><a href="product-details-group.html">product details group</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                                <li class="menu-item-has-children "><a href="#">Blog</a>
                                    <ul class="dropdown">
                                        <li><a href="blog-left-sidebar.html">blog left sidebar</a></li>
                                        <li><a href="blog-list-left-sidebar.html">blog list left sidebar</a></li>
                                        <li><a href="blog-right-sidebar.html">blog right sidebar</a></li>
                                        <li><a href="blog-list-right-sidebar.html">blog list right sidebar</a></li>
                                        <li><a href="blog-grid-full-width.html">blog grid full width</a></li>
                                        <li><a href="blog-details.html">blog details</a></li>
                                        <li><a href="blog-details-left-sidebar.html">blog details left sidebar</a></li>
                                        <li><a href="blog-details-audio.html">blog details audio</a></li>
                                        <li><a href="blog-details-video.html">blog details video</a></li>
                                        <li><a href="blog-details-image.html">blog details image</a></li>
                                    </ul>
                                </li>
                                <li><a href="contact-us.html">Contact us</a></li>
                            </ul>
                        </nav>
                        <!-- mobile menu navigation end -->
                    </div>
                    <!-- mobile menu end -->

                    <div class="mobile-settings">
                        <ul class="nav">
                            <li>
                                <div class="dropdown mobile-top-dropdown">
                                    <a href="#" class="dropdown-toggle" id="currency" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Currency
                                        <i class="fa"></i>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="currency">
                                        <a class="dropdown-item" href="#">$ USD</a>
                                        <a class="dropdown-item" href="#">$ EURO</a>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="dropdown mobile-top-dropdown">
                                    <a href="#" class="dropdown-toggle" id="myaccount" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        My Account
                                        <i class="fa"></i>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="myaccount">
                                        <a class="dropdown-item" href="my-account.html">my account</a>
                                        <a class="dropdown-item" href="login-register.html"> login</a>
                                        <a class="dropdown-item" href="login-register.html">register</a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>

                    <!-- offcanvas widget area start -->
                    <div class="offcanvas-widget-area">
                        <div class="off-canvas-contact-widget">
                            <ul>
                                <li><i class="fa fa-mobile"></i>
                                    <a href="#">0123456789</a>
                                </li>
                                <li><i class="fa fa-envelope-o"></i>
                                    <a href="#">info@yourdomain.com</a>
                                </li>
                            </ul>
                        </div>
                        <div class="off-canvas-social-widget">
                            <a href="#"><i class="fa fa-facebook"></i></a>
                            <a href="#"><i class="fa fa-twitter"></i></a>
                            <a href="#"><i class="fa fa-pinterest-p"></i></a>
                            <a href="#"><i class="fa fa-linkedin"></i></a>
                            <a href="#"><i class="fa fa-youtube-play"></i></a>
                        </div>
                    </div>
                    <!-- offcanvas widget area end -->
                </div>
            </div>
        </aside>

        <!-- off-canvas menu end -->
        <!-- offcanvas mobile menu end -->
    </header>
    <!-- end Header Area -->

    @yield('main')
    <!-- Scroll to top start -->
    <div class="scroll-top not-visible">
        <i class="fa fa-angle-up"></i>
    </div>
    <!-- Scroll to Top End -->

    <!-- footer area start -->
    <footer class="footer-widget-area bg-white text-dark">
        <div class="footer-top section-padding">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="widget-item">
                            <div class="widget-title">
                                <div class="widget-logo">
                                    <a href="index.html">
                                        <img src="{{asset('assets/img/logo/logo.png')}}" alt="logo thương hiệu">
                                    </a>
                                </div>
                            </div>
                            <div class="widget-body">
                                <p>Chúng tôi là một nhóm thiết kế và phát triển tạo ra các sản phẩm chất lượng cao trên WordPress, Shopify, Opencart.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="widget-item">
                            <h6 class="widget-title">Liên hệ với chúng tôi</h6>
                            <div class="widget-body">
                                <address class="contact-block">
                                    <ul>
                                        <li><i class="pe-7s-home"></i> Nam Từ Liêm, Hà Nội</li>
                                        <li><i class="pe-7s-mail"></i> <a href="">Nhom45DATN@gmail.com</a></li>
                                        <li><i class="pe-7s-call"></i> <a href="tel:(012)800456789987">098765432</a></li>
                                    </ul>
                                </address>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="widget-item">
                            <h6 class="widget-title">Thông tin</h6>
                            <div class="widget-body">
                                <ul class="info-list">
                                    <li><a href="#">Về chúng tôi</a></li>
                                    <li><a href="#">Thông tin giao hàng</a></li>
                                    <li><a href="#">Chính sách & bảo mật</a></li>
                                    <li><a href="#">Điều khoản & điều kiện</a></li>
                                    <li><a href="#">Liên hệ</a></li>
                                    <li><a href="#">Sơ đồ trang web</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="widget-item">
                            <h6 class="widget-title">Theo dõi chúng tôi</h6>
                            <div class="widget-body social-link">
                                <a href="#"><i class="fa fa-facebook"></i></a>
                                <a href="#"><i class="fa fa-twitter"></i></a>
                                <a href="#"><i class="fa fa-instagram"></i></a>
                                <a href="#"><i class="fa fa-youtube"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row align-items-center mt-20">
                    <div class="col-md-6">
                        <div class="newsletter-wrapper">
                            <h6 class="widget-title-text">Đăng ký nhận bản tin</h6>
                            <form class="newsletter-inner" id="mc-form">
                                <input type="email" class="news-field" id="mc-email" autocomplete="off" placeholder="Nhập địa chỉ email của bạn">
                                <button class="news-btn" id="mc-submit">Đăng ký</button>
                            </form>
                            <div class="mailchimp-alerts">
                                <div class="mailchimp-submitting"></div>
                                <div class="mailchimp-success"></div>
                                <div class="mailchimp-error"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="footer-payment">
                            <img src="{{ asset('assets/img/payment.png') }}" alt="Phương thức thanh toán">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom bg-light text-dark">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="copyright-text text-center">
                            <p>&copy; 2022 <b>Corano</b> Được tạo với <i class="fa fa-heart text-danger"></i> bởi <a href="https://hasthemes.com/"><b>HasThemes</b></a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- footer area end -->

    <!-- Quick view modal start -->
    <div class="modal" id="quick_view">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <!-- product details inner end -->
                    <div class="product-details-inner">
                        <div class="row">
                            <div class="col-lg-5">
                                <div class="product-large-slider">
                                    <div class="pro-large-img img-zoom">
                                        <img src="{{asset('assets/img/product/product-details-img1.jpg')}}" alt="product-details" />
                                    </div>
                                    <div class="pro-large-img img-zoom">
                                        <img src="{{asset('assets/img/product/product-details-img2.jpg')}}" alt="product-details" />
                                    </div>
                                    <div class="pro-large-img img-zoom">
                                        <img src="{{asset('assets/img/product/product-details-img3.jpg')}}" alt="product-details" />
                                    </div>
                                    <div class="pro-large-img img-zoom">
                                        <img src="{{asset('assets/img/product/product-details-img4.jpg')}}" alt="product-details" />
                                    </div>
                                    <div class="pro-large-img img-zoom">
                                        <img src="{{asset('assets/img/product/product-details-img5.jpg')}}" alt="product-details" />
                                    </div>
                                </div>
                                <div class="pro-nav slick-row-10 slick-arrow-style">
                                    <div class="pro-nav-thumb">
                                        <img src="{{asset('assets/img/product/product-details-img1.jpg')}}" alt="product-details" />
                                    </div>
                                    <div class="pro-nav-thumb">
                                        <img src="{{asset('assets/img/product/product-details-img2.jpg')}}" alt="product-details" />
                                    </div>
                                    <div class="pro-nav-thumb">
                                        <img src="{{asset('assets/img/product/product-details-img3.jpg')}}" alt="product-details" />
                                    </div>
                                    <div class="pro-nav-thumb">
                                        <img src="{{asset('assets/img/product/product-details-img4.jpg')}}" alt="product-details" />
                                    </div>
                                    <div class="pro-nav-thumb">
                                        <img src="{{asset('assets/img/product/product-details-img5.jpg')}}" alt="product-details" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-7">
                                <div class="product-details-des">
                                    <div class="manufacturer-name">
                                        <a href="product-details.html">HasTech</a>
                                    </div>
                                    <h3 class="product-name">Handmade Golden Necklace</h3>
                                    <div class="ratings d-flex">
                                        <span><i class="fa fa-star-o"></i></span>
                                        <span><i class="fa fa-star-o"></i></span>
                                        <span><i class="fa fa-star-o"></i></span>
                                        <span><i class="fa fa-star-o"></i></span>
                                        <span><i class="fa fa-star-o"></i></span>
                                        <div class="pro-review">
                                            <span>1 Reviews</span>
                                        </div>
                                    </div>
                                    <div class="price-box">
                                        <span class="price-regular">$70.00</span>
                                        <span class="price-old"><del>$90.00</del></span>
                                    </div>
                                    <h5 class="offer-text"><strong>Hurry up</strong>! offer ends in:</h5>
                                    <div class="product-countdown" data-countdown="2022/12/20"></div>
                                    <div class="availability">
                                        <i class="fa fa-check-circle"></i>
                                        <span>200 in stock</span>
                                    </div>
                                    <p class="pro-desc">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna.</p>
                                    <div class="quantity-cart-box d-flex align-items-center">
                                        <h6 class="option-title">qty:</h6>
                                        <div class="quantity">
                                            <div class="pro-qty"><input type="text" value="1"></div>
                                        </div>
                                        <div class="action_link">
                                            <a class="btn btn-cart2" href="#">Add to cart</a>
                                        </div>
                                    </div>
                                    <div class="useful-links">
                                        <a href="#" data-bs-toggle="tooltip" title="Compare"><i
                                                class="pe-7s-refresh-2"></i>compare</a>
                                        <a href="#" data-bs-toggle="tooltip" title="Wishlist"><i
                                                class="pe-7s-like"></i>wishlist</a>
                                    </div>
                                    <div class="like-icon">
                                        <a class="facebook" href="#"><i class="fa fa-facebook"></i>like</a>
                                        <a class="twitter" href="#"><i class="fa fa-twitter"></i>tweet</a>
                                        <a class="pinterest" href="#"><i class="fa fa-pinterest"></i>save</a>
                                        <a class="google" href="#"><i class="fa fa-google-plus"></i>share</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- product details inner end -->
                </div>
            </div>
        </div>
    </div>
    <!-- Quick view modal end -->


    @php
    // Kiểm tra nếu giỏ hàng trống, tránh lỗi khi truy cập thuộc tính
    $subtotal = $cartItems->sum(fn($item) => $item->quantity * optional($item->variant)->price);
    $shippingFee = 30000; // Phí vận chuyển cố định
    $total = $subtotal + $shippingFee;
@endphp

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
                        @foreach ($cartItems as $item)
                            @php
                                $variant = optional($item->variant);
                                $product = optional($variant->product);
                            @endphp
                            <li class="minicart-item">
                                <div class="minicart-thumb">
                                    <a href="#">
                                        <img class="img-fluid" src="{{ $variant->getThumbnailAttribute() ?? asset('images/default-thumbnail.jpg') }}"
                                            alt="{{ $product->name ?? 'Sản phẩm không tồn tại' }}" />
                                    </a>
                                </div>
                                <div class="minicart-content">
                                    <h3 class="product-name">
                                        <a href="#">{{ $product->name ?? 'Sản phẩm không tồn tại' }}</a>
                                    </h3>
                                    <p>
                                        <span class="cart-quantity">{{ $item->quantity }} <strong>&times;</strong></span>
                                        <span>{{ number_format($variant->price ?? 0, 0, ',', '.') }} VNĐ</span>
                                    </p>
                                </div>
                                <button class="minicart-remove" data-id="{{ $item->id }}">
                                    <i class="pe-7s-close"></i>
                                </button>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="minicart-pricing-box">
                    <ul>
                        <li><span>Tổng giá sản phẩm</span><span><strong>{{ number_format($subtotal, 0, ',', '.') }} VND</strong></span></li>
                        <li><span>Phí vận chuyển</span><span><strong>{{ number_format($shippingFee, 0, ',', '.') }} VND</strong></span></li>
                        <li class="total">
                            <span>Tổng tiền đơn hàng</span>
                            <span><strong>{{ number_format($total, 0, ',', '.') }} VND</strong></span>
                        </li>
                    </ul>
                </div>

                <div class="minicart-button">
                    <a href="{{ route('cart.index') }}"><i class="fa fa-shopping-cart"></i> Xem giỏ hàng</a>
                    <a href="{{ route('checkout') }}"><i class="fa fa-share"></i> Thanh toán</a>
                </div>
            </div>
        </div>
    </div>
</div>



    <!-- JS
============================================ -->

    <!-- Modernizer JS -->
    <script src="{{asset('assets/js/vendor/modernizr-3.6.0.min.js')}}"></script>
    <!-- jQuery JS -->
    <script src="{{asset('assets/js/vendor/jquery-3.6.0.min.js')}}"></script>
    <!-- Bootstrap JS -->
    <script src="{{asset('assets/js/vendor/bootstrap.bundle.min.js')}}"></script>
    <!-- slick Slider JS -->
    <script src="{{asset('assets/js/plugins/slick.min.js')}}"></script>
    <!-- Countdown JS -->
    <script src="{{asset('assets/js/plugins/countdown.min.js')}}"></script>
    <!-- Nice Select JS -->
    <script src="{{asset('assets/js/plugins/nice-select.min.js')}}"></script>
    <!-- jquery UI JS -->
    <script src="{{asset('assets/js/plugins/jqueryui.min.js')}}"></script>
    <!-- Image zoom JS -->
    <script src="{{asset('assets/js/plugins/image-zoom.min.js')}}"></script>
    <!-- Images loaded JS -->
    <script src="{{asset('assets/js/plugins/imagesloaded.pkgd.min.js')}}"></script>
    <!-- mail-chimp active js -->
    <script src="{{asset('assets/js/plugins/ajaxchimp.js')}}"></script>
    <!-- contact form dynamic js -->
    <script src="{{asset('assets/js/plugins/ajax-mail.js')}}"></script>
    <!-- google map api -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCfmCVTjRI007pC1Yk2o2d_EhgkjTsFVN8"></script>
    <!-- google map active js -->
    <script src="{{asset('assets/js/plugins/google-map.js')}}"></script>
    <!-- Main JS -->
    <script src="{{asset('assets/js/main.js')}}"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            console.log("DOM fully loaded and parsed");

            // Hàm để lấy số lượng sản phẩm trong giỏ hàng
            function updateCartCount() {
                console.log("Calling updateCartCount");
                fetch("{{ route('cart.count') }}")
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log("Cart count data:", data);
                        document.querySelectorAll('.minicart-btn .notification').forEach(element => {
                            element.textContent = data.count;
                        });
                    })
                    .catch(error => console.error('Error fetching cart count:', error));
            }

            // Gọi hàm để cập nhật số lượng sản phẩm trong giỏ hàng khi trang được tải
            updateCartCount();
        });
    </script>
</body>

</html>
