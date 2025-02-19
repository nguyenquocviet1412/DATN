@extends('admin.layout')

@section('title', 'Danh mục | Quản trị Admin')

@section('title2', 'Thêm danh mục sản phẩm')

@section('content')
<div class="container">
    <h2>Tạo mới danh mục</h2>

    <form action="{{ route('category.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Tên danh mục</label>
            <input type="text" id="name" name="name" placeholder="Nhập tên danh mục" required>
            @error('name')
                <div style="color: red;">{{ $message }}</div>
            @enderror
        </div>
        <div class="actions">
            <button type="submit" class="btn green">Lưu lại</button>
            <a href="{{ route('category.index') }}" class="btn red">Hủy bỏ</a>
        </div>
    </form>
</div>

@if(session('success'))
<script>
    window.onload = function() {
        alert("{{ session('success') }}");
    };
</script>
@endif

<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
    }
    .container {
        width: 50%;
        margin: 20px auto;
        background: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    h2 {
        border-bottom: 2px solid #ffcc00;
        padding-bottom: 10px;
    }
    .form-group {
        margin-bottom: 15px;
    }
    label {
        font-weight: bold;
        margin-bottom: 5px;
        display: block;
    }
    input {
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        width: 100%;
    }
    .actions {
        display: flex;
        justify-content: space-between;
    }
    .btn {
        padding: 10px 15px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 14px;
    }
    .green { background-color: #4CAF50; color: white; }
    .red { background-color: #f44336; color: white; text-decoration: none; text-align: center; }
</style>
@endsection
