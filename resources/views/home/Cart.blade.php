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
                        <!-- Cart Table Area -->
                        <div class="cart-table table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th class="pro-thumbnail">Thumbnail</th>
                                        <th class="pro-title">Product</th>
                                        <th class="pro-price">Price</th>
                                        <th class="pro-quantity">Quantity</th>
                                        <th class="pro-subtotal">Total</th>
                                        <th class="pro-remove">Remove</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cartItems as $item)
                                    <tr>
                                        <td class="pro-thumbnail"><a href="#"><img class="img-fluid" src="{{ $item->image }}" alt="{{ $item->name }}" /></a></td>
                                        <td class="pro-title"><a href="#">{{ $item->name }}</a></td>
                                        <td class="pro-price"><span>${{ $item->price }}</span></td>
                                        <td class="pro-quantity">
                                            <form action="{{ route('cart.update', $item->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="pro-qty">
                                                    <input type="number" name="quantity" value="{{ $item->quantity }}" min="1">
                                                    <button type="submit" class="btn btn-sqr">Update</button>
                                                </div>
                                            </form>
                                        </td>
                                        <td class="pro-subtotal"><span>${{ $item->price * $item->quantity }}</span></td>
                                        <td class="pro-remove">
                                            <form action="{{ route('cart.destroy', $item->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger"><i class="fa fa-trash-o"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- Cart Update Option -->
                        <div class="cart-update-option d-block d-md-flex justify-content-between">
                            <div class="apply-coupon-wrapper">
                                <form action="{{ route('cart.applyCoupon') }}" method="POST" class="d-block d-md-flex">
                                    @csrf
                                    <input type="text" name="coupon_code" placeholder="Enter Your Coupon Code" required />
                                    <button class="btn btn-sqr">Apply Coupon</button>
                                </form>
                            </div>
                            <div class="cart-update">
                                <a href="{{ route('cart.index') }}" class="btn btn-sqr">Update Cart</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-5 ml-auto">
                        <!-- Cart Calculation Area -->
                        <div class="cart-calculator-wrapper">
                            <div class="cart-calculate-items">
                                <h6>Cart Totals</h6>
                                <div class="table-responsive">
                                    <table class="table">
                                        <tr>
                                            <td>Sub Total</td>
                                            <td>{{ $cartTotal }} VND</td>
                                        </tr>
                                        <tr>
                                            <td>Shipping</td>
                                            <td>{{ $shippingCost }} VND</td>
                                        </tr>
                                        <tr class="total">
                                            <td>Total</td>
                                            <td class="total-amount">{{ $cartTotal + $shippingCost }} VND</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <a href="#" class="btn btn-sqr d-block">Proceed Checkout</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
