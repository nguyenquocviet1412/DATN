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
                                <li class="breadcrumb-item"><a href="{{route('shop.index')}}">shop</a></li>
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
                        <div class="cart-table ">
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
                                    @if ($cartItems->isEmpty())
                                        <tr>
                                            <td colspan="6" class="text-center">Không có sản phẩm nào trong giỏ hàng</td>
                                        </tr>
                                    @endif
                                    @foreach ($cartItems as $item)

                                    <tr>
                                        <td class="pro-thumbnail">
                                            <a href="{{route('product.show',$item->variant->product->id)}}">
                                                <img class="product-img" src="{{ $item->variant->getThumbnailAttribute() }}" alt="{{ optional($item->variant->product)->name }}" />
                                            </a>
                                        </td>
                                        <td class="pro-title">
                                            <a href="{{route('product.show',$item->variant->product->id)}}">
                                                {{ optional($item->variant->product)->name }}
                                            </a>
                                            <form action="{{ route('cart.updateVariant') }}" method="POST">
                                                @csrf
                                                <select name="variant_id" class="variant-select" onchange="this.form.submit()">
                                                    @foreach ($item->variant->product->variants as $variant)
                                                        <option value="{{ $variant->id }}"
                                                                data-stock="{{ $variant->quantity }}"
                                                                {{ $variant->id == $item->variant->id ? 'selected' : '' }}
                                                                {{ $variant->quantity == 0 ? 'disabled' : '' }}>
                                                            {{ optional($variant->color)->name }}, {{ optional($variant->size)->size }}
                                                            ({{ $variant->quantity > 0 ? 'Còn ' . $variant->quantity : 'Hết hàng' }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <input type="hidden" name="cart_id" value="{{ $item->id }}">
                                            </form>
                                        </td>
                                        <td class="pro-price">
                                            <span>{{ number_format($item->variant->price, 0, ',', '.') }} VNĐ</span>
                                        </td>
                                        <td class="pro-quantity">
                                            <div class="input-group quantity-input">
                                                <button class="btn btn-sm btn-decrease" data-id="{{ $item->id }}">-</button>
                                                <input type="number"
                                                       value="{{ $item->quantity }}"
                                                       min="1"
                                                       max="{{ $item->variant->quantity }}"
                                                       data-id="{{ $item->id }}"
                                                       class="update-cart">
                                                <button class="btn btn-sm btn-increase" data-id="{{ $item->id }}">+</button>
                                            </div>
                                            <p class="text-danger stock-warning" data-id="{{ $item->id }}" style="display: none;">Số lượng vượt quá tồn kho!</p>
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
                body: JSON.stringify({
                    quantity: quantity
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.message === 'Cập nhật thành công') {
                    updateCart();
                } else if (data.message === 'Số lượng trong kho không đủ') {
                    alert(`Chỉ có tối đa ${data.max_quantity} sản phẩm trong kho.`);
                    document.querySelector(`.update-cart[data-id="${id}"]`).value = data.max_quantity;
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
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    }).then(response => response.json())
                    .then(data => {
                        if (data.message === 'Xóa sản phẩm thành công') {
                            this.closest('tr').remove();
                            updateCart();
                        }
                    });
            });
        });

        document.querySelectorAll('.update-variant').forEach(button => {
    button.addEventListener('click', function() {
        let cartId = this.dataset.cartId;
        let size = document.querySelector(`#size-${cartId}`).value;
        let color = document.querySelector(`#color-${cartId}`).value;
        let quantity = document.querySelector(`#quantity-${cartId}`).value;

        fetch('/cart/update-variant', {
            method: 'POST',
            headers: {'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content},
            body: JSON.stringify({ cart_id: cartId, size: size, color: color, quantity: quantity })
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            if (data.status === 'warning') {
                document.querySelector(`#quantity-${cartId}`).value = data.new_quantity;
            }
        });
    });
});

$(document).ready(function() {
    // Cập nhật biến thể
    $('.variant-select').change(function() {
        let cartId = $(this).data('id');
        let variantId = $(this).val();
        let stock = $(this).find(':selected').data('stock'); // Lấy tồn kho của biến thể mới

        $.ajax({
            url: '/cart/update-variant',
            type: 'POST',
            data: { id: cartId, variant_id: variantId },
            success: function(response) {
                if (response.success) {
                    let row = $('select[data-id="'+cartId+'"]').closest('tr');

                    // Cập nhật giá, tồn kho, số lượng tối đa
                    row.find('.pro-price span').text(response.price + ' VNĐ');
                    row.find('.update-cart').attr('max', stock);
                    row.find('.pro-subtotal span').text(response.subtotal + ' VNĐ');

                    if (response.stock < row.find('.update-cart').val()) {
                        row.find('.update-cart').val(response.stock);
                        row.find('.stock-warning').show();
                    } else {
                        row.find('.stock-warning').hide();
                    }
                }
            }
        });
    });

    // Cập nhật số lượng
    $('.update-cart').on('input', function() {
        let cartId = $(this).data('id');
        let quantity = parseInt($(this).val());
        let maxStock = parseInt($(this).attr('max'));

        if (quantity > maxStock) {
            $(this).val(maxStock);
            $('.stock-warning[data-id="'+cartId+'"]').show();
        } else {
            $('.stock-warning[data-id="'+cartId+'"]').hide();
        }

        $.ajax({
            url: '/cart/update-quantity',
            type: 'POST',
            data: { id: cartId, quantity: quantity },
            success: function(response) {
                if (response.success) {
                    let row = $('input[data-id="'+cartId+'"]').closest('tr');
                    row.find('.pro-subtotal span').text(response.subtotal + ' VNĐ');
                }
            }
        });
    });

    // Nút tăng giảm số lượng
    $('.btn-decrease, .btn-increase').click(function() {
        let input = $(this).siblings('.update-cart');
        let quantity = parseInt(input.val());
        let maxStock = parseInt(input.attr('max'));

        if ($(this).hasClass('btn-decrease') && quantity > 1) {
            input.val(quantity - 1).trigger('input');
        } else if ($(this).hasClass('btn-increase') && quantity < maxStock) {
            input.val(quantity + 1).trigger('input');
        }
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

    .quantity-input {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .quantity-input .btn {
        background-color: #f8f9fa;
        border: 1px solid #ced4da;
        color: #495057;
        padding: 6px;
        line-height: 1.5;
        border-radius: 0.25rem;
        cursor: pointer;
    }

    .quantity-input .btn:hover {
        background-color: #e2e6ea;
    }

    .quantity-input input {
        width: 60px;
        text-align: center;
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
        padding: 0.375rem 0.75rem;
        font-size: 1rem;
        line-height: 1.5;
    }

    .quantity-input input:focus {
        border-color: #80bdff;
        outline: 0;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }

    .variant-select {
        width: 100%;
        padding: 0.375rem 0.75rem;
        font-size: 1rem;
        line-height: 1.5;
        color: #495057;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }

    .variant-select:focus {
        border-color: #80bdff;
        outline: 0;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }
</style>
<style>
    .product-img {
        width: 100px;
        height: 100px;
        object-fit: contain;
    }
    .pro-thumbnail img {
    width: 100px; /* Điều chỉnh kích thước phù hợp */
    height: 100px;
    object-fit: contain; /* Hiển thị toàn bộ ảnh mà không bị cắt */
    border: 1px solid #ddd; /* Thêm viền nếu cần */
    padding: 5px;
    background: #fff;
}
</style>
@endsection
