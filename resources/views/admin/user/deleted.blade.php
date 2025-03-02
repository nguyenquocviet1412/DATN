@extends('admin.layout')
@section('title', 'Lịch sử người dùng đã bị xóa | Quản trị Admin')
@section('title2', 'Lịch sử người dùng đã bị xóa')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <div class="tile-body">
                <h3>Lịch sử người dùng đã bị xóa</h3>
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
                        @foreach ($deletedUsers as $user)
                        <tr class="align-middle">
                            <td class="text-center">{{ $user->id }}</td>
                            <td>{{ $user->username }}</td>
                            <td>{{ $user->fullname }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->phone }}</td>
                            <td>{{ $user->gender }}</td>
                            <td>{{ $user->address }}</td>
                            <td>{{ $user->deleted_at }}</td>
                            <td class="text-center">
                                <form action="{{ route('user.restore', $user->id) }}" method="POST" style="display:inline;">
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
                <a href="{{ route('user.index') }}" class="btn btn-primary">Back to User List</a>
            </div>
        </div>
    </div>
</div>
@endsection