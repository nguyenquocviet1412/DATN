<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PostController extends Controller
{
    //
    public function index(Request $request)
    {
        //
        //
        $sortBy = $request->input('sort_by', 'id');
        $sortOrder = $request->input('sort_order', 'asc');
        $search = $request->input('search');

        $posts = Post::all();
        return view('admin.post.index', compact('posts', 'sortBy', 'sortOrder', 'search'));
    }
    public function create()
    {
        //
        $posts = Post::all();
        return view('admin.post.create', compact('posts'));
    }
    public function store(Request $request)
    {
        if ($request->isMethod('POST')) {
            # code...
            $params = $request->except('_token');
            Post::create($params);

            return redirect()->route('post.index');
        }
    }
    public function show(string $id)
    {
        $post = Post::findOrFail($id);
        return view('admin.post.show', compact('post'));
    }
    public function edit(string $id)
    {
        //
        $post = Post::findOrFail($id);
        return view('admin.post.edit', compact('post'));
    }
    public function update(Request $request, string $id)
    {
        //
        $request->validate([
            'username' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'required|string|max:255',
            'status' => 'required|boolean',
        ]);
        

        if ($request->isMethod('PUT')) {

            $params = $request->except('_token', '_method');
            $post = Post::query()->findOrFail($id);
            $post->update($params);
            return redirect()->route('products.index')->with('success', 'Cập nhật sản phầm thành công!');
    }
}

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return redirect()->route('post.index')->with('success', 'Post deleted successfully.');
    }
}
