
@extends('admin.layout')

@section('title2', 'Thùng rác Banner')

@section('content')
<div class="container">
    <h2>Thùng rác Banner</h2>
    <a href="{{ route('admin.banners.index') }}" class="btn btn-secondary">Quay lại danh sách</a>

    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>ID</th>
                <th>Hình ảnh</th>
                <th>Tiêu đề</th>
                <th>Loại</th>
                <th>Trạng thái</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($banners as $banner)
            <tr>
                <td>{{ $banner->id }}</td>
                <td><img src="{{ asset('storage/' . $banner->image) }}" width="100"></td>
                <td>{{ $banner->title }}</td>
                <td>{{ $banner->type }}</td>
                <td>{{ $banner->status ? 'Hiển thị' : 'Ẩn' }}</td>
                <td>
                    <a href="{{ route('admin.banners.restore', $banner->id) }}" class="btn btn-sm btn-success">Khôi phục</a>

                    <form action="{{ route('admin.banners.delete', $banner->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc muốn xóa vĩnh viễn banner này?')">Xóa vĩnh viễn</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $banners->links() }}
</div>
@endsection
