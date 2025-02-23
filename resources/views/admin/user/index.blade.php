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
                    </div>

                    <div class="col-md-6">
                        <form action="{{ route('user.index') }}" method="GET">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control"
                                    placeholder="Tìm kiếm sản phẩm..." value="{{ request('search') }}">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search"></i> Tìm kiếm
                                </button>
                            </div>
                        </form>
                    </div>
                </div>


                <!-- Tím kiếm  -->



                <!-- Dropdown sắp xếp -->
                <div class="mb-3">
                    <form method="GET" action="{{ route('user.index') }}">
                        <label for="sort_by">Sắp xếp theo:</label>
                        <select name="sort_by" id="sort_by" class="form-control d-inline-block w-auto">
                            <option value="id" {{ $sortBy == 'id' ? 'selected' : '' }}>ID</option>
                            <option value="status" {{ $sortBy == 'status' ? 'selected' : '' }}>Tình trạng</option>
                        </select>

                        <select name="sort_order" id="sort_order" class="form-control d-inline-block w-auto">
                            <option value="asc" {{ $sortOrder == 'asc' ? 'selected' : '' }}>Tăng dần</option>
                            <option value="desc" {{ $sortOrder == 'desc' ? 'selected' : '' }}>Giảm dần</option>
                        </select>

                        <button type="submit" class="btn btn-primary">Sắp xếp</button>
                    </form>
                </div>

                <table class="table table-hover table-bordered">
                    <thead>
                        <tr class="text-center">
                            <th><input type="checkbox" id="select-all"></th>
                            <th>ID</th>
                            <th>Fullname</th>
                            <th>Emaill</th>
                            <th>Phone</th>
                            <th>Address</th>
                            <th>Gender</th>
                            <th>Status</th>
                            <th>Action</th>
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
                            <td class="text-center">{{ $user->gender }}</td>
                            <td class="text-center">
                                <span class="badge {{ $user->status ? 'bg-success' : 'bg-danger' }}">
                                    {{ $user->status ? 'Hoạt động' : 'Hết hoạt động' }}
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
                                    <button class="btn btn-danger btn-sm" type="submit" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')">
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