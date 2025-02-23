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
                <!-- Tím kiếm  -->



                <!-- Dropdown sắp xếp -->

                <div class="container">
                    <h1>Employee Details</h1>
                    <div>
                        <strong>Username:</strong> {{ $employee->username }}
                    </div>
                    <div>
                        <strong>Password:</strong> {{ $employee->password }}
                    </div>
                    <div>
                        <strong>Role:</strong> {{ $employee->role }}
                    </div>
                    <div>
                        <strong>Full Name:</strong> {{ $employee->fullname }}
                    </div>
                    <div>
                        <strong>Email:</strong> {{ $employee->email }}
                    </div>
                    <div>
                        <strong>Phone:</strong> {{ $employee->phone }}
                    </div>
                    <div>
                        <strong>Gender:</strong> {{ $employee->gender }}
                    </div>
                    <div>
                        <strong>Date of Birth:</strong> {{ $employee->date_of_birth }}
                    </div>
                    <div>
                        <strong>Address:</strong> {{ $employee->address }}
                    </div>
                    <div>
                        <strong>Position:</strong> {{ $employee->position }}
                    </div>
                    <div>
                        <strong>Salary:</strong> {{ $employee->salary }}
                    </div>
                    <div>
                        <strong>Create date:</strong> {{ $employee->created_at}}
                    </div>

                    <div>
                        <strong>Status:</strong> {{ $employee->status ? 'Active' : 'Inactive' }}
                    </div>
                    <a href="{{ route('employee.index') }}" class="btn btn-primary">Back to Employee List</a>
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