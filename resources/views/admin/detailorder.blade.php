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
                    <div class="row">
                        <div class="col-md-6">
                            <h3>Thông tin khách hàng</h3>
                            <table class="table">
                                <thead>

                                    <tr>
                                        <th>Họ tên: </th>
                                        <td>{{ $orders->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Phone: </th>
                                        <td>{{ $orders->phone }}</td>
                                    </tr>
                                    <tr>
                                        <th>Địa chỉ: </th>
                                        <td>{{ $orders->address }}</td>
                                    </tr>

                                </thead>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h3>Thông tin giao hàng</h3>
                            <table class="table">
                                <thead>

                                    <tr>
                                        <th>Họ tên: </th>
                                        <td>{{ $orders->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Phone: </th>
                                        <td>{{ $orders->phone }}</td>
                                    </tr>
                                    <tr>
                                        <th>Địa chỉ: </th>
                                        <td>{{ $orders->address }}</td>
                                    </tr>

                                </thead>
                            </table>
                        </div>
                    </div>
                    <h3>Thông tin sản phẩm</h3>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Mã sản phẩm</th>
                                <th>Ảnh</th>
                                <th>Tên sản phẩm</th>
                                <th>Số lượng</th>
                                <th>Giá</th>
                                <th>Tổng</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders->details as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->products->id }}</td>
                                    <td>{{ $item->products->name }}</td>
                                    <td>{{ number_format($item->price) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endsection
