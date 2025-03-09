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
                    <th>ID Product</th>
                    <th>Order Item ID</th>
                    <th>Average Rating</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($rates as $rate)
                <tr>
                    <td>{{ $rate->id_product }}</td>
                    <td>{{ $rate->id_order_item }}</td>
                    <td>{{ number_format($rate->average_rating, 2) }}</td>
                    <td>
                        <a href="{{ route('rate.show', $rate->id_product) }}" class="btn btn-sm btn-info">View Details</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection
