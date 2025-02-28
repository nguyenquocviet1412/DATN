@extends('admin.layout')

@section('title', 'Danh mục | Quản trị Admin')

@section('title2', 'Danh sách danh mục đã xóa')

@section('content')
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 20px;
        padding: 20px;
    }

    h2 {
        text-align: center;
        color: #333;
        margin-bottom: 20px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        background-color: #fff;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        overflow: hidden;
    }

    th, td {
        padding: 12px;
        text-align: center;
        border-bottom: 1px solid #ddd;
    }

    th {
        background-color: #007bff;
        color: white;
        text-transform: uppercase;
    }

    tr:hover {
        background-color: #f1f1f1;
    }

    a {
        text-decoration: none;
        color: #28a745;
        font-weight: bold;
        padding: 6px 12px;
        border-radius: 5px;
        border: 1px solid #28a745;
        transition: 0.3s;
    }

    a:hover {
        background-color: #28a745;
        color: white;
    }

    button {
        background-color: #dc3545;
        color: white;
        border: none;
        padding: 8px 12px;
        border-radius: 5px;
        cursor: pointer;
        font-size: 14px;
        transition: 0.3s;
    }

    button:hover {
        background-color: #c82333;
    }

    .btn-container {
        display: flex;
        justify-content: center;
        gap: 10px;
    }

    @media (max-width: 768px) {
        table {
            display: block;
            overflow-x: auto;
        }
    }
</style>

<h2>Danh mục đã bị xóa</h2>

<table>
    <tr>
        <th>ID</th>
        <th>Tên danh mục</th>
        <th>Hành động</th>
    </tr>
    @foreach($categories as $category)
        <tr>
            <td>{{ $category->id }}</td>
            <td>{{ $category->name }}</td>
            <td class="btn-container">
                <a href="{{ route('category.restore', $category->id) }}">Khôi phục</a>
                <form action="{{ route('category.force-delete', $category->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Bạn có chắc chắn muốn xóa vĩnh viễn?')">Xóa vĩnh viễn</button>
                </form>
            </td>
        </tr>
    @endforeach
</table>

@endsection
