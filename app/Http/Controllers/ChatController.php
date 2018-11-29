<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Vinkla\Pusher\PusherManager;
use App\Chat;
use Auth;
use App\Http\Requests;

class ChatController extends Controller
{
    protected $pusher;

    public function __construct(PusherManager $pusher)
    {
        $this->pusher = $pusher;
    }

    public function index()
    {
      $messages = Chat::orderBy('created_at', 'asc')->get();
      return view('chat.index', compact('messages'));
    }

    public function send(Request $request)
    {
      $chat = new Chat();
      $chat->user_id = Auth::user()->id;
      $chat->message = $request->input('message');
      $chat->save();

      $emotes = [
          ":)"=>"<img class='emoticon' style='height: 20px' src='../img/emoji/smile.png' />",
          ":D"=>"<img class='emoticon' style='height: 20px' src='../img/emoji/grin.png'/>",
          ":("=>"<img class='emoticon' style='height: 20px' src='../img/emoji/sad.png'/>",
          ":P"=>"<img class='emoticon' style='height: 20px' src='../img/emoji/tongue.png'/>",
          ":'D"=>"<img class='emoticon' style='height: 20px' src='../img/emoji/laugh.png'/>",
          ":sleep:"=>"<img class='emoticon' style='height: 20px' src='../img/emoji/sleep.png'/>",
          ":think:"=>"<img class='emoticon' style='height: 20px' src='../img/emoji/think.png'/>",
      ];

      $message = strtr(strip_tags($chat->message), $emotes);

      $name = $chat->user->name;
      $username = $chat->user->username;
      $avatar = $chat->user->image;
      $timeCreate = $chat->created_at;
      $this->pusher->trigger('test_channel', 'my_event', ['message' => $message,
      'fname' => $name, 'username' => $username, 'avatar' => $avatar, 'timeCreate' => $timeCreate ]);

      return response()->json();

    }
}
