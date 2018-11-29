<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Comment;
use App\Post;
use App\Reply;
use Auth;
use Vinkla\Pusher\PusherManager;

class CommentsController extends Controller
{
    protected $pusher;

    public function __construct(PusherManager $pusher)
    {
      $this->pusher = $pusher;
    }

    public function comment(Request $request, $id){
        $this->validate($request, [
            'body' => 'required|min:1'
        ]);

        $comment = new Comment();
        $post = Post::where('id', $id)->first();
        $comment->body = $request->input('body');
        $comment->post_id = $post->id;
        $comment->user_id = Auth::user()->id;
        $comment->save();

        $message = '<img style="height: 30px" src="/' . $comment->user->image . '">'.$comment->user->name.' pakomentavo '. $comment->post->user->name . '<a href="irasas/' . $comment->post_id . '"> įrašą</a>';
        $this->pusher->trigger('posts_channel', 'post_event', ['message' => $message]);

        return redirect()->back();
    }

    public function reply(Request $request, $id){
        $this->validate($request, [
             'reply' => 'required|min:1'
            ]);

        $reply = new Reply();
        $comment = Comment::where('id', $id)->first();
        $reply->reply = $request->input('reply');
        $reply->comment_id = $comment->id;
        $reply->user_id = Auth::user()->id;
        $reply->save();

        $message = '<img style="height: 30px" src="/' . $reply->user->image . '">'.$reply->user->name.' atsakė į '.$comment->user->name.' komentarą <br><br>'
        .$comment->post->user->name.'<a href="irasas/' . $comment->post_id . '"> įraše</a>';
        $this->pusher->trigger('posts_channel', 'post_event', ['message' => $message]);

        return redirect()->back();
    }

    public function deleteReply($id)
    {
        $reply = Reply::where('id', $id)->first();
        if(Auth::user()->id == $reply->user_id){
            $reply->delete();
            return redirect()->back();
        }
        else {
            return redirect()->back();
        }
    }

    public function deleteComment($id)
    {
        $comment = Comment::where('id', $id)->first();
        if(Auth::user()->id == $comment->user_id){
            $comment->delete();
            return redirect()->back();
        }
        else {
            return redirect()->back();
        }
    }
}
