<!-- filepath: c:\laragon\www\DATN\resources\views\blogs\details.blade.php -->
@extends('master.main')
@section('title', 'Trang chủ')
@section('main')
<style>
    .blog-header {
        text-align: center;
        margin-bottom: 20px;
    }
    .blog-image img {
        width: 100%;
        max-height: 450px;
        object-fit: cover;
        border-radius: 12px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .blog-meta {
        font-size: 14px;
        color: #6c757d;
        margin-top: 10px;
    }
    .blog-content {
        font-size: 18px;
        line-height: 1.8;
        text-align: justify;
    }
    .author-info {
        font-weight: bold;
        color: #007bff;
    }
    .related-posts {
        margin-top: 50px;
    }
    .footer {
        background: #f8f9fa;
        padding: 40px 0;
        text-align: center;
        margin-top: 60px;
    }
    .scroll-top {
        position: fixed;
        bottom: 20px;
        right: 20px;
        display: none;
        background: #007bff;
        color: white;
        border: none;
        padding: 12px 15px;
        border-radius: 50%;
        cursor: pointer;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
    }
    .scroll-top:hover {
        background: #0056b3;
    }
</style>

<main>
    <!-- breadcrumb area start -->
    <div class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb-wrap">
                        <nav aria-label="breadcrumb">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('home.index')}}"><i class="fa fa-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="{{route('blogs.index')}}">blog</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ $post->title }}</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb area end -->

    <!-- Blog Details Section Start -->
    <div class="container mt-4">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="blog-header">
                    <h1>{{ $post->title }}</h1>
                    <div class="blog-meta">
                        <span>Ngày đăng: {{ $post->created_at->format('d/m/Y') }}</span> |
                        <span class="author-info">{{ $post->employee->username ?? 'Không xác định' }}</span>
                    </div>
                </div>

                <div class="blog-image">
                    <img src="{{ asset('storage/' . $post->image) }}" alt="Hình ảnh bài viết">
                </div>

                <div class="blog-content mt-4">
                    <p>{{ $post->content }}</p>
                </div>

                <!-- Hiển thị bình luận -->
                <div class="card mt-5">
                    <div class="card-header">
                        <h3>Bình luận</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Người dùng</th>
                                    <th>Nội dung</th>
                                    <th>Ngày bình luận</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($comments as $comment)
                                    <tr>
                                        <td>{{ $comment->user->fullname }}</td>
                                        <td>{{ $comment->note }}</td>
                                        <td>{{ $comment->created_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
              
<div class="card mt-5">
    <div class="card-header">
        <h3>Thêm bình luận</h3>
    </div>
    <div class="card-body">
        @auth
            <form action="{{ route('blogs.addComment', $post->id) }}" method="POST">
                @csrf
                <div class="form-group">
                    <textarea name="note" class="form-control" rows="4" placeholder="Nhập bình luận của bạn..."></textarea>
                    @error('note')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary mt-2">Gửi bình luận</button>
            </form>
        @else
            <p>Vui lòng <a href="{{ route('login') }}">đăng nhập</a> để bình luận.</p>
        @endauth
    </div>
</div>
                <!-- Kết thúc hiển thị bình luận -->
            </div>
        </div>
    </div>
    <!-- Blog Details Section End -->
</main>

<!-- Scroll to Top Button -->
<button class="btn btn-primary position-fixed bottom-0 end-0 m-3 shadow rounded-circle" id="scrollTopBtn">
    <i class="fa fa-chevron-up"></i>
</button>
<script>
    // Hiển thị hoặc ẩn nút khi cuộn trang
    window.addEventListener('scroll', function () {
        let scrollTopBtn = document.getElementById('scrollTopBtn');
        if (window.scrollY > 200) {
            scrollTopBtn.style.display = 'block';
        } else {
            scrollTopBtn.style.display = 'none';
        }
    });

    document.getElementById('scrollTopBtn').addEventListener('click', function () {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
</script>

@endsection