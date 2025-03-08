@extends('admin.layout')

@section('content')
    <h2>Chỉnh sửa Size</h2>
    <form action="{{ route('admin.size.update', $size->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="size" class="form-label">Kích thước</label>
            <input type="text" name="size" id="size" class="form-control" value="{{ $size->size }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Cập nhật</button>
    </form>
@endsection
