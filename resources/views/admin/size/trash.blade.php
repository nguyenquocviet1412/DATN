@extends('admin.layout')


@section('content')
<h2>Danh sách kích thước đã xóa</h2>
<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Tên Kích thước</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($sizes as $size)
            <tr>
                <td>{{ $size->id }}</td>
                <td>{{ $size->size }}</td>
                <td>
                    <a href="{{ route('admin.size.restore', $size->id) }}" class="btn btn-success">Khôi phục</a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection