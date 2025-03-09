{{-- @extends('admin.layout')


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

    <h2>Danh sách kích thước đã xóa</h2>
    <a href="{{ route('admin.size.index') }}" class="btn btn-secondary">Quay về</a> 
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
@endsection --}}

@extends('admin.layout')

@section('title', 'Danh sách kích thước đã xóa')
@section('header', 'Danh sách kích thước đã xóa')
@section('title2', 'Danh sách kích thước đã xóa')

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
            document.querySelectorAll('.alert').forEach(alert => alert.style.display = 'none');
        }, 3000); // 3 giây sau tự ẩn
    </script>

    <div class="container">
        <h2>Danh sách kích thước đã xóa</h2>
        
        <a href="{{ route('admin.size.index') }}" class="btn btn-secondary">Quay về</a> <!-- Nút quay về -->

        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Kích thước</th>
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
                            <form action="{{ route('admin.size.destroy', $size->id) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Xóa vĩnh viễn</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
