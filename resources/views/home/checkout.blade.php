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
        <h2 class="my-4 text-center text-warning fw-bold">🛒 Thanh toán</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="card p-4 shadow-lg border-0" style="background: #fff9e6;">
            <table class="table table-hover">
                <thead class="bg-warning text-dark">
                    <tr>
                        <th>Hình ảnh</th>
                        <th>Sản phẩm</th>
                        <th>Màu sắc - Size</th>
                        <th>Giá</th>
                        <th>Số lượng</th>
                        <th>Tổng</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cartItems as $item)
                        <tr>
                            <td><img src="{{ asset($item->variant->getThumbnailAttribute()) }}" alt="{{ $item->variant->product->name }}" width="70" class="rounded shadow"></td>
                            <td class="fw-bold">{{ $item->variant->product->name }}</td>
                            <td class="text-muted">{{ $item->variant->color->name }} - {{ $item->variant->size->size }}</td>
                            <td class="text-danger">{{ number_format($item->price) }}₫</td>
                            <td>{{ $item->quantity }}</td>
                            <td class="text-success">{{ number_format($item->price * $item->quantity) }}₫</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <h5 class="text-end">Tổng trước giảm giá: <strong class="text-dark">{{ number_format($cartTotalBeforeDiscount) }}₫</strong></h5>

            <!-- Hiển thị thông báo voucher -->
            <div id="voucher-message"></div>

            <!-- Form nhập mã giảm giá -->
            <form id="apply-voucher-form" class="d-flex justify-content-end my-3">
                <input type="text" name="voucher_code" class="form-control w-25 me-2 shadow" placeholder="🔖 Nhập mã giảm giá">
                <button type="submit" class="btn btn-warning fw-bold shadow">Áp dụng</button>
            </form>

            <h5 class="text-end text-success">Giảm giá: <strong id="discount-amount">-{{ number_format(session('discount_amount', 0)) }}₫</strong></h5>
            <h4 class="text-end text-danger">Tổng thanh toán:
                <strong id="cart-total-after-discount">{{ number_format(session('cart_total_after_discount', $cartTotalBeforeDiscount)) }}₫</strong>
            </h4>

            <form action="{{ route('placeOrder') }}" method="POST" class="mt-4">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <label class="form-label text-dark fw-bold">📌 Họ và Tên</label>
                        <input type="text" name="fullname" class="form-control shadow" value="{{ old('fullname') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-dark fw-bold">📞 Số điện thoại</label>
                        <input type="text" name="phone" class="form-control shadow" value="{{ old('phone') }}" required>
                    </div>
                </div>

                <label class="form-label mt-3 text-dark fw-bold">📍 Địa chỉ giao hàng</label>
                <input type="text" name="shipping_address" class="form-control shadow" value="{{ old('shipping_address') }}" required>

                <!--  Phương thức thanh toán -->
                <label class="form-label mt-3 text-dark fw-bold">💳 Phương thức thanh toán</label>
                <div class="d-flex flex-wrap">
                    <div class="form-check me-3">
                        <input class="form-check-input" type="radio" name="payment_method" value="cod" checked>
                        <label class="form-check-label">📦 Thanh toán khi nhận hàng (COD)</label>
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
                        <input class="form-check-input" type="radio" name="payment_method" value="credit_card">
                        <label class="form-check-label">Thẻ tín dụng</label>
                    </div>
                </div>

                <button type="submit" class="btn btn-warning mt-4 w-100 fw-bold py-3 shadow-lg">🚀 Đặt hàng ngay</button>
            </form>
        </div>
    </div>
</main>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    // Xử lý khi người dùng ấn nút Áp dụng
$(document).ready(function () {
    $('#apply-voucher-form').submit(function (e) {
        e.preventDefault(); // Ngăn reload trang

        let voucherCode = $('input[name="voucher_code"]').val();

        $.ajax({
            url: "{{ route('applyVoucher') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                voucher_code: voucherCode
            },
            success: function (response) {
                if (response.success) {
                    $('#voucher-message').html('<div class="alert alert-success">' + response.message + '</div>');
                    $('#discount-amount').text('-' + response.discount.toLocaleString() + '₫');
                    $('#cart-total-after-discount').text(response.cart_total_after_discount.toLocaleString() + '₫');
                } else {
                    $('#voucher-message').html('<div class="alert alert-danger">' + response.message + '</div>');
                }
            },
            error: function () {
                $('#voucher-message').html('<div class="alert alert-danger">Có lỗi xảy ra, vui lòng thử lại!</div>');
            }
        });
    });
});
</script>
@endsection
