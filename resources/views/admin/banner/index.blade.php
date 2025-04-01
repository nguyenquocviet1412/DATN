@extends('admin.layout')
@section('title2', 'Quản lý Banner')
@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if(session('success'))
        <script>
            Swal.fire({
                title: 'Thành công!',
                text: '{{ session("success") }}',
                icon: 'success',
                showConfirmButton: false,
                timer: 4000
            });
        </script>
    @endif
    @if(session('error'))
        <script>
            Swal.fire({
                title: 'Lỗi!',
                text: '{{ session("error") }}',
                icon: 'error',
                confirmButtonText: 'Đóng'
            });
        </script>
    @endif
<div class="container">
    <h2>Quản lý Banner</h2>
    <a href="{{ route('admin.banners.create') }}" class="btn btn-primary">Thêm Banner</a>


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
                    <a href="{{ route('admin.banners.edit', $banner->id) }}" class="btn btn-sm btn-warning">Sửa</a>
                    <form action="{{ route('admin.banners.destroy', $banner->id) }}" method="POST"
                        onsubmit="return confirmDelete()" style="display:inline;">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                  </form>

                  <script>
                  function confirmDelete() {
                      return confirm("Bạn có chắc chắn muốn xóa banner này không?");
                  }
                  </script>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $banners->links() }}
</div>
@endsection
