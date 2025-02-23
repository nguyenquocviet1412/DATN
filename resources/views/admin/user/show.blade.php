@extends('admin.layout')
@section('title', 'Danh sách Nhân viên | Quản trị Admin')
@section('title2', 'Danh sách Nhân viên')

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

                <!-- Tím kiếm  -->



                <!-- Dropdown sắp xếp -->

                <div class="container">
                    <h1>User Details</h1>
                    <div>
                        <strong>Password:</strong> {{ $user->password }}
                    </div>
                    <div>
                        <strong>Role:</strong> {{ $user->role }}
                    </div>
                    <div>
                        <strong>Full Name:</strong> {{ $user->fullname }}
                    </div>
                    <div>
                        <strong>Email:</strong> {{ $user->email }}
                    </div>
                    <div>
                        <strong>Phone:</strong> {{ $user->phone }}
                    </div>
                    <div>
                        <strong>Address:</strong> {{ $user->address }}
                    </div>
                    <div>
                        <strong>Create date:</strong> {{ $user->created_at }}
                    </div>
                    <div>
                        <strong>Status:</strong> {{ $user->status ? 'Active' : 'Inactive' }}
                    </div>
                    <a href="{{ route('user.index') }}" class="btn btn-primary">Back to User List</a>
                </div>

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