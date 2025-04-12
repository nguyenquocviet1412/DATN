@extends('admin.layout')
@section('title2', 'Quản lý Banner')
@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.3/font/bootstrap-icons.min.css">
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
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <div class="row element-button">
                        <div class="col-sm-6">
                            <a href="{{ route('admin.banners.create') }}" class="btn btn-success"><i class="fas fa-plus"></i>Thêm Banner</a>
                            <a href="{{ route('admin.banners.trash') }}" class="btn btn-info"><i class="fas fa-trash"></i> Thùng rác</a>
                        </div>
                    </div>

                    <table  class="table table-hover table-bordered" id="sampleTable">
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
                                        <a href="{{ route('admin.banners.edit', $banner->id) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i> Sửa</a>
                                        <form action="{{ route('admin.banners.destroy', $banner->id) }}" method="POST"
                                            onsubmit="return confirmDelete()" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i> Xóa</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{ $banners->links() }}

                    <script>
                        function confirmDelete() {
                            return confirm("Bạn có chắc chắn muốn xóa banner này không?");
                        }
                    </script>
                </div>
            </div>
        </div>
    </div>
@endsection
