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
    <title>Rates</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .table-responsive {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        .navbar {
            margin-bottom: 20px;
        }
        footer {
            margin-top: 20px;
            padding: 20px 0;
            background-color: #343a40;
            color: #ffffff;
        }
        .btn {
            margin-right: 5px;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Rate Management</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('rate.create') }}">Add Rate</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container">
        <h1 class="mb-4 text-center">Rates</h1>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>User ID</th>
                        <th>Product ID</th>
                        <th>Order Item ID</th>
                        <th>Rating</th>
                        <th>review</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rate as $rate)
                    <tr>
                        <td>{{ $rate->id }}</td>
                        <td>{{ $rate->id_user }}</td>
                        <td>{{ $rate->id_product }}</td>
                        <td>{{ $rate->id_order_item }}</td>
                        <td>{{ $rate->rating }}</td>
                        <td>{{ $rate->review }}</td>
                        <td>{{ $rate->status }}</td>
                        <td>{{ $rate->created_at }}</td>
                        <td>{{ $rate->updated_at }}</td>
                        <td>
                            <a href="{{ route('rate.edit', $rate->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('rate.destroy', $rate->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Footer -->
    <footer class="text-center text-lg-start">
        <div class="container text-center">
            <p>&copy; 2025 Rate Management. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

@endsection