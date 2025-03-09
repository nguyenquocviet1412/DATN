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

    <h2>Thêm Màu</h2>
    <form action="{{ route('admin.color.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Tên màu</label>
            <input type="text" name="name" id="name" class="form-control"
                value="{{ isset($color) ? $color->name : old('name') }}" required>
        </div>
        <button type="submit" class="btn btn-success">Lưu</button>
    </form>
@endsection
