<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\CommentLike;
use App\Comment;
use Auth;

class CommentsLikesController extends Controller
{
    public function like($id)
    {
        $like = new CommentLike();
        $comment = Comment::where('id', $id)->first();
        $like->user_id = Auth::user()->id;
        $like->comment_id = $comment->id;
        $like->like = 1;
        $like->save();
        return redirect()->back();
    }
}
