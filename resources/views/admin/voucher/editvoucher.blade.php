@extends('admin.layout')
@section('title', 'Chỉnh sửa sản phẩm | Quản trị Admin')
@section('title2', 'Chỉnh sửa sản phẩm')
@section('content')

<div class="container mt-5">
    <div class="card shadow-lg rounded">
        <div class="card-header bg-primary text-white">
            <h3 class="text-center">Cập Nhật Voucher</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('voucher.update', $voucher->id) }}" method="POST" id="editVoucherForm">
                @csrf
                @method('PUT')

                <div class="row">
                    <!-- Mã Voucher -->
                    <div class="col-md-6">
                        <label class="form-label">Mã Voucher:</label>
                        <input type="text" name="code" class="form-control" value="{{ $voucher->code }}" required>
                    </div>

                    <!-- Loại Giảm Giá -->
                    <div class="col-md-6">
                        <label class="form-label">Loại Giảm Giá:</label>
                        <select name="discount_type" class="form-select" required>
                            <option value="percentage" {{ $voucher->discount_type == 'percentage' ? 'selected' : '' }}>Phần trăm</option>
                            <option value="fixed" {{ $voucher->discount_type == 'fixed' ? 'selected' : '' }}>Số tiền cố định</option>
                        </select>
                    </div>
                </div>

                <div class="row mt-3">
                    <!-- Giá Trị Giảm Giá -->
                    <div class="col-md-6">
                        <label class="form-label">Giá Trị Giảm Giá:</label>
                        <input type="number" name="discount_value" class="form-control" value="{{ $voucher->discount_value }}" required>
                    </div>

                    <!-- Giá Trị Tối Thiểu -->
                    <div class="col-md-6">
                        <label class="form-label">Giá Trị Đơn Hàng Tối Thiểu:</label>
                        <input type="number" name="min_order_value" class="form-control" value="{{ $voucher->min_order_value }}" required>
                    </div>
                </div>

                <div class="row mt-3">
                    <!-- Ngày Bắt Đầu -->
                    <div class="col-md-6">
                        <label class="form-label">Ngày Bắt Đầu:</label>
                        <input type="date" name="start_date" class="form-control" value="{{ $voucher->start_date }}" required>
                    </div>

                    <!-- Ngày Kết Thúc -->
                    <div class="col-md-6">
                        <label class="form-label">Ngày Kết Thúc:</label>
                        <input type="date" name="end_date" class="form-control" value="{{ $voucher->end_date }}" required>
                    </div>
                </div>

                <div class="row mt-3">
                    <!-- Số Lần Sử Dụng Tối Đa -->
                    <div class="col-md-6">
                        <label class="form-label">Số Lần Sử Dụng Tối Đa:</label>
                        <input type="number" name="usage_limit" class="form-control" value="{{ $voucher->usage_limit }}" required>
                    </div>

                    <!-- Trạng Thái -->
                    <div class="col-md-6">
                        <label class="form-label">Trạng Thái:</label>
                        <select name="status" class="form-select">
                            <option value="1" {{ $voucher->status == 1 ? 'selected' : '' }}>Hoạt động</option>
                            <option value="0" {{ $voucher->status == 0 ? 'selected' : '' }}>Ngừng hoạt động</option>
                        </select>
                    </div>
                </div>

                <div class="d-flex justify-content-center mt-4">
                    <button type="submit" class="btn btn-success btn-lg me-2">
                        <i class="fas fa-save"></i> Lưu
                    </button>
                    <a href="{{ route('voucher.index') }}" class="btn btn-secondary btn-lg">
                        <i class="fas fa-arrow-left"></i> Quay lại
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Hiệu ứng jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Hiệu ứng hiển thị form mượt mà
        $(".card").hide().fadeIn(500);

        // Thêm hiệu ứng khi submit form
        $("#editVoucherForm").on("submit", function() {
            $(this).find("button[type=submit]").prop("disabled", true).html('<i class="fas fa-spinner fa-spin"></i> Đang lưu...');
        });
    });
</script>



@endsection
