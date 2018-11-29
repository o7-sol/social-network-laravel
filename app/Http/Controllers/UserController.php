<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Like;
use App\CommentLike;
use App\LikeReply;
use Hash;
use Auth;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;

class UserController extends Controller
{   
    public function index($id)
    {
      $user = User::where('id', $id)->first();

      $liked = Like::select('post_id')->where('user_id',Auth::user()->id)->get();
      $likeArr=array_flatten($liked->toArray());

      $likedCom = CommentLike::select('comment_id')->where('user_id',Auth::user()->id)->get();
      $likeArrCom=array_flatten($likedCom->toArray());

      $likedRep = LikeReply::select('reply_id')->where('user_id',Auth::user()->id)->get();
      $likeArrRep=array_flatten($likedRep->toArray());

        return view('users.index', compact('user', 'likeArr', 'likeArrCom', 'likeArrRep'));
    }

    public function update(Request $request, $id)
    {
    	$user = User::where('id', $id)->first();
        $user->name = $request->input('name');
    	$user->email = $request->input('email');
    	$user->age = $request->input('age');
    	$user->about = $request->input('about');

        if(Input::hasfile('image'))
        {
            $request->file('image')->move(public_path('img/profile/'), $request->file('image')->getClientOriginalName());

            $user->image = 'img/profile/' . $request->file('image')->getClientOriginalName();
        }

    	$user->save();
    	return redirect()->back();
    }

        public function passwordChange(Request $request, $id)
    {
        $user = User::where('id', $id)->first();

        $passwordOld = Hash::check($request->passwordOld, Auth::user()->password);

        if(Auth::user()->id == $user->id && $passwordOld == $user->password){
            $user->password = Hash::make($request->password);
            $user->save();
           
            return redirect()->back();
        }
        else {
            
            return redirect()->back();
        }
    }
}
