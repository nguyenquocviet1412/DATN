
@extends('admin.layout')
@section('title')
Danh sách bình luận | Quản trị Admin
@endsection
@section('title2')
Danh sách bình luận
@endsection
@section('content')

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comments</title>
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"> --}}
    <style>
        body {
            background-color: #f0f2f5;
        }
        .table-responsive {
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 24px;
            margin-top: 20px;
        }
        .navbar {
            margin-bottom: 30px;
            background: linear-gradient(135deg, #007bff, #0056b3);
        }
        .navbar-brand, .nav-link {
            color: #ffffff !important;
        }
        footer {
            margin-top: 40px;
            padding: 24px 0;
            background-color: #343a40;
            color: #ffffff;
        }
        .btn {
            margin-right: 6px;
        }
        h1 {
            font-weight: bold;
            color: #007bff;
        }
    </style>
</head>
<body>
    <!-- Main Content -->
    <div class="container">
        <h1 class="mb-4 text-center">Comments</h1>
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-primary">
                    <tr>
                        <th>ID</th>
                        <th>User ID</th>
                        <th>Product ID</th>
                        <th>Note</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($comment as $comment)
                    <tr>
                        <td>{{ $comment->id }}</td>
                        <td>{{ $comment->id_user }}</td>
                        <td>{{ $comment->id_product }}</td>
                        <td>{{ $comment->is_hidden ? 'Hidden' : $comment->note }}</td>
                        <td>{{ $comment->created_at }}</td>
                        <td>{{ $comment->updated_at }}</td>
                        <td>

                            <form action="{{ route('comment.destroy', $comment->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')

                            </form>
                            <form action="{{ route('comment.hide', $comment->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm btn-secondary">
                                    {{ $comment->is_hidden ? 'Unhide' : 'Hide' }}
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

@endsection
