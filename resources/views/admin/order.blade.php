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

                    <table class="table table-hover table-bordered" id="sampleTable">
                        <thead>
                            <tr>
                                <th width="10"><input type="checkbox" id="all"></th>
                                <th>ID đơn hàng</th>
                                <th>Khách hàng</th>
                                <th>Đơn hàng</th>
                                <th>Số lượng</th>
                                <th>Tổng tiền</th>
                                <th>Tình trạng</th>
                                <th>Tính năng</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($listOrder as $item)
                                <tr>
                                    <td width="10"><input type="checkbox" name="check1" value="{{ $item->id }}">
                                    </td>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->id_user }}</td>
                                    <td>Ghế ăn gỗ Lucy màu trắng</td>
                                    <td>1</td>
                                    <td>{{ $item->total_price }}</td>
                                    <td>
                                        @if ($item->payment_status == "pending")
                                        <span class="badge bg-secondary">Đang xử lý</span>
                                    @elseif ($item->payment_status == "processing")
                                        <span class="badge bg-info">Đang xử lý</span>
                                    @elseif ($item->payment_status == "shipped")
                                        <span class="badge bg-warning">Đang giao hàng</span>
                                    @elseif ($item->payment_status == "completed")
                                        <span class="badge bg-success">Đã giao</span>
                                    @elseif ($item->payment_status == "failed")
                                        <span class="badge bg-danger">Đã hủy</span>
                                    @endif
                                    </td>
                                    <td class="d-flex ">
                                        <a href="{{ route('order.show', $item->id) }}" class="btn btn-secondary"><i class="fa fa-eye"></i></a>
                                        <a href="{{ route('order.edit', $item->id) }}" class="btn btn-primary btn-sm edit" type="button" id="show-emp">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>


                    <!-- Phân trang -->


                </div>
            </div>
        </div>
    </div>
@endsection
