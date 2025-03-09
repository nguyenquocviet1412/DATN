@extends('admin.layout')
@section('title', 'Quản lý Kích thước')
@section('header', 'Quản lý Kích thước')
@section('title2', 'Quản lý Kích thước')
@section('content')
    <div class="container">
        <h2>Quản lý Kích thước</h2>
        <a href="{{ route('admin.size.create') }}" class="btn btn-primary">Thêm Kích thước</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên Kích thước</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sizes as $size)
                    <tr>
                        <td>{{ $size->id }}</td>
                        <td>{{ $size->size }}</td> <!-- Đảm bảo gọi đúng tên cột -->
                        <td>
                            @if (!$size->trashed()) 
                                <a href="{{ route('admin.size.softDelete', $size->id) }}" class="btn btn-danger">Xóa mềm</a>
                            @else
                                <a href="{{ route('admin.size.restore', $size->id) }}" class="btn btn-success">Khôi phục</a>
                            @endif
                            <a href="{{ route('admin.size.edit', $size->id) }}" class="btn btn-warning">Sửa</a>
                            <form action="{{ route('admin.size.destroy', $size->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Xóa</button>
                            </form>
                        </td>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
