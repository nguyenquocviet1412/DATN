<?php

namespace App\Http\Controllers\admin;

use App\Helpers\LogHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    public function indexCMT()
    {
        $comment = Comment::all();
        return view('admin.comment.comment', compact('comment'));
    }


    public function hideCMT($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->update(['is_hidden' => !$comment->is_hidden]);

        // Kiểm tra trạng thái của comment
        if ($comment->is_hidden) {
            $message = 'Bình luận đã được ẩn.';
            // Ghi log
            LogHelper::logAction('Ẩn bình luận có ID: ' . $comment->id);
        } else {
            $message = 'Bình luận đã được hiển thị.';
            // Ghi log
            LogHelper::logAction('Hiển thị bình luận có ID: ' . $comment->id);
        }
        return redirect()->route('comment.index')->with('success', $message);
    }

}
