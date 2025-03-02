@extends('admin.layout')
@section('title')
Chi tiết đánh giá | Quản trị Admin
@endsection
@section('title2')
Chi tiết đánh giá
@endsection
@section('content')


    <div class="container">
        <h2>Danh sách đánh giá cho sản phẩm {{ $id_product }}</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>ID Người dùng</th>
                    <th>Đánh giá</th>
                    <th>Nội dung</th>
                    <th>Trạng thái</th>
                    <th>Ngày tạo</th>
                </tr>
            </thead>
            <tbody>
                @foreach($rates as $rate)
                    <tr>
                        <td>{{ $rate->id }}</td>
                        <td>{{ $rate->id_user }}</td>
                        <td>{{ $rate->rating }} ⭐</td>
                        <td>{{ $rate->review }}</td>
                        <td>{{ $rate->status }}</td>
                        <td>{{ $rate->created_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <a href="{{ route('rate.index') }}" class="btn btn-primary">Quay lại</a>
    </div>

@endsection
