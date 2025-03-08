@extends('admin.layout')

@section('title', 'Quản lý Màu sắc')
@section('header', 'Quản lý Màu sắc')
@section('title2', 'Quản lý Màu sắc')

@section('content')
    <div class="container">
        <h2>Quản lý Màu sắc</h2>
        <a href="{{ route('admin.color.create') }}" class="btn btn-primary">Thêm Màu</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên Màu</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($colors as $color)
                    <tr>
                        <td>{{ $color->id }}</td>
                        <td>{{ $color->name }}</td>
                        <td>
                            @if (!$color->trashed()) 
                                <a href="{{ route('admin.color.softDelete', $color->id) }}" class="btn btn-danger">Xóa mềm</a>
                            @else
                                <a href="{{ route('admin.color.restore', $color->id) }}" class="btn btn-success">Khôi phục</a>
                            @endif
                            <a href="{{ route('admin.color.edit', $color->id) }}" class="btn btn-warning">Sửa</a>
                            <form action="{{ route('admin.color.destroy', $color->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Xóa</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $colors->links() }}
    </div>
@endsection
