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
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico">

    <!-- CSS
	============================================ -->
    <!-- google fonts -->
    <link href="https://fonts.googleapis.com/css?family=Lato:300,300i,400,400i,700,900" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/css/vendor/bootstrap.min.css">
    <!-- Pe-icon-7-stroke CSS -->
    <link rel="stylesheet" href="assets/css/vendor/pe-icon-7-stroke.css">
    <!-- Font-awesome CSS -->
    <link rel="stylesheet" href="assets/css/vendor/font-awesome.min.css">
    <!-- Slick slider css -->
    <link rel="stylesheet" href="assets/css/plugins/slick.min.css">
    <!-- animate css -->
    <link rel="stylesheet" href="assets/css/plugins/animate.css">
    <!-- Nice Select css -->
    <link rel="stylesheet" href="assets/css/plugins/nice-select.css">
    <!-- jquery UI css -->
    <link rel="stylesheet" href="assets/css/plugins/jqueryui.min.css">
    <!-- main style css -->
    <link rel="stylesheet" href="assets/css/style.css">

</head>

<body>

    <!-- Bootstrap Toast Container -->
<div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1050;">
    @if(session('success'))
        <div class="toast align-items-center text-bg-success border-0 show" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    🎉 {{ session('success') }}
                </div>
                <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="toast align-items-center text-bg-danger border-0 show" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    ❌ {{ session('error') }}
                </div>
                <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    @endif
</div>

       <!-- Start Header Area -->
       <header class="header-area header-wide">
        <!-- main header start -->
        <div class="main-header d-none d-lg-block">
            <!-- header top start -->
            <div class="header-top bdr-bottom">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-6">
                            <div class="welcome-message">
                                <p>Welcome to Corano Jewelry online store</p>
                            </div>
                        </div>
                        <div class="col-lg-6 text-right">
                            <div class="header-top-settings">
                                <ul class="nav align-items-center justify-content-end">
                                    <li class="curreny-wrap">
                                        $ Currency
                                        <i class="fa fa-angle-down"></i>
                                        <ul class="dropdown-list curreny-list">
                                            <li><a href="#">$ USD</a></li>
                                            <li><a href="#">€ EURO</a></li>
                                        </ul>
                                    </li>
                                    <li class="language">
                                        <img src="assets/img/icon/en.png" alt="flag"> English
                                        <i class="fa fa-angle-down"></i>
                                        <ul class="dropdown-list">
                                            <li><a href="#"><img src="assets/img/icon/en.png" alt="flag"> english</a></li>
                                            <li><a href="#"><img src="assets/img/icon/fr.png" alt="flag"> french</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- header top end -->

            <!-- header middle area start -->
            <div class="header-main-area sticky">
                <div class="container">
                    <div class="row align-items-center position-relative">

                        <!-- start logo area -->
                        <div class="col-lg-2">
                            <div class="logo">
                                <a href="{{ route('home.index') }}">
                                    <img src="assets/img/logo/logo.png" alt="Brand Logo">
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
                                            <li class="active"><a href="index.html">Home <i class="fa fa-angle-down"></i></a>
                                               
                                            </li>
                                            <li class="position-static">
                                                <a href="#">Danh mục <i class="fa fa-angle-down"></i></a>
                                                <ul class="megamenu dropdown">
                                                    
                                                    @foreach ($categories as $category)
                                                        <li><a href="">{{ $category->name }}</a></li>
                                                    @endforeach
                                                </ul>
                                            </li>
                                            
                                            <li><a href="shop.html">shop <i class="fa fa-angle-down"></i></a>
                                                <ul class="dropdown">
                                                    <li><a href="#">shop grid layout <i class="fa fa-angle-right"></i></a>
                                                        <ul class="dropdown">
                                                            <li><a href="shop.html">shop grid left sidebar</a></li>
                                                            
                                                        </ul>
                                                    </li>
                                                   
                                                </ul>
                                            </li>
                                            <li><a href="blog-left-sidebar.html">Blog <i class="fa fa-angle-down"></i></a>
                                                <ul class="dropdown">
                                                    <li><a href="blog-left-sidebar.html">blog left sidebar</a></li>
                                                    
                                                </ul>
                                            </li>
                                            <li><a href="contact-us.html">Contact us</a></li>
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
                                    <form class="header-search-box d-lg-none d-xl-block">
                                        <input type="text" placeholder="Search entire store hire" class="header-search-field">
                                        <button class="header-search-btn"><i class="pe-7s-search"></i></button>
                                    </form>
                                </div>
                                <div class="header-configure-area">
                                    <ul class="nav justify-content-end">
                                        <li class="user-hover">
                                            <a href="#">
                                                <i class="pe-7s-user"></i>
                                            </a>
                                            <ul class="dropdown-list">
                                                <li><a href="{{ route('home.login') }}">login</a></li>
                                                <li><a href="{{ route('home.register') }}">register</a></li>
                                                <li><a href="my-account.html">my account</a></li>
                                            </ul>
                                        </li>
                                        <li>
                                            <a href="wishlist.html">
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
                                    <img src="assets/img/logo/logo.png" alt="Brand Logo">
                                </a>
                            </div>
                            <div class="mobile-menu-toggler">
                                <div class="mini-cart-wrap">
                                    <a href="cart.html">
                                        <i class="pe-7s-shopbag"></i>
                                        <div class="notification">0</div>
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
                                        <i class="fa fa-angle-down"></i>
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
                                        <i class="fa fa-angle-down"></i>
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
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let toastElements = document.querySelectorAll(".toast");
            toastElements.forEach(function (toastEl) {
                let toast = new bootstrap.Toast(toastEl, { delay: 4000 });
                toast.show();
            });
        });
    </script>

</body>


</html>
