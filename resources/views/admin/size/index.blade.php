@extends('admin.layout')
@section('title', 'Quản lý Kích thước')
@section('header', 'Quản lý Kích thước')
@section('title2', 'Quản lý Kích thước')
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
        <h2>Quản lý Kích thước</h2>
        <a href="{{ route('admin.size.create') }}" class="btn btn-primary">Thêm Kích thước</a>
        <a href="{{ route('admin.size.trash') }}" class="btn btn-secondary">Danh sách đã xóa</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên Kích thước</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sizes as $size)
                @if (!$size->trashed())
                    <tr>
                        <td>{{ $size->id }}</td>
                        <td>{{ $size->size }}</td> <!-- Đảm bảo gọi đúng tên cột -->
                        <td>
                            <a href="{{ route('admin.size.softDelete', $size->id) }}" class="btn btn-danger">Xóa</a>
                            <a href="{{ route('admin.size.edit', $size->id) }}" class="btn btn-warning">Sửa</a>
                        </td>
                    </tr>
                @endif
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
