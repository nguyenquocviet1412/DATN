@extends('admin.layout')

@section('title', 'Quản lý Màu sắc')
@section('header', 'Quản lý Màu sắc')
@section('title2', 'Quản lý Màu sắc')

@section('content')

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <script>
        setTimeout(function() {
            document.querySelector('.alert').style.display = 'none';
        }, 3000); // 3 giây sau sẽ tự ẩn
    </script>

    <div class="container">
        <h2>Quản lý Màu sắc</h2>
        <a href="{{ route('admin.color.create') }}" class="btn btn-primary">Thêm Màu</a>
        <a href="{{ route('admin.color.trash') }}" class="btn btn-secondary">Danh sách đã xóa</a>
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
                    @if (!$color->trashed())
                    <tr>
                        <td>{{ $color->id }}</td>
                        <td>{{ $color->name }}</td>
                        <td>
                            <a href="{{ route('admin.color.softDelete', $color->id) }}" class="btn btn-danger">Xóa</a>
                            <a href="{{ route('admin.color.edit', $color->id) }}" class="btn btn-warning">Sửa</a>
                        </td>
                    </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
        {{ $colors->links() }}
    </div>
@endsection
