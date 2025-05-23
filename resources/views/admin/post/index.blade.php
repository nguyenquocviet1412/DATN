
@extends('admin.layout')
@section('title', 'Danh sách Bài Viết| Quản trị Admin')
@section('title2', 'Danh sách Bài Viết')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">

                    {{-- thông báo thêm thành công --}}
                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                    @if (session('success'))
                        <script>
                            Swal.fire({
                                title: 'Thành công!',
                                text: '{{ session('success') }}',
                                icon: 'success',
                                showConfirmButton: false,
                                timer: 4000,
                                backdrop: true // Làm tối nền
                            });
                        </script>
                    @endif

                    {{-- Thông báo lỗi --}}
                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                    @if (session('error'))
                        <script>
                            Swal.fire({
                                title: 'Lỗi!',
                                text: '{{ session('error') }}',
                                icon: 'error',
                                showConfirmButton: true, // Hiển thị nút đóng
                                confirmButtonText: 'Đóng', // Nội dung nút đóng
                                backdrop: true // Làm tối nền
                            });
                        </script>
                    @endif

                    <div class="row element-button">
                        <div class="col-sm-6">
                            <a class="btn btn-add btn-sm" href="{{ route('post.create') }}" title="Thêm">
                                <i class="fas fa-plus"></i> Tạo mới Bài Viết
                            </a>
                        </div>


                    </div>

                    <table class="table table-hover table-bordered" id="sampleTable">
                        <thead>
                            <tr class="text-center">
                                <th>ID</th>
                                <th>Tên người tạo</th>
                                <th>Tiêu đề</th>
                                <th>Nội dung</th>
                                <th>Trạng thái</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($posts as $post)
                                <tr class="align-middle">
                                    <td class="text-center">{{ $post->id }}</td>
                                    <td>
                                        @if (isset($post->employee->username))
                                            {{ $post->employee->username }}
                                        @endif
                                    </td>
                                    <td>{{ $post->title }}</td>
                                    <td>{{ Str::limit($post->content, 200) }}</td>
                                    <td class="text-center">
                                        @if ($post->status === 'published')
                                            <span class="badge bg-success">Đã xuất bản</span>
                                        @else
                                            <span class="badge bg-danger">Nháp</span>
                                        @endif
                                    </td>

                                    <td class="text-center">
                                        <a href="{{ route('post.show', $post->id) }}" class="btn btn-primary btn-sm">
                                            <i class="fa fa-eye"></i>
                                        </a>

                                        <a href="{{ route('post.edit', $post->id) }}" class="btn btn-primary btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <form action="{{ route('post.delete', $post->id) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm" type="submit"
                                                onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <script>
                        document.getElementById('select-all').addEventListener('change', function() {
                            let checkboxes = document.querySelectorAll('input[name="check1"]');
                            checkboxes.forEach(checkbox => checkbox.checked = this.checked);
                        });
                    </script>

                </div>
            </div>
        </div>
    </div>
@endsection
