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
                                <li class="breadcrumb-item"><a href="{{route('home.index')}}"><i class="fa fa-home"></i></a></li>
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
                                            <a href="{{route('product.show',$item->variant->product->id)}}">
                                                <img class="img-fluid" src="{{ $item->variant->getThumbnailAttribute() }}" alt="{{ optional($item->variant->product)->name }}" />
                                            </a>
                                        </td>
                                        <td class="pro-title">
                                            <a href="{{route('product.show',$item->variant->product->id)}}">
                                                {{ optional($item->variant->product)->name }}
                                            </a>
                                                <select class="variant-select" data-id="{{ $item->id }}">
                                                    @foreach ($item->variant->product->variants as $variant)
                                                        <option value="{{ $variant->id }}" {{ $variant->id == $item->variant->id ? 'selected' : '' }}>
                                                            {{ optional($variant->color)->name }}, {{ optional($variant->size)->size }}
                                                        </option>
                                                    @endforeach
                                                </select>

                                        </td>
                                        <td class="pro-price">
                                            <span>{{ number_format($item->variant->price, 0, ',', '.') }} VNĐ</span>
                                        </td>
                                        <td class="pro-quantity">
                                            <div class="input-group quantity-input">
                                                <button class="btn btn-sm btn-decrease" data-id="{{ $item->id }}">-</button>
                                                <input type="number" value="{{ $item->quantity }}" min="1" data-id="{{ $item->id }}" class="update-cart">
                                                <button class="btn btn-sm btn-increase" data-id="{{ $item->id }}">+</button>
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
                                            <td id="subtotal">{{ number_format($cartItems->sum(fn($item) => $item->quantity * $item->variant->price), 0, ',', '.') }} VNĐ</td>
                                        </tr>
                                        <tr>
                                            <td>Phí vận chuyển</td>
                                            <td> 30.000 VNĐ</td>
                                        </tr>
                                        <tr class="total">
                                            <td>Tổng cộng</td>
                                            <td id="total">{{ number_format($cartItems->sum(fn($item) => $item->quantity * $item->variant->price) + 30000 , 0, ',', '.') }} VNĐ</td>
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
        document.addEventListener('DOMContentLoaded', function() {
        function updateCartQuantity(id, quantity) {
            fetch(`/cart/update/${id}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ quantity: quantity })
            })
            .then(response => response.json())
            .then(data => {
                if (data.message === 'Cập nhật thành công') {
                    updateCart();
                } else {
                    alert(data.message);
                }
            });
        }



        document.querySelectorAll('.update-cart').forEach(input => {
            input.addEventListener('change', function() {
                let id = this.dataset.id;
                let quantity = parseInt(this.value);
                if (quantity < 1) quantity = 1;
                updateCartQuantity(id, quantity);
            });
        });

        document.querySelectorAll('.btn-increase').forEach(button => {
            button.addEventListener('click', function() {
                let input = this.parentNode.querySelector('.update-cart');
                let id = input.dataset.id;
                let quantity = parseInt(input.value) + 1;
                input.value = quantity;
                updateCartQuantity(id, quantity);
            });
        });

        document.querySelectorAll('.btn-decrease').forEach(button => {
            button.addEventListener('click', function() {
                let input = this.parentNode.querySelector('.update-cart');
                let id = input.dataset.id;
                let quantity = parseInt(input.value) - 1;
                if (quantity < 1) quantity = 1;
                input.value = quantity;
                updateCartQuantity(id, quantity);
            });
        });

        function updateCart() {
            let subtotal = 0; // Biến tổng phụ

            document.querySelectorAll('tbody tr').forEach(row => {
                const quantityInput = row.querySelector('.update-cart');
                if (!quantityInput) return;

                const quantity = parseInt(quantityInput.value);
                const priceText = row.querySelector('.pro-price span').textContent.replace(/[^0-9]/g, "");
                const price = parseInt(priceText); // Chuyển về số nguyên đúng

                const itemSubtotal = quantity * price; // Tổng tiền của từng sản phẩm
                subtotal += itemSubtotal; // Cộng dồn tổng phụ

                // Cập nhật tổng tiền của sản phẩm đó
                row.querySelector('.pro-subtotal span').textContent = itemSubtotal.toLocaleString('vi-VN') + " VNĐ";
            });

            // Cập nhật tổng giỏ hàng
            document.getElementById('subtotal').textContent = subtotal.toLocaleString('vi-VN') + " VNĐ";

            const shippingFee = 30000; // Phí vận chuyển
            const total = subtotal + shippingFee; // Tổng tiền giỏ hàng

            // Cập nhật tổng cộng
            document.getElementById('total').textContent = total.toLocaleString('vi-VN') + " VNĐ";
        }

    });

        document.querySelectorAll('.remove-cart-item').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                let id = this.dataset.id;

                fetch(`/cart/remove/${id}`, {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                }).then(response => response.json())
                .then(data => {
                    if (data.message === 'Xóa sản phẩm thành công') {
                        this.closest('tr').remove();
                        updateCart();
                    }
                });
            });
        });

        document.querySelectorAll('.variant-select').forEach(select => {
            select.addEventListener('change', function() {
                let id = this.dataset.id;
                let variantId = this.value;

                fetch(`/cart/update-variant/${id}`, {
                    method: 'PUT',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    body: JSON.stringify({ variant_id: variantId })
                }).then(response => response.json())
                .then(data => {
                    if (data.message === 'Cập nhật thành công') {
                        location.reload(); // Reload the page to reflect changes
                    }
                });
            });
        });

    </script>
    <!-- cart main wrapper end -->
</main>

<style>
    .pro-qty {
        display: flex;
        align-items: center;
    }

    .pro-qty input {
        width: 60px;
        text-align: center;
        border: 1px solid #ddd;
        margin: 0 5px;
    }
</style>
@endsection
