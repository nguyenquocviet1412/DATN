@extends('master.main')
@section('title', 'Đơn hàng')
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
                                    <li class="breadcrumb-item"><a href="shop.html">shop</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">cart</li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- breadcrumb area end -->

        <!-- cart main wrapper start -->
        <div class="cart-main-wrapper section-padding">
            <div class="container">
                <div class="section-bg-color">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="cart-table table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="pro-thumbnail">Hình ảnh</th>
                                            <th class="pro-title">Sản phẩm</th>
                                            <th class="pro-price">Giá</th>
                                            <th class="pro-quantity">Số lượng</th>
                                            <th class="pro-subtotal">Tổng</th>
                                            <th class="pro-remove">Xóa</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($cartItems as $item)
                                            <tr>
                                                <td class="pro-thumbnail">
                                                    <a href="#">
                                                        <img class="img-fluid" src="{{ $item->variant->getThumbnailAttribute() }}" alt="{{ optional($item->variant->product)->name }}" />
                                                    </a>
                                                </td>
                                                <td class="pro-title">
                                                    <a href="#">
                                                        {{ optional($item->variant->product)->name }} ({{ optional($item->variant->color)->name }}, {{ optional($item->variant->size)->size }})
                                                    </a>
                                                </td>
                                                <td class="pro-price">
                                                    <span>{{ number_format($item->variant->price, 0, ',', '.') }} VNĐ</span>
                                                </td>
                                                <td class="pro-quantity">
                                                    <div class="pro-qty">
                                                        <input type="number" value="{{ $item->quantity }}" min="1" data-id="{{ $item->id }}" class="update-cart">
                                                    </div>
                                                </td>
                                                <td class="pro-subtotal">
                                                    <span>{{ number_format($item->variant->price * $item->quantity, 0, ',', '.') }} VNĐ</span>
                                                </td>
                                                <td class="pro-remove">
                                                    <a href="#" class="remove-cart-item" data-id="{{ $item->id }}">
                                                        <i class="fa fa-trash-o"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                            <div class="cart-update-option d-block d-md-flex justify-content-between">
                                <div class="apply-coupon-wrapper">
                                    <form action="{{ route('cart.applyCoupon') }}" method="post" class="d-block d-md-flex">
                                        @csrf
                                        <input type="text" name="coupon_code" placeholder="Nhập mã giảm giá" required />
                                        <button class="btn btn-sqr">Áp dụng</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-5 ml-auto">
                            <div class="cart-calculator-wrapper">
                                <div class="cart-calculate-items">
                                    <h6>Tổng giỏ hàng</h6>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tr>
                                                <td>Tạm tính</td>
                                                {{-- <td>{{ number_format($cartTotal, 0, ',', '.') }} VNĐ</td> --}}
                                            </tr>
                                            <tr>
                                                <td>Phí vận chuyển</td>
                                                {{-- <td>{{ number_format($shippingFee, 0, ',', '.') }} VNĐ</td> --}}
                                            </tr>
                                            <tr class="total">
                                                <td>Tổng cộng</td>
                                                {{-- <td class="total-amount">{{ number_format($cartTotal + $shippingFee, 0, ',', '.') }} VNĐ</td> --}}
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <a href="{{ route('checkout') }}" class="btn btn-sqr d-block">Thanh toán</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            document.querySelectorAll('.update-cart').forEach(input => {
                input.addEventListener('change', function() {
                    let id = this.dataset.id;
                    let quantity = this.value;

                    fetch(`/cart/update/${id}`, {
                        method: 'PUT',
                        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                        body: JSON.stringify({ quantity: quantity })
                    }).then(response => location.reload());
                });
            });

            document.querySelectorAll('.remove-cart-item').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    let id = this.dataset.id;

                    fetch(`/cart/destroy/${id}`, {
                        method: 'DELETE',
                        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                    }).then(response => location.reload());
                });
            });
        </script>
        <!-- cart main wrapper end -->
    </main>



    <style>
        .pro-qty input {
            width: 60px;
            text-align: center;
        }

        .btn-sqr {
            margin-left: 10px;
        }
    </style>
@endsection
