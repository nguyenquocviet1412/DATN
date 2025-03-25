<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BlogsController extends Controller
{
    public function index(Request $request)
{
    $sortBy = $request->input('sort_by', 'id');
    $sortOrder = $request->input('sort_order', 'asc');
    $search = $request->input('search');
    $monthFilter = $request->input('month_filter'); // Lọc theo tháng-năm

    $query = Post::query();

    // Tìm kiếm theo tiêu đề bài viết
    if ($search) {
        $query->where('title', 'like', "%$search%");
    }

    // Lọc theo tháng & năm
    if ($monthFilter) {
        $query->whereYear('created_at', '=', date('Y', strtotime($monthFilter)))
              ->whereMonth('created_at', '=', date('m', strtotime($monthFilter)));
    }

    // Phân trang bài viết
    $posts = $query->orderBy($sortBy, $sortOrder)->paginate(10);

    // Lấy 3 bài viết mới nhất
    $latestPosts = Post::orderBy('created_at', 'desc')->limit(3)->get();

    return view('blogs.index', compact('posts', 'latestPosts', 'sortBy', 'sortOrder', 'search', 'monthFilter'));
}

    public function details(string $id)
    {
        $post = Post::findOrFail($id);
        $comments = Comment::where('id_post', $id)->where('is_hidden', false)->get();
        return view('blogs.details', compact('post', 'comments'));
    }
}
