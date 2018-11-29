<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Friend;
use Auth;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;

class SearchController extends Controller
{
    public function results()
    {
        $keyword = Input::get('keyword', '');
        $users = User::SearchByKeyword($keyword)->get();
        $requests = Friend::where('friend_id', '=', Auth::user()->id)->where('accepted', '=', 0)->get();
        return view('search.results', compact('users', 'requests'));
    }
}
