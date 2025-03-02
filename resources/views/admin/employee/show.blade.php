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

                <!-- Tìm kiếm -->

                <!-- Dropdown sắp xếp -->

                <div class="father">

                    <div class="container">
                        <h1>Employee Details</h1>
                        <table>
                            <tr>
                                <th>Attribute</th>
                                <th>Details</th>
                            </tr>
                            <tr>
                                <td>Username</td>
                                <td>{{ $employee->username }}</td>
                            </tr>
                            <tr>
                                <td>Role</td>
                                <td>{{ $employee->role }}</td>
                            </tr>
                            <tr>
                                <td>Full Name</td>
                                <td>{{ $employee->fullname }}</td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td>{{ $employee->email }}</td>
                            </tr>
                            <tr>
                                <td>Phone</td>
                                <td>{{ $employee->phone }}</td>
                            </tr>
                            <tr>
                                <td>Gender</td>
                                <td>{{ $employee->gender }}</td>
                            </tr>
                            <tr>
                                <td>Date of Birth</td>
                                <td>{{ $employee->date_of_birth }}</td>
                            </tr>
                            <tr>
                                <td>Address</td>
                                <td>{{ $employee->address }}</td>
                            </tr>
                            <tr>
                                <td>Position</td>
                                <td>{{ $employee->position }}</td>
                            </tr>
                            <tr>
                                <td>Create date</td>
                                <td>{{ $employee->created_at }}</td>
                            </tr>
                            <tr>
                                <td>Status</td>
                                <td>{{ $employee->status ? 'Active' : 'Inactive' }}</td>
                            </tr>
                        </table>
                    </div>

                    <div class="container">
                        <h2>Employee Log</h2>
                        <table>
                            <tr>
                                <th>Field</th>
                                <th>Value</th>
                            </tr>
                            <tr>
                                <td>Date/Time</td>
                                <td>{{ $employee->created_at }}</td>
                            </tr>
                            <tr>
                                <td>Contact Method</td>
                                <td>{{ $employee->status ? 'Active' : 'Inactive' }}</td>
                            </tr>
                            <tr>
                                <td>Contact Status</td>
                                <td>{{ $employee->status ? 'Active' : 'Inactive' }}</td>
                            </tr>
                            <tr>
                                <td>Customer Feedback</td>
                                <td>customer_feedback</td>
                            </tr>
                            <tr>
                                <td>Notes</td>
                                <td>notes</td>
                            </tr>
                        </table>

                    </div>
                </div>
                <a href="{{ route('employee.index') }}" class="btn btn-primary">Back to Employee List</a>

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
    .father {
        display: flex;
        justify-content: space-between;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
        max-width: 600px;
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