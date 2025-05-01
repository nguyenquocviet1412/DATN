<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Hiển thị danh sách bài viết
     */
    public function index(Request $request)
    {
        $sortBy = $request->input('sort_by', 'id');
        $sortOrder = $request->input('sort_order', 'asc');
        $search = $request->input('search');

        $query = Post::query();

        if ($search) {
            $query->where('title', 'like', "%$search%");
        }

        $posts = $query->orderBy($sortBy, $sortOrder)->get();
        return view('admin.post.index', compact('posts', 'sortBy', 'sortOrder', 'search'));
    }

    /**
     * Hiển thị form tạo bài viết
     */
    public function create()
    {
        return view('admin.post.create');
    }

    /**
     * Lưu bài viết mới vào database
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
            'image'   => 'nullable|image|max:2048',
            'status'  => 'required|in:0,1', // 0: Nháp, 1: Công khai
        ]);

        try {
            $data = $request->except('_token');
            $data['id_employee'] = Auth::id();

            // Xử lý ảnh nếu có tải lên
            if ($request->hasFile('image')) {
                $data['image'] = $request->file('image')->store('posts');
            }

            Post::create($data);

            return redirect()->route('post.index')->with('success', 'Bài viết đã được tạo thành công!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Có lỗi xảy ra, vui lòng thử lại!'])->withInput();
        }
    }

    /**
     * Hiển thị thông tin chi tiết của một bài viết
     */
    public function show(string $id)
    {
        $post = Post::findOrFail($id);
        return view('admin.post.show', compact('post'));
    }

     /**
     * Hiển thị form chỉnh sửa bài viết
     */
    public function edit(string $id)
    {
        $post = Post::findOrFail($id);
        return view('admin.post.edit', compact('post'));
    }

    /**
     * Cập nhật bài viết
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
            'image'   => 'nullable|image|max:2048',
            'status'  => 'required|in:draft,published',
        ], [
            'title.required'   => 'Vui lòng nhập tiêu đề bài viết.',
            'title.max'        => 'Tiêu đề không được vượt quá 255 ký tự.',
            'content.required' => 'Vui lòng nhập nội dung bài viết.',
            'image.image'      => 'Tệp tải lên phải là hình ảnh.',
            'image.max'        => 'Ảnh không được lớn hơn 2MB.',
            'status.required'  => 'Vui lòng chọn trạng thái bài viết.',
            'status.in'        => 'Trạng thái không hợp lệ.',
        ]);

        try {
            $post = Post::findOrFail($id);
            $data = $request->except('_token', '_method');

            // Xử lý ảnh nếu có thay đổi
            if ($request->hasFile('image')) {
                if ($post->image) {
                    Storage::delete('public/' . $post->image);
                }
                $data['image'] = $request->file('image')->store('posts', 'public');
            }

            $post->update($data);

            return redirect()->back()->with('success', 'Cập nhật bài viết thành công!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Có lỗi xảy ra khi cập nhật: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Xóa bài viết
     */
    public function delete($id)
    {
        try {
            $post = Post::findOrFail($id);

            // Xóa ảnh nếu có
            if ($post->image) {
                Storage::delete($post->image);
            }

            $post->delete();
            return redirect()->route('post.index')->with('success', 'Bài viết đã bị xóa.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Có lỗi xảy ra khi xóa!']);
        }
    }
}
