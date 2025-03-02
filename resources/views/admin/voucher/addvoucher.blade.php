@extends('admin.layout')
@section('title')
Thêm voucher | Quản trị Admin
@endsection
@section('title2')
Thêm voucher
@endsection
@section('content')

<div class="row">
    <div class="col-md-12">
      <div class="tile">
        <h3 class="tile-title">Tạo mới Voucher</h3>
        <div class="tile-body">
            <form class="row" action="{{route('voucher.store')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group col-md-4">
                    <label class="control-label">Mã Voucher</label>
                    <input class="form-control @error('code') is-invalid @enderror" name="code" type="text" required>
                    @error('code')
                        <span class="invalid-feedback d-block">{{$message}}</span>
                    @enderror
                </div>
                <div class="form-group col-md-4">
                    <label class="control-label">Loại Giảm Giá</label>
                    <select name="discount_type" class="form-control @error('discount_type') is-invalid @enderror" required>
                        <option value="percentage">Phần trăm</option>
                        <option value="fixed">Số tiền cố định</option>
                    </select>
                    @error('discount_type')
                        <span class="invalid-feedback d-block">{{$message}}</span>
                    @enderror
                </div>
                <div class="form-group col-md-4">
                    <label class="control-label">Giá Trị Giảm Giá</label>
                    <input class="form-control @error('discount_value') is-invalid @enderror" name="discount_value" type="number" required>
                    @error('discount_value')
                        <span class="invalid-feedback d-block">{{$message}}</span>
                    @enderror
                </div>
                <div class="form-group col-md-4">
                    <label class="control-label">Giá Trị Đơn Hàng Tối Thiểu</label>
                    <input class="form-control @error('min_order_value') is-invalid @enderror" name="min_order_value" type="number" required>
                    @error('min_order_value')
                        <span class="invalid-feedback d-block">{{$message}}</span>
                    @enderror
                </div>

                <div class="form-group col-md-4">
                    <label class="control-label">Giá Trị Giảm Tối Đa</label>
                    <input class="form-control @error('max_discount') is-invalid @enderror" name="max_discount" type="number">
                    @error('max_discount')
                        <span class="invalid-feedback d-block">{{$message}}</span>
                    @enderror
                </div>
                <div class="form-group col-md-4">
                    <label class="control-label">Số lượng</label>
                    <input class="form-control @error('quantity') is-invalid @enderror" name="quantity" type="number" required>
                    @error('quantity')
                        <span class="invalid-feedback d-block">{{$message}}</span>
                    @enderror
                </div>
                <div class="form-group col-md-4">
                    <label class="control-label">Ngày Bắt Đầu</label>
                    <input class="form-control @error('start_date') is-invalid @enderror" name="start_date" type="date" required>
                    @error('start_date')
                        <span class="invalid-feedback d-block">{{$message}}</span>
                    @enderror
                </div>
                <div class="form-group col-md-4">
                    <label class="control-label">Ngày Kết Thúc</label>
                    <input class="form-control @error('end_date') is-invalid @enderror" name="end_date" type="date" required>
                    @error('end_date')
                        <span class="invalid-feedback d-block">{{$message}}</span>
                    @enderror
                </div>
                <div class="form-group col-md-4">
                    <label class="control-label">Trạng Thái</label>
                    <select name="status" class="form-control @error('status') is-invalid @enderror">
                        <option value="1">Hoạt động</option>
                        <option value="0">Ngừng hoạt động</option>
                    </select>
                    @error('status')
                        <span class="invalid-feedback d-block">{{$message}}</span>
                    @enderror
                </div>
                <div class="form-group col-md-12">
                    <button class="btn btn-save" type="submit">Lưu lại</button>
                    <a class="btn btn-cancel" href="{{route('voucher.index')}}">Hủy bỏ</a>
                </div>
            </form>
        </div>
      </div>
</div>
@endsection
