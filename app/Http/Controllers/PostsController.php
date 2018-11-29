<?php

namespace App\Http\Controllers;

use App\LikeReply;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Post;
use App\Like;
use App\User;
use App\Friend;
use App\Comment;
use App\CommentLike;
use App\Conversation;
use Auth;
use Vinkla\Pusher\PusherManager;
use Activity;

use Illuminate\Support\Facades\Input;

class PostsController extends Controller
{
    protected $pusher;

    public function __construct(PusherManager $pusher)
    {
      $this->pusher = $pusher;
    }

    public function post(Request $request)
    {
       $this->validate($request, [
          'image' => 'mimes:jpeg,jpg,bmp,png,gif',
      ]);

        if(Input::hasfile('image') or Input::has('post')){
        $post = new Post();
        $post->user_id = Auth::user()->id;
        $post->post = $request->input('post');

        if(Input::hasfile('image'))
        {
            $request->file('image')->move(public_path('img/posts/'), $request->file('image')->getClientOriginalName());

            $post->image = 'img/posts/' . $request->file('image')->getClientOriginalName();
        }

        if(Input::get('public')){
            $post->public = 1;
        }
        if(Input::get('friends')){
            $post->friends = 1;
        }
        $post->save();
        $postId = $post->id;

        $message = '<img style="height: 30px" src="/' . $post->user->image . '">'.$post->user->name.' paskelbė naują <a href="irasas/' . $postId . '">įrašą</a>';

        $this->pusher->trigger('posts_channel', 'post_event', ['message' => $message]);
        return redirect()->back();
      }
      else {
        return redirect('/error');
      }
}

    public function index(){

        $requests = Friend::where('friend_id', '=', Auth::user()->id)->where('accepted', '=', 0)->take(5)->get();

        $activities = Activity::users()->get();

        list($posts, $likes, $comments) = $this->notifications();

        list($likeArr, $likeArrCom, $likeArrRep) = $this->likes();

        $emotes = [
            ":)"=>"<img class='emoticon' style='height: 20px' src='../img/emoji/smile.png' />",
            ":D"=>"<img class='emoticon' style='height: 20px' src='../img/emoji/grin.png'/>",
            ":("=>"<img class='emoticon' style='height: 20px' src='../img/emoji/sad.png'/>",
            ":P"=>"<img class='emoticon' style='height: 20px' src='../img/emoji/tongue.png'/>",
            ":'D"=>"<img class='emoticon' style='height: 20px' src='../img/emoji/laugh.png'/>",
            ":sleep:"=>"<img class='emoticon' style='height: 20px' src='../img/emoji/sleep.png'/>",
            ":think:"=>"<img class='emoticon' style='height: 20px' src='../img/emoji/think.png'/>",
        ];

       return view('index', compact('posts', 'likeArr', 'likeArrCom', 'likeArrRep', 'likes', 'comments', 'requests', 'activities', 'emotes'));
    }

    public function show($id)
    {
        $post = Post::where('id', $id)->first();

        $activities = Activity::users()->get();

        list($posts, $likes, $comments) = $this->notifications();

        list($likeArr, $likeArrCom, $likeArrRep) = $this->likes();

        $emotes = [
            ":)"=>"<img class='emoticon' style='height: 20px' src='../img/emoji/smile.png' />",
            ":D"=>"<img class='emoticon' style='height: 20px' src='../img/emoji/grin.png'/>",
            ":("=>"<img class='emoticon' style='height: 20px' src='../img/emoji/sad.png'/>",
            ":P"=>"<img class='emoticon' style='height: 20px' src='../img/emoji/tongue.png'/>",
            ":'D"=>"<img class='emoticon' style='height: 20px' src='../img/emoji/laugh.png'/>",
            ":sleep:"=>"<img class='emoticon' style='height: 20px' src='../img/emoji/sleep.png'/>",
            ":think:"=>"<img class='emoticon' style='height: 20px' src='../img/emoji/think.png'/>",
        ];

        return view('posts.show', compact('post', 'likeArr', 'likeArrCom', 'likeArrRep', 'likes', 'comments', 'posts', 'activities', 'emotes'));
    }

    public function postWithTag($tag)
    {
      $postsWithTags = Post::SearchByTag($tag)->orderBy('created_at','desc')->paginate(10);
      $activities = Activity::users()->get();

      list($posts, $likes, $comments) = $this->notifications();
      list($likeArr, $likeArrCom, $likeArrRep) = $this->likes();

      $emotes = [
          ":)"=>"<img class='emoticon' style='height: 20px' src='../img/emoji/smile.png' />",
          ":D"=>"<img class='emoticon' style='height: 20px' src='../img/emoji/grin.png'/>",
          ":("=>"<img class='emoticon' style='height: 20px' src='../img/emoji/sad.png'/>",
          ":P"=>"<img class='emoticon' style='height: 20px' src='../img/emoji/tongue.png'/>",
          ":'D"=>"<img class='emoticon' style='height: 20px' src='../img/emoji/laugh.png'/>",
          ":sleep:"=>"<img class='emoticon' style='height: 20px' src='../img/emoji/sleep.png'/>",
          ":think:"=>"<img class='emoticon' style='height: 20px' src='../img/emoji/think.png'/>",
      ];

      return view('posts.tags.index', compact('postsWithTags', 'likeArr', 'likeArrCom', 'likeArrRep', 'likes', 'comments', 'posts', 'activities', 'emotes'));
    }

    public function delete($id)
    {
        $post = Post::where('id', $id)->first();
        if($post->user_id == Auth::user()->id){
            $post->delete($id);
            return redirect('/');
        } else {
            return redirect('/');
        }
    }

    private function notifications()
    {
      $posts = Post::orderBy('created_at', 'desc')->paginate(10);

      $likes = Like::orderBy('created_at', 'desc')->paginate(10);
      $comments = Comment::orderBy('created_at', 'desc')->paginate(10);

      return [$posts, $likes, $comments];

    }

    private function likes()
    {
      $liked = Like::select('post_id')->where('user_id',Auth::user()->id)->get();
      $likeArr=array_flatten($liked->toArray());

      $likedCom = CommentLike::select('comment_id')->where('user_id',Auth::user()->id)->get();
      $likeArrCom=array_flatten($likedCom->toArray());

      $likedRep = LikeReply::select('reply_id')->where('user_id',Auth::user()->id)->get();
      $likeArrRep=array_flatten($likedRep->toArray());

      return [$likeArr, $likeArrCom, $likeArrRep];
    }
}
