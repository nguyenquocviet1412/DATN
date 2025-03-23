@extends('master.main')
@section('title', 'Blog')
@section('main')

<main>
    <div class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb-wrap">
                        <nav aria-label="breadcrumb">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home.index') }}"><i class="fa fa-home"></i></a></li>
                                <li class="breadcrumb-item active" aria-current="page">Blog</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="blog-main-wrapper section-padding">
        <div class="container">
            <div class="row">
                <!-- Sidebar -->
                    <div class="col-lg-3 order-2 order-lg-1">
                        <aside class="blog-sidebar-wrapper">
                            <!-- Tìm kiếm -->
                            <div class="blog-sidebar p-3 shadow-sm rounded bg-white">
                                <h5 class="title text-uppercase fw-bold mb-3"><i class="fa fa-search"></i> Tìm kiếm bài viết</h5>
                                <form method="GET" action="{{ route('blogs.index') }}" class="input-group">
                                    <input type="text" name="search" class="form-control rounded-pill px-3 shadow-sm border-light"
                                        placeholder="Nhập từ khóa..." value="{{ request('search') }}">
                                    <button type="submit" class="btn btn-primary ms-2 px-4 rounded-pill shadow-sm">
                                        <i class="fa fa-search"></i> Tìm
                                    </button>
                                </form>
                            </div>

                            <!-- Lọc theo thời gian -->
                            <div class="blog-sidebar p-3 shadow-sm rounded bg-white mt-3">
                                <h5 class="title text-uppercase fw-bold mb-3"><i class="fa fa-calendar"></i> Lọc bài viết</h5>
                                <form method="GET" action="{{ route('blogs.index') }}">
                                    <div class="input-group">
                                        <input type="month" name="month_filter" class="form-control rounded-pill px-3 shadow-sm border-light"
                                            value="{{ request('month_filter') }}">
                                        <button type="submit" class="btn btn-success ms-2 px-4 rounded-pill shadow-sm">
                                            <i class="fa fa-filter"></i> Lọc
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <!-- Bài viết mới nhất -->
                            <div class="blog-sidebar">
                                <h5 class="title">📰 Bài Viết Mới Nhất</h5>
                                <ul class="list-group">
                                    @foreach($latestPosts as $post)
                                        <li class="list-group-item d-flex align-items-center">
                                            <div class="me-2">
                                                <img src="{{ $post->image ? asset('storage/' . $post->image) : asset('images/placeholder.png') }}" class="img-thumbnail" style="width: 50px; height: 50px; object-fit: cover;">
                                            </div>
                                            <div>
                                                <a href="{{ route('blogs.details', $post->id) }}" class="fw-bold">{{ $post->title }}</a>
                                                <span class="text-muted d-block" style="font-size: 0.85rem;">{{ $post->created_at->format('d/m/Y') }}</span>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </aside>
                    </div>

                <!-- Blog Content -->
                <div class="col-lg-9 order-1 order-lg-2">
                    <div class="blog-item-wrapper">
                        @if(request('search') || request('month_filter'))
                            <div class="alert alert-info">
                                <strong>Kết quả tìm kiếm:</strong>
                                @if(request('search'))
                                    Từ khóa: <span class="badge bg-primary">{{ request('search') }}</span>
                                @endif
                                @if(request('month_filter'))
                                    | Tháng: <span class="badge bg-success">{{ date('m/Y', strtotime(request('month_filter'))) }}</span>
                                @endif
                            </div>
                        @endif
                        <div class="row">
                            @if($posts->count() > 0)
                            @foreach ($posts as $post)
                                <div class="col-md-6">
                                    <div class="blog-post-item">
                                        <figure class="blog-thumb">
                                            <a href="{{ route('blogs.details', $post->id) }}">
                                                <img src="{{ $post->image ? asset('storage/' . $post->image) : asset('images/placeholder.png') }}" class="img-fluid" alt="Hình ảnh bài viết">
                                            </a>
                                        </figure>
                                        <div class="blog-content">
                                            <div class="blog-meta">
                                                <p>{{ $post->created_at->format('d/m/Y') }} | {{ $post->employee->username ?? 'Không xác định' }}</p>
                                            </div>
                                            <h4 class="blog-title">
                                                <a href="{{ route('blogs.details', $post->id) }}">{{ $post->title }}</a>
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            @else
                                <!-- Hiển thị thông báo khi không có bài viết -->
                                <div class="col-12 text-center">
                                    <div class="alert alert-warning" role="alert">
                                        <strong>Không tìm thấy bài viết!</strong><br>
                                        @if(request('search') || request('month_filter'))
                                            @if(request('search'))
                                                Không có bài viết nào chứa từ khóa "<strong>{{ request('search') }}</strong>".
                                            @endif
                                            @if(request('month_filter'))
                                                Không có bài viết nào trong tháng "<strong>{{ date('m/Y', strtotime(request('month_filter'))) }}</strong>".
                                            @endif
                                        @else
                                            Không có bài viết nào để hiển thị.
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="pagination-area text-center">
                        {{ $posts->appends(request()->input())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<div class="scroll-top not-visible">
    <i class="fa fa-angle-up"></i>
</div>

<style>
    .blog-post-item {
        border: 1px solid #ddd;
        padding: 15px;
        background-color: #fff;
        height: 100%;
        display: flex;
        flex-direction: column;
        transition: all 0.3s ease;
    }
    .blog-post-item:hover {
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        transform: translateY(-5px);
    }
    .blog-thumb img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        border-radius: 5px;
    }
    .blog-title {
        font-size: 1.25rem;
        margin-top: 10px;
        font-weight: bold;
    }
    .blog-meta {
        font-size: 0.875rem;
        color: #888;
    }
    .list-group-item a {
        font-weight: bold;
        color: #333;
    }
    .list-group-item a:hover {
        color: #007bff;
    }
</style>

<style>
    .blog-sidebar {
        padding: 15px;
        border-radius: 10px;
        background: #ffffff;
        transition: all 0.3s ease-in-out;
    }
    .blog-sidebar:hover {
        transform: translateY(-3px);
        box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.1);
    }
    .blog-sidebar h5 {
        color: #333;
        font-weight: bold;
    }
    .form-control {
        border-radius: 25px;
        border: 1px solid #ddd;
        box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.075);
        transition: 0.3s;
    }
    .form-control:focus {
        border-color: #007bff;
        box-shadow: 0 0 8px rgba(0, 123, 255, 0.5);
    }
    .btn {
        font-weight: bold;
        border-radius: 25px;
        transition: all 0.3s ease-in-out;
    }
    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }
    .btn-primary:hover {
        background-color: #0056b3;
        transform: scale(1.05);
    }
    .btn-success {
        background-color: #28a745;
        border-color: #28a745;
    }
    .btn-success:hover {
        background-color: #218838;
        transform: scale(1.05);
    }
</style>



@endsection
