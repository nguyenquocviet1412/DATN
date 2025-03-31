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

            <!-- filepath: c:\laragon\www\DATN\resources\views\blogs\details.blade.php -->
<!-- Hiển thị bình luận -->
<div class="card mt-5 border-0 shadow-sm" style="border-radius: 12px;">
    <div class="card-header" style="background-color: #ffffff; color: #000000; border-radius: 12px 12px 0 0; border: 1px solid #dcdcdc;">
        <h3 class="mb-0">Bình luận</h3>
    </div>
    <div class="card-body" style="background-color: #ffffff; color: #000000; border: 1px solid #dcdcdc; border-top: none; border-radius: 0 0 12px 12px;">
        @if ($comments->isEmpty())
            <p class="text-muted">Chưa có bình luận nào. Hãy là người đầu tiên bình luận!</p>
        @else
            <ul class="list-group">
                @foreach ($comments as $comment)
                    <li class="list-group-item" style="background-color: #ffffff; color: #000000; border: 1px solid #dcdcdc; border-radius: 8px; margin-bottom: 10px;">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="mb-1 font-weight-bold">{{ $comment->user->fullname }}</h6>
                                <small class="text-muted">{{ $comment->created_at->format('d/m/Y H:i') }}</small>
                            </div>
                        </div>
                        <p class="mt-2 mb-0">{{ $comment->note }}</p>
                    </li>
                @endforeach
            </ul>
        @endif

        <!-- Nút mở slide thêm bình luận -->
        <div class="text-end mt-4">
            <button class="btn btn-primary" data-bs-toggle="collapse" data-bs-target="#addCommentForm" aria-expanded="false" aria-controls="addCommentForm" style="border-radius: 8px;">
                Thêm bình luận
            </button>
        </div>

        <!-- Slide thêm bình luận -->
        <div class="collapse mt-3" id="addCommentForm">
            <div class="card card-body" style="border-radius: 12px; background-color: #f8f9fa;">
                @auth
                    <form action="{{ route('blogs.addComment', $post->id) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <textarea name="note" class="form-control" rows="4" placeholder="Nhập bình luận của bạn..." style="background-color: #ffffff; color: #000000; border: 1px solid #dcdcdc; border-radius: 8px;"></textarea>
                            @error('note')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <button type="submit" class="btn mt-3" style="background-color: #6c757d; color: #ffffff; border-radius: 8px;">Gửi bình luận</button>
                    </form>
                @else
                    <p>Vui lòng <a href="{{ route('login') }}" style="color: #6c757d; font-weight: bold;">đăng nhập</a> để bình luận.</p>
                @endauth
            </div>
        </div>
    </div>
</div>

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