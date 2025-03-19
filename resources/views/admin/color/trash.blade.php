@extends('admin.layout')

@section('title', 'Danh sách màu đã xóa')
@section('header', 'Danh sách màu đã xóa')
@section('title2', 'Danh sách màu đã xóa')

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
        <h2>Danh sách màu đã xóa</h2>
        
        <a href="{{ route('admin.color.index') }}" class="btn btn-secondary">Quay về</a> <!-- Nút quay về -->

        <table class="table table-bordered mt-3">
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
                            <a href="{{ route('admin.color.restore', $color->id) }}" class="btn btn-success">Khôi phục</a>
                            <form action="{{ route('admin.color.destroy', $color->id) }}" method="POST"
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
        {{ $colors->links() }}
    </div>
@endsection
