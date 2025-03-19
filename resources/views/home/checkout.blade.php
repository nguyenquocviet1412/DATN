{{-- @extends('master.main')
@section('title', 'Thanh toán')
@section('main')

    <main>
        <div class="container">
            <h2 class="my-4 text-center">Thanh toán</h2>

            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="card p-4">
                <table class="table table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Giá</th>
                            <th>Số lượng</th>
                            <th>Tổng</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cart as $item)
                            <tr>
                                <td>{{ $item['name'] }}</td>
                                <td>{{ number_format($item['price']) }}₫</td>
                                <td>{{ $item['quantity'] }}</td>
                                <td>{{ number_format($item['price'] * $item['quantity']) }}₫</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <h5 class="text-end">Tổng trước giảm giá: <strong>{{ number_format($cartTotalBeforeDiscount) }}₫</strong>
                </h5>

                <!-- Phần nhập mã giảm giá -->
                <form action="{{ route('applyVoucher') }}" method="POST" class="d-flex justify-content-end my-3">
                    @csrf
                    <input type="text" name="voucher_code" class="form-control w-25 me-2" placeholder="Nhập mã giảm giá">
                    <button type="submit" class="btn btn-success">Áp dụng</button>
                </form>

                <h5 class="text-end text-success">Giảm giá: <strong>-{{ number_format($cartDiscount) }}₫</strong></h5>
                <h4 class="text-end text-danger">Tổng thanh toán:
                    <strong>{{ number_format($cartTotalAfterDiscount) }}₫</strong>
                </h4>

                <form action="{{ route('placeOrder') }}" method="POST" class="mt-4">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">Họ và Tên</label>
                            <input type="text" name="fullname" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Số điện thoại</label>
                            <input type="text" name="phone" class="form-control" required>
                        </div>
                    </div>

                    <label class="form-label mt-3">Địa chỉ giao hàng</label>
                    <input type="text" name="shipping_address" class="form-control" required>

                    <!-- Căn chỉnh lại Phương thức thanh toán -->
                    <label class="form-label mt-3">Phương thức thanh toán</label>
                    <div class="d-flex flex-wrap">
                        <div class="form-check me-3">
                            <input class="form-check-input" type="radio" name="payment_method" value="cod" checked>
                            <label class="form-check-label">Thanh toán khi nhận hàng (COD)</label>
                        </div>
                        <div class="form-check me-3">
                            <input class="form-check-input" type="radio" name="payment_method" value="momo">
                            <label class="form-check-label">Momo</label>
                        </div>
                        <div class="form-check me-3">
                            <input class="form-check-input" type="radio" name="payment_method" value="vnpay">
                            <label class="form-check-label">VNPay</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="payment_method" value="paypal">
                            <label class="form-check-label">PayPal</label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary mt-4 w-100">Đặt hàng</button>
                </form>
            </div>
        </div>
    </main>
@endsection --}}
@extends('master.main')
@section('title', 'Thanh toán')
@section('main')

    <main>
        <div class="container">
            <h2 class="my-4 text-center">Thanh toán</h2>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="card p-4">
                <table class="table table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Giá</th>
                            <th>Số lượng</th>
                            <th>Tổng</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cart as $item)
                            <tr>
                                <td>{{ $item['name'] }}</td>
                                <td>{{ number_format($item['price']) }}₫</td>
                                <td>{{ $item['quantity'] }}</td>
                                <td>{{ number_format($item['price'] * $item['quantity']) }}₫</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <h5 class="text-end">Tổng trước giảm giá: <strong>{{ number_format($cartTotalBeforeDiscount) }}₫</strong></h5>

                <!-- Phần nhập mã giảm giá -->
                <form action="{{ route('applyVoucher') }}" method="POST" class="d-flex justify-content-end my-3">
                    @csrf
                    <input type="text" name="voucher_code" class="form-control w-25 me-2" 
                           placeholder="Nhập mã giảm giá" value="{{ old('voucher_code') }}">
                    <button type="submit" class="btn btn-success">Áp dụng</button>
                </form>

                <h5 class="text-end text-success">Giảm giá: <strong>-{{ number_format($cartDiscount) }}₫</strong></h5>
                <h4 class="text-end text-danger">Tổng thanh toán:
                    <strong>{{ number_format($cartTotalAfterDiscount) }}₫</strong>
                </h4>

                <form action="{{ route('placeOrder') }}" method="POST" class="mt-4">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">Họ và Tên</label>
                            <input type="text" name="fullname" class="form-control" value="{{ old('fullname') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Số điện thoại</label>
                            <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" required>
                        </div>
                    </div>

                    <label class="form-label mt-3">Địa chỉ giao hàng</label>
                    <input type="text" name="shipping_address" class="form-control" value="{{ old('shipping_address') }}" required>

                    <!--  Phương thức thanh toán -->
                    <label class="form-label mt-3">Phương thức thanh toán</label>
                    <div class="d-flex flex-wrap">
                        <div class="form-check me-3">
                            <input class="form-check-input" type="radio" name="payment_method" value="cod" checked>
                            <label class="form-check-label">Thanh toán khi nhận hàng (COD)</label>
                        </div>
                        <div class="form-check me-3">
                            <input class="form-check-input" type="radio" name="payment_method" value="momo">
                            <label class="form-check-label">Momo</label>
                        </div>
                        <div class="form-check me-3">
                            <input class="form-check-input" type="radio" name="payment_method" value="vnpay">
                            <label class="form-check-label">VNPay</label>
                        </div>p
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="payment_method" value="credit_card">
                            <label class="form-check-label">Thẻ tín dụng</label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary mt-4 w-100">Đặt hàng</button>
                </form>
            </div>
        </div>
    </main>
@endsection
