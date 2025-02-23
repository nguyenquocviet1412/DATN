@extends('admin.layout')
@section('title', 'Danh sách đơn hàng | Quản trị Admin')
@section('title2', 'Danh sách đơn hàng')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">

                    {{-- thông báo thêm thành công --}}
                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                    @if (session('success'))
                        <script>
                            Swal.fire({
                                title: 'Thành công!',
                                text: '{{ session('success') }}',
                                icon: 'success',
                                showConfirmButton: false,
                                timer: 4000,
                                backdrop: true // Làm tối nền
                            });
                        </script>
                    @endif


                    {{-- Thông báo lỗi --}}
                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                    @if (session('error'))
                        <script>
                            Swal.fire({
                                title: 'Lỗi!',
                                text: '{{ session('error') }}',
                                icon: 'error',
                                showConfirmButton: true, // Hiển thị nút đóng
                                confirmButtonText: 'Đóng', // Nội dung nút đóng
                                backdrop: true // Làm tối nền
                            });
                        </script>
                    @endif


                    <div class="row element-button">
                        <div class="col-sm-6">
                            <a class="btn btn-add btn-sm" href="{{ route('order.create') }}" title="Thêm">
                                <i class="fas fa-plus"></i> Tạo mới đơn hàng
                            </a>
                        </div>

                        <div class="col-md-6">
                            <form action="{{ route('order.index') }}" method="GET">
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control"
                                        placeholder="Tìm kiếm đơn hàng..." value="{{ request('search') }}">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-search"></i> Tìm kiếm
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>


                    <!-- Tím kiếm  -->

                    <div class="card-body">
                        <table id="datatablesSimple">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Tên</th>
                                    <th>Email</th>
                                    <th>Điện thoại</th>
                                    <th>Trạng thái</th>
                                    <th>Ngày mua</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Tên</th>
                                    <th>Email</th>
                                    <th>Điện thoại</th>
                                    <th>Trạng thái</th>
                                    <th>Ngày mua</th>
                                    <th>Hành động</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach ($listOrd as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->email }}</td>
                                        <td>{{ $item->phone }}</td>
                                        <td
                                            class="badge rounded-lg rounded-pill py-3 px-4 mb-0 border-0 text-capitalize fs-12">
                                            @if ($item->status == 0)
                                                <span class="badge rounded-lg rounded-pill alert alert-warning">Chưa xác nhận</span>
                                            @elseif ($item->status == 1)
                                                <span class="badge rounded-lg rounded-pill alert alert-success">Đã xác nhận</span>
                                            @elseif ($item->status == 2)
                                                <span class="badge rounded-lg rounded-pill alert alert-success">Đã thanh toán</span>
                                            @else
                                                <span class="badge rounded-lg rounded-pill alert alert-danger">Đã Hủy</span>
                                            @endif
                                        </td>
                                        <td>{{ $item->created_at->format('d/m/Y') }}</td>
                                        <td>
                                            <a href="{{ route('order.restore', $item->id) }}" class="btn btn-warning"><i class="fa fa-trash-restore"></i></a>
                                    <a href="{{ route('order.forceDelete', $item->id) }}" onclick="return confirm('Bạn có muốn xóa không?')" class="btn btn-danger"><i class="fa fa-trash"></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <a href="{{ route('order.index') }}" class="btn btn-primary">Trở lại</a>
                    </div>

                    <!-- Phân trang -->


                </div>
            </div>
        </div>
    </div>
@endsection
