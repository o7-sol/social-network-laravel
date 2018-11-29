<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Friend;
use Auth;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;

class FriendsController extends Controller
{
   public function add($id)
   {
       $friend = new Friend();
       $friendId = User::where('id', $id)->first();
       $friend->user_id = Auth::user()->id;
       $friend->friend_id = $friendId->id;
       $friend->save();
       flash()->success('Kvietimas draugauti išsiųstas!');
       return redirect('/');
   }

    public function showRequests()
    {
            $requests = Friend::where('friend_id', '=', Auth::user()->id)->where('accepted', '=', 0)->get();
            return view('users.friends.requests', compact('requests'));
    }

    public function accept($id)
    {
        $friend = Friend::where('id', $id)->first();
        $friend->accepted = 1;
        $friend->save();
        flash()->success('Kvietimas draugauti priimtas!');
        return redirect('/');
    }

    public function show($username)
    {
        $user = User::where('username', $username)->first();
        $request = Friend::where('user_id', '=', Auth::user()->id)->where('accepted', '=', 1)->get();
        return view('users.friends.show', compact('user', 'request'));
    }

    public function delete($id)
    {
        $friend = Friend::where('id', $id)->first();
        $friend->destroy($id);
        return redirect()->back();
    }

}
