@extends('admin.layout')
@section('title')
Danh sách đánh giá | Quản trị Admin
@endsection
@section('title2')
Danh sách đánh giá
@endsection
@section('content')

<div class="container mt-5">
    <h1 class="mb-4 text-center">Danh sách đánh giá</h1>
    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-primary">
                <tr>
                    <th>ID sản phẩm</th>
                    <th>Ảnh sản phẩm</th>
                    <th>ID đơn hàng sản phẩm</th>
                    <th>Đánh giá trung bình</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @foreach($rates as $rate)
                <tr>
                    <td>{{ $rate->id_product }}</td>
                    <td>
                            @if($rate->product !== null)
                            @php
                                $variant = $rate->product->variants->first(); // Lấy biến thể đầu tiên nếu có
                                $image = optional($variant?->images->first())->image_url; // Lấy ảnh đầu tiên nếu có
                                $imageSrc = $image ? (filter_var($image, FILTER_VALIDATE_URL) ? $image : asset($image)) : asset('default-image.jpg');
                            @endphp
                                <img src="{{ $imageSrc }}" width="80px" height="80px" class="rounded shadow-sm" alt="Ảnh sản phẩm">
                            @endif

                    </td>
                    <td>{{ $rate->id_order_item }}</td>
                    <td>{{ number_format($rate->average_rating, 2) }}</td>
                    <td>
                        {{-- Nếu id_product là null thì ẩn nút --}}
                        @if ($rate->id_product !== null)
                        <a href="{{ route('rate.show', $rate->id_product) }}" class="btn btn-sm btn-info">Chi tiết</a>
                        @elseif ($rate->id_product === null)
                        <span class="text-muted">Sản phẩm không tồn tại</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection
