@extends('admin.layout')

@section('content')
    <h2>Thêm Màu</h2>
    <form action="{{ route('admin.color.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Tên màu</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ isset($color) ? $color->name : old('name') }}" required>
        </div>
        <button type="submit" class="btn btn-success">Lưu</button>
    </form>
@endsection
