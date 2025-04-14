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
                        <input type="text" name="code" class="form-control @error('code') is-invalid @enderror"
                               value="{{ old('code', $voucher->code) }}" required>
                        @error('code')
                            <span class="invalid-feedback d-block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Loại Giảm Giá -->
                    <div class="col-md-6">
                        <label class="form-label">Loại Giảm Giá:</label>
                        <select name="discount_type" class="form-select @error('discount_type') is-invalid @enderror" required>
                            <option value="percentage" {{ $voucher->discount_type == 'percentage' ? 'selected' : '' }}>Phần trăm</option>
                            <option value="fixed" {{ $voucher->discount_type == 'fixed' ? 'selected' : '' }}>Số tiền cố định</option>
                        </select>
                        @error('discount_type')
                            <span class="invalid-feedback d-block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="row mt-3">
                    <!-- Giá Trị Giảm Giá -->
                    <div class="col-md-6">
                        <label class="form-label">Giá Trị Giảm Giá:</label>
                        <input type="number" name="discount_value" class="form-control @error('discount_value') is-invalid @enderror"
                               value="{{ old('discount_value', $voucher->discount_value) }}" required>
                        @error('discount_value')
                            <span class="invalid-feedback d-block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Giá Trị Tối Thiểu -->
                    <div class="col-md-6">
                        <label class="form-label">Giá Trị Đơn Hàng Tối Thiểu:</label>
                        <input type="number" name="min_order_value" class="form-control @error('min_order_value') is-invalid @enderror"
                               value="{{ old('min_order_value', $voucher->min_order_value) }}" required>
                        @error('min_order_value')
                            <span class="invalid-feedback d-block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="row mt-3">
                    {{-- Giá trị tối đa --}}
                    <div class="col-md-6">
                        <label class="form-label">Giá Trị Giảm Tối Đa:</label>
                        <input type="number" name="max_discount" class="form-control @error('max_discount') is-invalid @enderror"
                            value="{{ old('max_discount', $voucher->max_discount) }}" >
                        @error('max_discount')
                            <span class="invalid-feedback d-block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="row mt-3">
                    <!-- Ngày Bắt Đầu -->
                    <div class="col-md-6">
                        <label class="form-label">Ngày Bắt Đầu:</label>
                        <input type="date" name="start_date" class="form-control @error('start_date') is-invalid @enderror"
                               value="{{ old('start_date', $voucher->start_date) }}" >
                        @error('start_date')
                            <span class="invalid-feedback d-block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Ngày Kết Thúc -->
                    <div class="col-md-6">
                        <label class="form-label">Ngày Kết Thúc:</label>
                        <input type="date" name="end_date" class="form-control @error('end_date') is-invalid @enderror"
                               value="{{ old('end_date', $voucher->end_date) }}" >
                        @error('end_date')
                            <span class="invalid-feedback d-block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="row mt-3">
                    <!-- Số Lần Sử Dụng Tối Đa -->
                    <div class="col-md-6">
                        <label class="form-label">Số Lần Sử Dụng Tối Đa:</label>
                        <input type="number" name="usage_limit" class="form-control @error('usage_limit') is-invalid @enderror"
                               value="{{ old('usage_limit', $voucher->usage_limit) }}" required>
                        @error('usage_limit')
                            <span class="invalid-feedback d-block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Số Lượng -->
                    <div class="col-md-6">
                        <label class="form-label">Số Lượng:</label>
                        <input type="number" name="quantity" class="form-control @error('quantity') is-invalid @enderror"
                               value="{{ old('quantity', $voucher->quantity) }}" required>
                        @error('quantity')
                            <span class="invalid-feedback d-block">{{ $message }}</span>
                        @enderror
                    </div>
                    <!-- Trạng Thái -->
                    <div class="col-md-6">
                        <label class="form-label">Trạng Thái:</label>
                        <select name="status" class="form-select @error('status') is-invalid @enderror">
                            <option value="active" {{ $voucher->status == 'active' ? 'selected' : '' }}>Hoạt động</option>
                            <option value="disabled" {{ $voucher->status == 'disabled' ? 'selected' : '' }}>Vô hiệu hóa</option>
                        </select>
                        @error('status')
                            <span class="invalid-feedback d-block">{{ $message }}</span>
                        @enderror
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
