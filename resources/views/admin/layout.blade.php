<!DOCTYPE html>
<html lang="en">

<head>
    <title>@yield('title')</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/doc/css/main.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <!-- or -->
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css"
        href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    {{-- <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> --}}

    <!-- Boxicons -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    {{-- css và js chp form add và update --}}
    <script>
        function readURL(input, thumbimage) {
            if (input.files && input.files[0]) { //Sử dụng  cho Firefox - chrome
                var reader = new FileReader();
                reader.onload = function(e) {
                    $("#thumbimage").attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            } else { // Sử dụng cho IE
                $("#thumbimage").attr('src', input.value);

            }
            $("#thumbimage").show();
            $('.filename').text($("#uploadfile").val());
            $('.Choicefile').css('background', '#14142B');
            $('.Choicefile').css('cursor', 'default');
            $(".removeimg").show();
            $(".Choicefile").unbind('click');

        }
        $(document).ready(function() {
            $(".Choicefile").bind('click', function() {
                $("#uploadfile").click();

            });
            $(".removeimg").click(function() {
                $("#thumbimage").attr('src', '').hide();
                $("#myfileupload").html('<input type="file" id="uploadfile"  onchange="readURL(this);" />');
                $(".removeimg").hide();
                $(".Choicefile").bind('click', function() {
                    $("#uploadfile").click();
                });
                $('.Choicefile').css('background', '#14142B');
                $('.Choicefile').css('cursor', 'pointer');
                $(".filename").text("");
            });
        })
    </script>

    <style>
        .Choicefile {
            display: block;
            background: #14142B;
            border: 1px solid #fff;
            color: #fff;
            width: 150px;
            text-align: center;
            text-decoration: none;
            cursor: pointer;
            padding: 5px 0px;
            border-radius: 5px;
            font-weight: 500;
            align-items: center;
            justify-content: center;
        }

        .Choicefile:hover {
            text-decoration: none;
            color: white;
        }

        #uploadfile,
        .removeimg {
            display: none;
        }

        #thumbbox {
            position: relative;
            width: 100%;
            margin-bottom: 20px;
        }

        .removeimg {
            height: 25px;
            position: absolute;
            background-repeat: no-repeat;
            top: 5px;
            left: 5px;
            background-size: 25px;
            width: 25px;
            /* border: 3px solid red; */
            border-radius: 50%;

        }

        .removeimg::before {
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
            content: '';
            border: 1px solid red;
            background: red;
            text-align: center;
            display: block;
            margin-top: 11px;
            transform: rotate(45deg);
        }

        .removeimg::after {
            /* color: #FFF; */
            /* background-color: #DC403B; */
            content: '';
            background: red;
            border: 1px solid red;
            text-align: center;
            display: block;
            transform: rotate(-45deg);
            margin-top: -2px;
        }

        .chart-container {
            background: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            margin: auto;
        }

        .chart-title {
            font-size: 20px;
            font-weight: bold;
            color: #333;
            padding-bottom: 10px;
            border-bottom: 3px solid #facc15;
            /* Gạch vàng dưới tiêu đề */
        }

        .status-label {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 5px;
            font-weight: bold;
            text-align: center;
            min-width: 100px;
        }

        .status-pending {
            background-color: #757de8;
            color: white;
        }

        /* Chờ xử lý - Màu tím */
        .status-completed {
            background-color: #81c784;
            color: white;
        }

        /* Hoàn thành - Màu xanh lá */
        .status-failed {
            background-color: #e57373;
            color: white;
        }

        /* Thất bại - Màu đỏ */

        /* menu sub */

        .dropdown-menu {
            background-color: #14142B;
            /* Màu nền giống menu */
            border: none;
            /* Loại bỏ viền */
            box-shadow: none;
            /* Loại bỏ bóng */
            border-radius: 0;
            /* Loại bỏ bo góc */
            padding: 0;
            /* Loại bỏ padding mặc định */
            width: 100%;
            /* Đặt chiều rộng bằng với menu chính */
            left: 0;
            /* Căn trái với menu chính */
            position: absolute;
            /* Đảm bảo dropdown nằm trên menu */
            z-index: 1000;
            /* Đảm bảo dropdown hiển thị trên các thành phần khác */
        }

        .dropdown-menu .dropdown-item {
            color: #fff;
            /* Màu chữ trắng */
            padding: 10px 20px;
            /* Tăng khoảng cách giữa các mục */
            font-size: 14px;
            /* Kích thước chữ */
            transition: background-color 0.3s ease;
            /* Hiệu ứng hover mượt */
        }

        .dropdown-menu .dropdown-item:hover {
            background-color: #1f1f2e;
            /* Màu nền khi hover */
            color: #fff;
            /* Màu chữ khi hover */
        }

        .nav-item:hover .dropdown-menu {
            display: block;
            /* Hiển thị dropdown khi hover vào menu chính */
        }
    </style>



