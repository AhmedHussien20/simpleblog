<?php

namespace App\Http\Controllers\Comment;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment;
class commentController extends Controller
{
    public function insert(Request $request)
    {
        $request->validate([
            'comment' => 'required|max:500',
        ]);

        $user = Auth::user();

        $post_id = $request->input('post_id');
        $comment = new Comment();
        $comment->comment = $request->input('comment');
        $comment->created_by = $user->id;
        $comment->post_id =  $post_id;
        $comment->save();
        return redirect()->back()->with('success', 'Comment added successfully!');
    }
}
