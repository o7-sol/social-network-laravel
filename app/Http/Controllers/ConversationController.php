<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Vinkla\Pusher\PusherManager;
use App\Conversation;
use App\User;
use Auth;
use App\Http\Requests;

class ConversationController extends Controller
{
    protected $pusher;

    public function __construct(PusherManager $pusher)
    {
        $this->pusher = $pusher;
    }

    public function store(Request $request, $id)
    {
    	$conv = new Conversation();
    	$conv->user_id = Auth::user()->id;
        $friend = User::where('id', $id)->first();
    	$conv->friend_id = $friend->id;
    	$conv->message = $request->input('message');
    	$conv->save();

    	$message = $conv->message;
    	$avatar = $conv->user->image;

        $this->pusher->trigger('chat_channel', 'chat_event', ['message' => $message, 'avatar' => $avatar]);

    	return response()->json();
    }

}
