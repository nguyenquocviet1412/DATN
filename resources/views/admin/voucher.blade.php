@extends('admin.layout')
@section('title')
Danh sách Voucher | Quản trị Admin
@endsection
@section('title2')
Danh sách Voucher
@endsection
@section('content')

<div class=" mt-4">
    <h2 class="mb-4"><i class="fas fa-ticket-alt"></i> Quản Lý Voucher</h2>

    <!-- Nút Thêm Mới Voucher -->
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addVoucherModal">
        <i class="fas fa-plus"></i> Thêm Voucher
    </button>

    <!-- Bảng Danh Sách Voucher -->
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Mã</th>
                        <th>Giảm Giá</th>
                        <th>Hạn Sử Dụng</th>
                        <th>Trạng Thái</th>
                        <th>Hành Động</th>
                    </tr>
                </thead>
                {{-- <tbody>
                    @foreach($vouchers as $key => $voucher)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $voucher->code }}</td>
                        <td>{{ $voucher->discount }}%</td>
                        <td>{{ $voucher->expiry_date }}</td>
                        <td>
                            @if($voucher->status)
                                <span class="badge bg-success">Còn Hạn</span>
                            @else
                                <span class="badge bg-danger">Hết Hạn</span>
                            @endif
                        </td>
                        <td>
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editVoucherModal{{ $voucher->id }}">
                                <i class="fas fa-edit"></i> Sửa
                            </button>
                            <form action="{{ route('admin.voucher.delete', $voucher->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn xóa?')">
                                    <i class="fas fa-trash"></i> Xóa
                                </button>
                            </form>
                        </td>
                    </tr>

                    <!-- Modal Chỉnh Sửa Voucher -->
                    <div class="modal fade" id="editVoucherModal{{ $voucher->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <form action="{{ route('admin.voucher.update', $voucher->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Chỉnh Sửa Voucher</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label">Mã Voucher</label>
                                            <input type="text" name="code" value="{{ $voucher->code }}" class="form-control">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Giảm Giá (%)</label>
                                            <input type="number" name="discount" value="{{ $voucher->discount }}" class="form-control">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Hạn Sử Dụng</label>
                                            <input type="date" name="expiry_date" value="{{ $voucher->expiry_date }}" class="form-control">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Trạng Thái</label>
                                            <select name="status" class="form-select">
                                                <option value="1" {{ $voucher->status ? 'selected' : '' }}>Còn Hạn</option>
                                                <option value="0" {{ !$voucher->status ? 'selected' : '' }}>Hết Hạn</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-success">Lưu</button>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </tbody> --}}
            </table>
        </div>
    </div>
</div>

<!-- Modal Thêm Voucher -->
<div class="modal fade" id="addVoucherModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('voucher.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Thêm Voucher</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Mã Voucher</label>
                        <input type="text" name="code" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Giảm Giá (%)</label>
                        <input type="number" name="discount" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Hạn Sử Dụng</label>
                        <input type="date" name="expiry_date" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Trạng Thái</label>
                        <select name="status" class="form-select">
                            <option value="1">Còn Hạn</option>
                            <option value="0">Hết Hạn</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Thêm</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                </div>
            </div>
        </form>
    </div>
</div>


@endsection
