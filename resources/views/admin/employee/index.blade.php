@extends('admin.layout')
@section('title', 'Danh sách Nhân viên| Quản trị Admin')
@section('title2', 'Danh sách Nhân viên')

@section('content')
@php
$admin = Auth::guard('employee')->user();
@endphp
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
                        <!-- Nút Thêm nhân viên (chỉ superadmin) -->
                        @if ($admin->role === 'superadmin')
                        <a class="btn btn-add btn-sm" href="{{ route('employee.create') }}" title="Thêm">
                            <i class="fas fa-plus"></i> Tạo mới Nhân viên
                        </a>
                        @endif
                        <a class="btn btn-danger btn-sm" href="{{ route('employee.deleted') }}" title="Lịch sử xóa">
                            <i class="fas fa-history"></i> Lịch sử nhân viên đã bị xóa
                        </a>
                    </div>

                </div>



                <table class="table table-hover table-bordered" id="sampleTable">
                    <thead>
                        <tr class="text-center">
                            <th><input type="checkbox" id="select-all"></th>
                            <th>ID</th>
                            <th>Tên đăng nhập</th>
                            <th>Họ và tên</th>
                            <th>Email</th>
                            <th>Số điện thoại</th>
                            <th>Giới tính</th>
                            <th>Địa chỉ</th>
                            <th>Vai trò</th>
                            <th>Trạng thái</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($employees as $employee)
                        <tr class="align-middle">
                            <td class="text-center">
                                <input type="checkbox" name="check1" value="{{ $employee->id }}">
                            </td>
                            <td class="text-center">{{ $employee->id }}</td>
                            <td>{{ $employee->username }}</td>
                            <td>{{ $employee->fullname }}</td>
                            <td>{{ $employee->email }}</td>
                            <td>{{ $employee->phone }}</td>
                            <td>{{ $employee->gender }}</td>
                            <td>{{ $employee->address }}</td>
                            <td>
                                <span class="badge bg-{{ $employee->role == 'admin' ? 'danger' : 'info' }}">
                                    {{ $employee->role == 'superadmin' ? 'Quản trị cấp cao' : 'Nhân viên thường' }}
                                </span>
                            </td>
                            <td class="text-center">
                                <span class="badge {{ $employee->status == 'active' ? 'bg-success' : 'bg-danger' }}">
                                    {{ $employee->status =='active' ? 'Hoạt động' : 'Tạm dừng hoạt động' }}
                                </span>
                            </td>

                            <td class="text-center">
                                <a href="{{ route('employee.show', $employee->id) }}" class="btn btn-primary btn-sm">
                                    <i class="fa fa-eye"></i>
                                </a>

                                <!-- Nút sửa -->
                                @if ($admin->role === 'superadmin' || $admin->id === $employee->id)
                                <a href="{{ route('employee.edit', $employee->id) }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @endif


                                <!-- Nút xóa (chỉ superadmin) -->
                                @if ($admin->role === 'superadmin')
                                <form action="{{ route('employee.delete', $employee->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" type="submit" onclick="return confirm('Bạn có chắc chắn muốn xóa tài khoản nhân viên này?')">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                                @endif
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
