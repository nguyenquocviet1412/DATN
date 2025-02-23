<?php 

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller; 
use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    public function indexCMT()
    {
        $comment = Comment::all();
        return view('admin.comment', compact('comment'));
    }

    public function createCMT()
    {
        return view('admin.addcomment');
    }

    public function storeCMT(Request $request)
    {
        $request->validate([
            'id_user' => 'required|exists:users,id',
            'id_product' => 'required|exists:products,id',
            'note' => 'required|string|max:255',
        ]);

        Comment::create($request->all());

        return redirect()->route('comment.index')->with('success', 'Comment created successfully.');
    }

    public function editCMT($id)
    {
        $comment = Comment::findOrFail($id);
        return view('admin.editcomment', compact('comment'));
    }


    public function updateCMT(Request $request, $id)
    {
        $request->validate([
            'id_user' => 'required',
            'id_product' => 'required',
            'note' => 'required',
        ]);

        $comment = Comment::findOrFail($id);
        $comment->update($request->all());

        return redirect()->route('comment.index')->with('success', 'Comment updated successfully.');
    }

    public function destroyCMT($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();

        return redirect()->route('comment.index')->with('success', 'Comment deleted successfully.');
    }

    public function hideCMT($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->update(['note' => '[hidden]']);

        return redirect()->route('comment.index')->with('success', 'Comment hidden successfully.');
    }
}