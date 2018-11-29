<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Like;
use App\Post;
use App\User;
use Auth;
use Vinkla\Pusher\PusherManager;

class LikesController extends Controller
{
    protected $pusher;

    public function __construct(PusherManager $pusher)
    {
      $this->pusher = $pusher;
    }

    public function liked($id)
    {
        $uid = Auth::user()->id;
        $likes = Like::where('post_id', $id)
            ->where('user_id', $uid)->get();

        if ($likes->count() == 0)
        {
            $like = new Like();
            $like->user_id = $uid;
            $like->post_id = $id;
            $like->like = 1;
            $like->save();
        }

        $post = Post::where('id', $id)->first();
        $post->likes += 1;
        $post->save();

        $message = '<img style="height: 30px" src="/' . $like->user->image . '">'.$like->user->name.'<small> @'. $like->user->username .'</small> patiko '. $like->post->user->name .'<small> @'. $like->post->user->username .'</small>  <a href="irasas/' . $like->post_id . '"> įrašas</a>';
        $this->pusher->trigger('test_channel', 'my_event', ['message' => $message]);

        return redirect()->back();
    }
}
