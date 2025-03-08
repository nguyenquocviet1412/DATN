@extends('admin.layout')

@section('content')
    <h2>Chỉnh sửa Màu</h2>
    <form action="{{ route('admin.color.update', $color->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Tên màu</label>
            <input type="text" name="name" id="color" class="form-control" value="{{ $color->color }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Cập nhật</button>
    </form>
@endsection
