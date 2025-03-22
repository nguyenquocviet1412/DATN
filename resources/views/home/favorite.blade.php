@extends('master.main')
@section('title', 'Trang Danh Sách Yêu Thích')
@section('main')

<!-- wishlist main wrapper start -->
<div class="wishlist-main-wrapper section-padding">
    <div class="container">
        <!-- Wishlist Page Content Start -->
        <div class="section-bg-color">
            <div class="row">
                <div class="col-lg-12">
                    <!-- Wishlist Table Area -->
                    <div class="cart-table table-responsive">
                        <h1>Các sản phẩm yêu thích của bạn</h1>

                        @if($favoriteItems->isEmpty())
                        <p>Bạn không có vật phẩm yêu thích.</p>
                        @else
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="pro-thumbnail">Thumbnail</th>
                                    <th class="pro-title">Product</th>
                                    <th class="pro-price">Price</th>
                                    <th class="pro-remove">Remove</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($favoriteItems as $item)
                                <tr>
                                    <td class="pro-thumbnail">
                                        @if($item->product && $item->product->images->isNotEmpty())

                                        <img src="{{ asset($item->product->images->first()->image_url) }}" alt="{{ $item->product->name }}" class="img-fluid">
                                        @else
                                        <img src="{{ asset('path/to/default/image.jpg') }}" alt="Default Image" class="img-fluid">
                                        @endif
                                    </td>

                                    <td class="pro-title">
                                        @if($item->product)
                                        <h2><a href="{{ route('product.show', $item->product->id) }}">{{ $item->product->name }}</a></h2>
                                        @else
                                        <h2>Không có sản phẩm</h2>
                                        @endif
                                    </td>
                                    <td class="pro-price">
                                        @if($item->product)
                                        <span>{{ number_format($item->product->price, 0, ',', '.') }} VNĐ</span>
                                        @else
                                        <span>Không có giá</span>
                                        @endif
                                    </td>
                                    <td class="pro-remove">
                                        <form action="{{ route('favorite.remove', $item->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger"><i class="fa fa-trash-o"></i></button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <!-- Wishlist Page Content End -->
    </div>
</div>
<!-- wishlist main wrapper end -->
<style>
    .wishlist-main-wrapper h1 {
        font-size: 2.5rem;
        font-weight: bold;
        color: #333;
        text-align: center;
        margin-bottom: 20px;
    }

    .wishlist-main-wrapper p {
        font-size: 1.2rem;
        color: #666;
        text-align: center;
        margin-top: 10px;
    }
</style>
@endsection