@extends('admin.layout')
@section('title', 'Danh sách người dùng | Quản trị Admin')
@section('title2', 'Danh sách người dùng')

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <div class="tile-body">

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
                        backdrop: true // Làm tối nền
                    });
                </script>
                @endif


                {{-- Thông báo lỗi --}}
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                @if(session('error'))
                <script>
                    Swal.fire({
                        title: 'Lỗi!',
                        text: '{{ session("error") }}',
                        icon: 'error',
                        showConfirmButton: true, // Hiển thị nút đóng
                        confirmButtonText: 'Đóng', // Nội dung nút đóng
                        backdrop: true // Làm tối nền
                    });
                </script>
                @endif


                <div class="row element-button">
                    <div class="col-sm-6">
                        <a class="btn btn-add btn-sm" href="{{ route('user.create') }}" title="Thêm">
                            <i class="fas fa-plus"></i> Tạo mới người dùng
                        </a>
                        <a class="btn  btn-danger btn-sm" href="{{ route('user.deleted') }}" title="Thêm">
                            <i class="fas fa-history"></i> Lịch sử người dùng đã bị xóa
                        </a>
                    </div>
                </div>

                <table class="table table-hover table-bordered" id="sampleTable">
                    <thead>
                        <tr class="text-center">
                            <th><input type="checkbox" id="select-all"></th>
                            <th>ID</th>
                            <th>Họ và tên</th>
                            <th>Email</th>
                            <th>Số điện thoại</th>
                            <th>Địa chỉ</th>
                            <th>Giới tính</th>
                            <th>Trạng thái</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                        <tr class="align-middle">
                            <td class="text-center">
                                <input type="checkbox" name="check1" value="{{ $user->id }}">
                            </td>
                            <td class="text-center">{{ $user->id }}</td>
                            <td class="text-center">{{ $user->fullname }}</td>
                            <td class="text-center">{{ $user->email }}</td>
                            <td class="text-center">{{ $user->phone }}</td>
                            <td class="text-center">{{ $user->address }}</td>
                            <td class="text-center">
                                @if($user->gender == 'Male')
                                Nam
                                @else
                                Nữ
                                @endif
                            </td>
                            <td class="text-center">
                                <span class="badge {{ $user->status == 'active' ? 'bg-success' : 'bg-danger' }}">
                                    {{ $user->status == 'active' ? 'Hoạt động' : 'Vô hiệu hóa' }}
                                </span>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('user.show', $user->id) }}" class="btn btn-primary btn-sm">
                                    <i class="fa fa-eye"></i>
                                </a>
                                <a href="{{ route('user.edit', $user->id) }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('user.delete', $user->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" type="submit" onclick="return confirm('Bạn có chắc chắn muốn xóa tài khoản khách hàng này?')">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Phân trang -->
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
