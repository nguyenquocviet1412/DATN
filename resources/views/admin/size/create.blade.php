@extends('admin.layout')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <script>
        setTimeout(function() {
            document.querySelector('.alert').style.display = 'none';
        }, 3000); // 3 giây sau sẽ tự ẩn
    </script>

    <h2>Thêm Size</h2>
    <form action="{{ route('admin.size.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="size" class="form-label">Kích thước</label>
            <input type="text" name="size" id="size" class="form-control"
                value="{{ isset($size) ? $size->size : old('size') }}" required>
        </div>
        <button type="submit" class="btn btn-success">Lưu</button>
    </form>
@endsection
