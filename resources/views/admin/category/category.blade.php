@extends('admin.layout')

@section('title', 'Danh mục | Quản trị Admin')

@section('title2', 'Danh sách danh mục')

@section('content')

{{-- Thông báo bằng SweetAlert --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if(session('success'))
    <script>
        Swal.fire({
            title: 'Thành công!',
            text: '{{ session("success") }}',
            icon: 'success',
            showConfirmButton: false,
            timer: 4000,
            backdrop: true  
        });
    </script>
@endif

@if(session('error'))
    <script>
        Swal.fire({
            title: 'Lỗi!',
            text: '{{ session("error") }}',
            icon: 'error',
            showConfirmButton: true,
            confirmButtonText: 'Đóng',
            backdrop: true  
        });
    </script>
@endif

<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <div class="tile-body">
                <div class="row element-button">
                    <div class="col-sm-2">
                        <a class="btn btn-add btn-sm" href="{{ route('category.create') }}" title="Thêm">
                            <i class="fas fa-plus"></i> Tạo mới danh mục
                        </a>
                    </div>
                    <div class="col-sm-2">
                        <a class="btn btn-warning btn-sm" href="{{ route('category.trash') }}" title="Thùng rác">
                            <i class="fas fa-trash"></i> Thùng rác
                        </a>
                    </div>
                </div>

                @if($category->isEmpty())
                    <p class="text-center mt-3">Không có danh mục nào.</p>
                @else
                <table class="table table-hover table-bordered" id="sampleTable">
                    <thead>
                        <tr>
                            <th width="10"><input type="checkbox" id="all"></th>
                            <th>ID</th>
                            <th>Tên danh mục</th>
                            <th>Ngày tạo</th>
                            <th>Chức năng</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($category as $item)
                        <tr>
                            <td width="10"><input type="checkbox" name="check1" value="{{ $item->id }}"></td>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->created_at->format('d/m/Y') }}</td>
                            <td>
                                <a href="{{ route('category.edit', $item->id) }}" class="btn btn-primary btn-sm" title="Sửa">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <form action="{{ route('category.delete', $item->id) }}" method="POST" class="d-inline delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-sm delete-btn" title="Xóa" data-id="{{ $item->id }}">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                                
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif

            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Chọn tất cả checkbox
        document.getElementById("all").addEventListener("change", function() {
            document.querySelectorAll('input[name="check1"]').forEach(el => el.checked = this.checked);
        });

        // Xác nhận xóa bằng SweetAlert2
        document.querySelectorAll(".delete-btn").forEach(button => {
            button.addEventListener("click", function() {
                let form = this.closest("form");
                Swal.fire({
                    title: "Bạn có chắc chắn?",
                    text: "Danh mục này sẽ bị xóa mềm và có thể khôi phục trong thùng rác.",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Xóa",
                    cancelButtonText: "Hủy"
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });
</script>

@endsection
