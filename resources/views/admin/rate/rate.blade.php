// filepath: /c:/laragon/www/DATN/resources/views/admin/rate/rate.blade.php
@extends('admin.layout')
@section('title')
Danh sách đánh giá | Quản trị Admin
@endsection
@section('title2')
Danh sách đánh giá
@endsection
@section('content')

<div class="container">
    <h1 class="mb-4 text-center">Danh sách đánh giá</h1>
    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-primary">
                <tr>
                    <th>ID</th>
                    <th>User ID</th>
                    <th>Product ID</th>
                    <th>Order Item ID</th>
                    <th>Rating</th>
                    <th>Average Rating</th>
                    <th>Review</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rate as $rate)
                <tr>
                    <td>{{ $rate->id }}</td>
                    <td>{{ $rate->id_user }}</td>
                    <td>{{ $rate->id_product }}</td>
                    <td>{{ $rate->id_order_item }}</td>
                    <td>{{ $rate->rating }}</td>
                    <td>{{ $average }}</td>
                    <td>{{ $rate->review }}</td>
                    <td>{{ $rate->status }}</td>
                    <td>{{ $rate->created_at }}</td>
                    <td>{{ $rate->updated_at }}</td>
                    <td>
                        <a href="{{ route('rate.edit', $rate->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('rate.destroy', $rate->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
   
</div>

@endsection