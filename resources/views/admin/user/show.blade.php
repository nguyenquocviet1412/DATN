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
                    <table>
                        <tr>
                            <th>Attribute</th>
                            <th>Details</th>
                        </tr>
                        <tr>
                            <td>Role</td>
                            <td>{{ $user->role }}</td>
                        </tr>
                        <tr>
                            <td>Full Name</td>
                            <td>{{ $user->fullname }}</td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td>{{ $user->email }}</td>
                        </tr>
                        <tr>
                            <td>Phone</td>
                            <td>{{ $user->phone }}</td>
                        </tr>
                        <tr>
                            <td>Address</td>
                            <td>{{ $user->address }}</td>
                        </tr>
                        <tr>
                            <td>Create date</td>
                            <td>{{ $user->created_at }}</td>
                        </tr>
                        <tr>
                            <td>Status</td>
                            <td>{{ $user->status ? 'Active' : 'Inactive' }}</td>
                        </tr>
                    </table>
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

<style>
    .container {
        margin: 20px auto;
        padding: 20px;
        max-width: 600px;
        background-color: #f9f9f9;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    th,
    td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    th {
        background-color: #f2f2f2;
        font-weight: bold;
    }

    tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    .btn-primary {
        display: inline-block;
        padding: 10px 20px;
        color: #fff;
        background-color: #007bff;
        text-align: center;
        text-decoration: none;
        border-radius: 4px;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }
</style>
@endsection