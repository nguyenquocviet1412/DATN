@extends('admin.layout')
@section('title2', 'Thùng rác Banner')
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
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <h3>Thùng rác Banner</h3>
                    <a href="{{ route('admin.banners.index') }}" class="btn btn-secondary mb-3"><i class="fas fa-arrow-left"></i> Quay lại Quản lý Banner</a>

                    @if ($banners->isEmpty())
                        <p>Thùng rác trống.</p>
                    @else
                        <table class="table table-bordered mt-3">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Hình ảnh</th>
                                    <th>Tiêu đề</th>
                                    <th>Loại</th>
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
                                        <td>
                                            <form action="{{ route('admin.banners.restore', $banner->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Bạn có chắc chắn muốn khôi phục banner này?')"><i class="fas fa-undo"></i> Khôi phục</button>
                                            </form>
                                            <form action="{{ route('admin.banners.delete', $banner->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa vĩnh viễn banner này?')"><i class="fas fa-trash-alt"></i> Xóa vĩnh viễn</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $banners->links() }}
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
