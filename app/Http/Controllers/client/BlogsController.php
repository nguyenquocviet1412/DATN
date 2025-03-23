<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BlogsController extends Controller
{
    //
    public function index(Request $request)
    {
        //
        //
        $sortBy = $request->input('sort_by', 'id');
        $sortOrder = $request->input('sort_order', 'asc');
        $search = $request->input('search');

        $query = Post::query();

        if ($search) {
            $query->where('title', 'like', "%$search%");
        }

        $posts = $query->orderBy($sortBy, $sortOrder)->paginate(10);
        
        return view('blogs.index', compact('posts', 'sortBy', 'sortOrder', 'search'));
    }
    public function details(string $id)
    {
        //
        //
        $post = Post::findOrFail($id);
        return view('blogs.details',compact('post'));
    }
}
