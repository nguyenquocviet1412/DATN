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
                            <td class="text-danger">{{ number_format($item->price, 0, ',', '.') }}₫</td>
                            <td>{{ $item->quantity }}</td>
                            <td class="text-success">{{ number_format($item->price * $item->quantity, 0, ',', '.') }}₫</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <h5 class="text-end">Tổng trước giảm giá: <strong class="text-dark">{{ number_format($cartTotalBeforeDiscount, 0, ',', '.') }}₫</strong></h5>

            <!-- Hiển thị thông báo voucher -->
            <div id="voucher-message"></div>

            <!-- Form nhập mã giảm giá -->
            <form id="apply-voucher-form" class="d-flex justify-content-end my-3" method="POST">
                @csrf
                <input type="text" name="voucher_code" class="form-control w-25 me-2 shadow" placeholder="🔖 Nhập mã giảm giá">
                <button type="submit" class="btn btn-warning fw-bold shadow">Áp dụng</button>
            </form>

            <h5 class="text-end text-success">Giảm giá: <strong id="discount-amount">-{{ number_format(session('discount_amount', 0), 0, ',', '.') }}₫</strong></h5>
            <h4 class="text-end text-danger">Tổng thanh toán:
                <strong id="cart-total-after-discount">{{ number_format(session('cart_total_after_discount', $cartTotalBeforeDiscount), 0, ',', '.') }}₫</strong>
            </h4>
            @php
                $user = \App\Models\User::where('id', Auth::id())->first();
            @endphp
            <form action="{{ route('placeOrder') }}" method="POST" class="mt-4">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <label class="form-label text-dark fw-bold">📌 Họ và Tên</label>
                        <input type="text" name="fullname" class="form-control shadow" value="{{ $user->fullname }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-dark fw-bold">📞 Số điện thoại</label>
                        <input type="text" name="phone" class="form-control shadow" value="{{ $user->phone }}" required>
                    </div>
                </div>

                <label class="form-label mt-3 text-dark fw-bold">📍 Địa chỉ giao hàng</label>
                <input type="text" name="shipping_address" class="form-control shadow" value="{{ $user->address }}" required>

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
        e.preventDefault(); // Ngăn chặn reload trang

        let voucherCode = $('input[name="voucher_code"]').val();

        $.ajax({
            url: "{{ route('applyVoucher') }}",
            type: "POST", // Đảm bảo dùng POST
            data: {
                _token: "{{ csrf_token() }}",
                voucher_code: voucherCode
            },
            success: function (response) {
                if (response.success) {
                    $('#voucher-message').html('<div class="alert alert-success">' + response.message + '</div>');
                    $('#discount-amount').text('-' + response.discount.toLocaleString('de-DE') + '₫');
                    $('#cart-total-after-discount').text(response.cart_total_after_discount.toLocaleString('de-DE') + '₫');
                } else {
                    $('#voucher-message').html('<div class="alert alert-danger">' + response.message + '</div>');
                }
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText); // Hiển thị lỗi chi tiết trong console
                $('#voucher-message').html('<div class="alert alert-danger">Có lỗi xảy ra, vui lòng thử lại!</div>');
            }
        });
    });
});
</script>
@endsection
