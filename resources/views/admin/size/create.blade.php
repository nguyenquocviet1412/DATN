@extends('admin.layout')

@section('content')
    <h2>Thêm Size</h2>
    <form action="{{ route('admin.size.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="size" class="form-label">Kích thước</label>
            <input type="text" name="size" id="size" class="form-control" value="{{ isset($size) ? $size->size : old('size') }}" required>
        </div>
        <button type="submit" class="btn btn-success">Lưu</button>
    </form>

@endsection
