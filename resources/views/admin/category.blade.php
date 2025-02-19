@extends('admin.layout')

@section('title', 'Danh mục | Quản trị Admin')

@section('title2', 'Danh sách danh mục')

@section('content')

{{-- thông báo thêm thành công --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if(session('success'))
    <script>
        Swal.fire({
            title: 'Thành công!',
            text: '{{ session("success") }}',
            icon: 'success',
            showConfirmButton: false,
            timer: 4000,
            backdrop: true  // Làm tối nền
        });
    </script>
@endif

<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <div class="tile-body">
                <div class="row element-button">
                    <div class="col-sm-2">
                        <a class="btn btn-add btn-sm" href="{{route('category.create')}}" title="Thêm">
                            <i class="fas fa-plus"></i> Tạo mới danh mục
                        </a>
                    </div>
                </div>

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
                            <td>{{ $item->created_at }}</td>
                            <td>
                                <a href="" class="btn btn-primary btn-sm edit" title="Sửa">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <form action="" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm trash" type="submit" title="Xóa"
                                        onclick="return confirm('Bạn có chắc muốn xóa danh mục này không?');">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>

@endsection
