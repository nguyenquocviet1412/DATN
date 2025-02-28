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
    <title>Edit Rate</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .form-container {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-top: 50px;
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
                        <a class="nav-link active" aria-current="page" href="{{ route('rate.index') }}">Home</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container">
        <div class="form-container">
            <h1 class="mb-4 text-center">Edit Rate</h1>
            <form action="{{ route('rate.update', $rate->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="id_user" class="form-label">User ID</label>
                    <input type="text" class="form-control" id="id_user" name="id_user" value="{{ $rate->id_user }} "required>
                </div>
                <div class="mb-3">
                    <label for="id_product" class="form-label">Product ID</label>
                    <input type="text" class="form-control" id="id_product" name="id_product" value="{{ $rate->id_product }}" required>
                </div>
                <div class="mb-3">
                    <label for="id_order_item" class="form-label">Order Item ID</label>
                    <input type="text" class="form-control" id="id_order_item" name="id_order_item" value="{{ $rate->id_order_item }}" required>
                </div>
                <div class="mb-3">
                    <label for="rating" class="form-label">Rating</label>
                    <input type="number" class="form-control" id="rating" name="rating" value="{{ $rate->rating }}" min="1" max="5" required>
                </div>
                <div class="mb-3">
                    <label for="review" class="form-label">review</label>
                    <textarea class="form-control" id="review" name="review" value="{{ $rate->review}}" rows="3" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status" required>
                        <option value="approved" {{ $rate->status == 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="pending" {{ $rate->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="rejected" {{ $rate->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
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