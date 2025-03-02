@extends('admin.layout')
@section('title', 'Lịch sử nhân viên đã bị xóa | Quản trị Admin')
@section('title2', 'Lịch sử nhân viên đã bị xóa')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <div class="tile-body">
                <h3>Lịch sử nhân viên đã bị xóa</h3>
                <table class="table table-hover table-bordered">
                    <thead>
                        <tr class="text-center">
                            <th>ID</th>
                            <th>Username</th>
                            <th>Fullname</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Gender</th>
                            <th>Address</th>
                            <th>Deleted At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($deletedEmployees as $employee)
                        <tr class="align-middle">
                            <td class="text-center">{{ $employee->id }}</td>
                            <td>{{ $employee->username }}</td>
                            <td>{{ $employee->fullname }}</td>
                            <td>{{ $employee->email }}</td>
                            <td>{{ $employee->phone }}</td>
                            <td>{{ $employee->gender }}</td>
                            <td>{{ $employee->address }}</td>
                            <td>{{ $employee->deleted_at }}</td>
                            <td class="text-center">
                                <form action="{{ route('employee.restore', $employee->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-success btn-sm">
                                        <i class="fas fa-undo"></i> Khôi phục
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <a href="{{ route('employee.index') }}" class="btn btn-primary">Back to Employee List</a>
            </div>
        </div>
    </div>
</div>
@endsection