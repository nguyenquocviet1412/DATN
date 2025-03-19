@extends('master.main')

@section('main')

<!-- breadcrumb area start -->
<div class="breadcrumb-area">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb-wrap">
                    <nav aria-label="breadcrumb">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{route('home.index')}}"><i class="fa fa-home"></i> Trang chủ</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Shop</li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- breadcrumb area end -->

<!-- Hiển thị tiêu đề danh mục hoặc từ khóa tìm kiếm -->
<div class="container mt-4">
    <h2 class="category-title text-center">
        <i class="pe-7s-shopbag"></i>
        @if(isset($searchKeyword))
            Kết quả tìm kiếm: "{{ $searchKeyword }}"
        @else
            {{ $categories->first()->name ?? 'Danh mục sản phẩm' }}
        @endif
    </h2>
    <hr class="category-divider">
</div>

<div class="container mt-3">
    <div class="row">
        @foreach($products as $product)
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                <div class="card product-card">
                    <!-- Carousel hiển thị hình ảnh sản phẩm -->
                    <div id="productCarousel{{ $product->id }}" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            @php $first = true; @endphp
                            @foreach($product->variants as $variant)
                                @foreach($variant->images as $image)
                                    <div class="carousel-item {{ $first ? 'active' : '' }}">
                                        <img src="{{ asset($image->image_url) }}" class="d-block w-100 product-img" alt="{{ $product->name }}">
                                    </div>
                                    @php $first = false; @endphp
                                @endforeach
                            @endforeach
                        </div>
                    </div>

                    <div class="card-body text-center">
                        <h5 class="product-name">{{ $product->name }}</h5>
                        <p class="product-category text-muted">
                            <i class="pe-7s-tag"></i> {{ $product->category->name ?? 'Không có danh mục' }}
                        </p>
                        <p class="product-price text-danger font-weight-bold">
                            {{ number_format($product->price) }} VNĐ
                        </p>
                        <a href="{{ route('product.show', $product->id) }}" class="btn btn-view-detail">
                            <i class="pe-7s-look"></i> Xem chi tiết
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Phân trang -->
    <div class="pagination-container d-flex justify-content-center mt-4">
        {{ $products->links('pagination::bootstrap-5') }}
    </div>
</div>

<!-- CSS Tùy chỉnh -->
<style>
    /* Tiêu đề danh mục */
    .category-title {
        font-size: 2rem;
        font-weight: bold;
        color: #333;
    }

    .category-divider {
        width: 50%;
        margin: 10px auto;
        border-top: 3px solid #007bff;
    }

    /* Card sản phẩm */
    .product-card {
        border-radius: 12px;
        overflow: hidden;
        transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        background: #fff;
    }

    .product-card:hover {
        transform: scale(1.05);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
    }

    .product-img {
        height: 220px;
        object-fit: cover;
        border-bottom: 2px solid #ddd;
    }

    .product-name {
        font-size: 1rem;
        font-weight: bold;
        color: #333;
    }

    .product-category {
        font-size: 0.9rem;
        color: #777;
    }

    .product-price {
        font-size: 1.2rem;
        font-weight: bold;
    }

    .btn-view-detail {
        background: linear-gradient(45deg, #007bff, #0056b3);
        color: white;
        padding: 10px 15px;
        border-radius: 8px;
        font-size: 0.9rem;
        transition: background 0.3s ease-in-out, transform 0.2s ease-in-out;
        text-decoration: none;
        display: inline-block;
    }

    .btn-view-detail:hover {
        background: linear-gradient(45deg, #0056b3, #003f7f);
        transform: translateY(-2px);
    }

    /* Phân trang */
    .pagination-container {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .pagination .page-item .page-link {
        color: #007bff;
        border-radius: 8px;
        margin: 0 5px;
        transition: all 0.3s ease-in-out;
    }

    .pagination .page-item.active .page-link {
        background-color: #007bff;
        border-color: #007bff;
        color: white;
    }

    .pagination .page-item .page-link:hover {
        background-color: #0056b3;
        color: white;
    }
</style>

@endsection