</head>


<body onload="time()" class="app sidebar-mini rtl">
    <!-- Navbar-->
    <header class="app-header">
        <!-- Sidebar toggle button--><a class="app-sidebar__toggle" href="#" data-toggle="sidebar"
            aria-label="Hide Sidebar"></a>
        <!-- Navbar Right Menu-->
        <ul class="app-nav">


            <!-- User Menu-->
            <li><a class="app-nav__item" href="{{ route('admin.logout') }}"><i class='bx bx-log-out bx-rotate-180'></i>
                </a>

            </li>
        </ul>
    </header>
    @php
    if (session('user.avatar')) {
    $anh = session('user.avatar');
    } else {
    $anh = 'avatar/default-avatar.jpg';
    }

    @endphp
    <!-- Sidebar menu-->
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <aside class="app-sidebar">
        <div class="app-sidebar__user"><img class="app-sidebar__user-avatar" src="{{ asset('storage') . '/' . $anh }}"
                width="50px" alt="User Image">
            <div>
                <p class="app-sidebar__user-name">
                    <b>
                        @if (session('employee'))
                        {{ session('employee')['username'] }}
                        @endif
                    </b>
                </p>
                <p class="app-sidebar__user-designation">Chào mừng bạn trở lại</p>
            </div>
        </div>
        <hr>
        <ul class="app-menu">
            <li>
                <a class="app-menu__item" href="{{ route('admin.dashboard') }}">
                    <i class="app-menu__icon bx bx-tachometer"></i>
                    <span class="app-menu__label">Bảng điều khiển</span>
                </a>
            </li>

            <!-- Quản lý sản phẩm -->
            <li class="nav-item dropdown">
                <a class="app-menu__item dropdown-toggle" href="#" data-bs-toggle="dropdown">
                    <i class="app-menu__icon bx bx-box"></i>
                    <span class="app-menu__label">Quản lý sản phẩm</span>
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{ route('category.index') }}">Danh mục</a></li>
                    <li><a class="dropdown-item" href="{{ route('product.index') }}">Sản phẩm</a></li>
                    <li><a class="dropdown-item" href="{{ route('admin.banners.index') }}">Banner</a></li>
                    <li><a class="dropdown-item" href="{{ route('admin.size.index') }}">Size</a></li>
                    <li><a class="dropdown-item" href="{{ route('admin.color.index') }}">Màu sắc</a></li>
                </ul>
            </li>

            <!-- Quản lý người dùng -->
            <li class="nav-item dropdown">
                <a class="app-menu__item dropdown-toggle" href="#" data-bs-toggle="dropdown">
                    <i class="app-menu__icon bx bx-user"></i>
                    <span class="app-menu__label">Quản lý người dùng</span>
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{ route('employee.index') }}">Nhân viên</a></li>
                    <li><a class="dropdown-item" href="{{ route('user.index') }}">Khách hàng</a></li>
                </ul>
            </li>

            <!-- Quản lý bán hàng -->
            <li class="nav-item dropdown">
                <a class="app-menu__item dropdown-toggle" href="#" data-bs-toggle="dropdown">
                    <i class="app-menu__icon bx bx-cart"></i>
                    <span class="app-menu__label">Quản lý bán hàng</span>
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{ route('order.index') }}">Đơn hàng</a></li>
                    <li><a class="dropdown-item" href="{{ route('voucher.index') }}">Khuyến mãi</a></li>
                </ul>
            </li>

            <!-- Nội dung & tương tác -->
            <li class="nav-item dropdown">
                <a class="app-menu__item dropdown-toggle" href="#" data-bs-toggle="dropdown">
                    <i class="app-menu__icon bx bx-message-dots"></i>
                    <span class="app-menu__label">Nội dung & tương tác</span>
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{ route('post.index') }}">Bài viết</a></li>
                    <li><a class="dropdown-item" href="{{ route('comment.index') }}">Bình luận</a></li>
                    <li><a class="dropdown-item" href="{{ route('rate.index') }}">Đánh giá</a></li>
                </ul>
            </li>

            <!-- Tài chính & báo cáo -->
            <li class="nav-item dropdown">
                <a class="app-menu__item dropdown-toggle" href="#" data-bs-toggle="dropdown">
                    <i class="app-menu__icon bx bx-wallet"></i>
                    <span class="app-menu__label">Tài chính & báo cáo</span>
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{ route('wallet.index') }}">Quản lý ví tiền</a></li>
                    <li><a class="dropdown-item" href="{{ route('admin.wallet_transactions.index') }}">Lịch sử giao dịch</a></li>
                    <li><a class="dropdown-item" href="{{ route('admin.reports.index') }}">Báo cáo doanh thu</a></li>
                </ul>
            </li>
        </ul>

    </aside>
    <main class="app-content">
        <div class="row">
            <div class="col-md-12">
                <div class="app-title">
                    <ul class="app-breadcrumb breadcrumb">
                        <li class="breadcrumb-item"><a href="#"><b>@yield('title2')</b></a></li>
                    </ul>
                    <div id="clock"></div>
                </div>
            </div>
        </div>




        @yield('content')






        <div class="text-center" style="font-size: 13px">
            <p><b>Copyright
                    <script type="text/javascript">
                        document.write(new Date().getFullYear());
                    </script> Phần mềm quản lý bán hàng | WD-45
                </b></p>
            {{-- <pre>
            {{ print_r(session()->all(), true) }}
            </pre> --}}
        </div>

    </main>

    <script src="{{ asset('admin/doc/js/jquery-3.2.1.min.js') }}"></script>
    <!--===============================================================================================-->
    <script src="{{ asset('admin/doc/js/popper.min.js') }}"></script>
    <script src="https://unpkg.com/boxicons@latest/dist/boxicons.js"></script>
    <!--===============================================================================================-->
    <script src="{{ asset('admin/doc/js/bootstrap.min.js') }}"></script>
    <!--===============================================================================================-->
    <script src="{{ asset('admin/doc/js/main.js') }}"></script>
    <!--===============================================================================================-->
    <script src="{{ asset('admin/doc/js/plugins/pace.min.js') }}"></script>
    <!--===============================================================================================-->
    <script type="text/javascript" src="{{ asset('admin/doc/js/plugins/chart.js') }}"></script>
    <!--===============================================================================================-->

    <script type="text/javascript">
        //Thời Gian
        function time() {
            var today = new Date();
            var weekday = new Array(7);
            weekday[0] = "Chủ Nhật";
            weekday[1] = "Thứ Hai";
            weekday[2] = "Thứ Ba";
            weekday[3] = "Thứ Tư";
            weekday[4] = "Thứ Năm";
            weekday[5] = "Thứ Sáu";
            weekday[6] = "Thứ Bảy";
            var day = weekday[today.getDay()];
            var dd = today.getDate();
            var mm = today.getMonth() + 1;
            var yyyy = today.getFullYear();
            var h = today.getHours();
            var m = today.getMinutes();
            var s = today.getSeconds();
            m = checkTime(m);
            s = checkTime(s);
            nowTime = h + " giờ " + m + " phút " + s + " giây";
            if (dd < 10) {
                dd = '0' + dd
            }
            if (mm < 10) {
                mm = '0' + mm
            }
            today = day + ', ' + dd + '/' + mm + '/' + yyyy;
            tmp = '<span class="date"> ' + today + ' - ' + nowTime +
                '</span>';
            document.getElementById("clock").innerHTML = tmp;
            clocktime = setTimeout("time()", "1000", "Javascript");

            function checkTime(i) {
                if (i < 10) {
                    i = "0" + i;
                }
                return i;
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
    const dropdowns = document.querySelectorAll('.nav-item.dropdown');

    dropdowns.forEach(dropdown => {
        const toggle = dropdown.querySelector('.dropdown-toggle');
        const menu = dropdown.querySelector('.dropdown-menu');

        toggle.addEventListener('click', function (e) {
            e.preventDefault();
            menu.classList.toggle('show'); // Hiển thị hoặc ẩn menu
        });

        // Đóng dropdown khi nhấp ra ngoài
        document.addEventListener('click', function (event) {
            if (!dropdown.contains(event.target)) {
                menu.classList.remove('show');
            }
        });
    });
});
    </script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Essential javascripts for application to work-->
    <script src="{{ asset('admin/doc/js/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ asset('admin/doc/js/popper.min.js') }}"></script>
    <script src="{{ asset('admin/doc/js/bootstrap.min.js') }}"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="../src/jquery.table2excel.js"></script>
    <script src="{{ asset('admin/doc/js/main.js') }}"></script>
    <!-- The javascript plugin to display page loading on top-->
    <script src="{{ asset('admin/doc/js/plugins/pace.min.js') }}"></script>
    <!-- Page specific javascripts-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
    <!-- Data table plugin-->
    <script type="text/javascript" src="{{ asset('admin/doc/js/plugins/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('admin/doc/js/plugins/dataTables.bootstrap.min.js') }}"></script>
    <script type="text/javascript">
        $('#sampleTable').DataTable();
    </script>

</body>

</html>