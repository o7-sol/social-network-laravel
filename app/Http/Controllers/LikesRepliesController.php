<?php

namespace App\Http\Controllers;

use App\Reply;
use App\LikeReply;
use Auth;
use Illuminate\Http\Request;

use App\Http\Requests;

class LikesRepliesController extends Controller
{
    public function like($id)
    {
        $like = new LikeReply();
        $reply = Reply::where('id', $id)->first();
        $like->user_id = Auth::user()->id;
        $like->reply_id = $reply->id;
        $like->like = 1;
        $like->save();
        return redirect()->back();
    }
}
