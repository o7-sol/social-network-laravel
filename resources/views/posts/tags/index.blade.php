@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-2 mainPosts">
            @include('layouts.notifications')
            @foreach($postsWithTags as $post)
            <div class="[ col-xs-12 col-sm-5 ]" id="postUser" style="background: rgba(255, 255, 255, 0.5); padding-top: 1.7%">
                <div class="panel-google-plus">
                    <div class="dropdown">
                        <span class="dropdown-toggle" type="button" data-toggle="dropdown">
                        <span class="[ glyphicon glyphicon-chevron-down ]"></span>
                        </span>
                        <ul class="dropdown-menu" role="menu">
                            <li role="presentation">
                                <a role="menuitem" tabindex="-1" href="/irasas/{{$post->id}}">Nuoroda į įrašą</a>
                            </li>
                            <li role="presentation">                            
                                @if($post->user_id == Auth::user()->id)
                                <a role="menuitem" tabindex="-1" href="/trinti-irasa/{{$post->id}}">Trinti</a> @endif
                            </li>
                        </ul>
                    </div>
                    <div class="panel-heading">
                        <img class="pull-left profilePicPost" src="/{{ $post->user->image }}" alt="{{ $post->user->name }}" />

                        <h5><strong><a style="color: black" href="{{ url('vartotojas/'.$post->user->id.'/'.$post->user->username) }}">{{ucfirst($post->user->name)}}</a></strong>

                                <span class="username">&commat;<a style="color: #9a9696;" href="{{ url('vartotojas/'.$post->user->id.'/'.$post->user->username) }}">{{ $post->user->username }}</a></span></h5>
                        <h5><span>
                                @if($post->friends == 1)
                                        <i class="fa fa-users" aria-hidden="true"></i>
                                    @else
                                        <i class="fa fa-globe" aria-hidden="true"></i>
                                    @endif
                            </span> - <span style="font-size: 12px">{{$post->created_at}}</span> </h5>
                    </div>
                    <div class="panel-body">
                        <?php
                            $emotes = [
                                    ":)"=>"<img class='emoticon' style='height: 20px' src='../img/emoji/smile.png' />",
                                    ":D"=>"<img class='emoticon' style='height: 20px' src='../img/emoji/grin.png'/>",
                                    ":("=>"<img class='emoticon' style='height: 20px' src='../img/emoji/sad.png'/>",
                                    ":P"=>"<img class='emoticon' style='height: 20px' src='../img/emoji/tongue.png'/>",
                                    ":'D"=>"<img class='emoticon' style='height: 20px' src='../img/emoji/laugh.png'/>",
                                    ":sleep:"=>"<img class='emoticon' style='height: 20px' src='../img/emoji/sleep.png'/>",
                                    ":think:"=>"<img class='emoticon' style='height: 20px' src='../img/emoji/think.png'/>",
                            ];
                            ?>
                            <p class="post-body">{!!  preg_replace('/(\#)([^\s]+)/', ' <a href="/irasai-su-zyme/$2">#$2</a> ', strtr(strip_tags($post->post), $emotes)) !!}<br>
                        @if($post->image != null)
                         <a class="fancybox-thumb" rel="fancybox-thumb" href="/{{$post->image}}">
                            <img id="image" src="/{{$post->image}}" style="max-height: 300px" class="img-responsive">
                            </a>
                        @endif
                        </p>

                            @include('posts.likesModule')
                            <div>
                                @if(in_array($post->id,$likeArr))
                                <span class="pull-right"><strong><a data-toggle="modal" href="#myModal-{{$post->id}}">{{count($post->like)}}</a></strong></span>
                                <i class="fa fa-heart liked pull-right" aria-hidden="true" style="vertical-align:middle"></i> @else
                                <span class="pull-right"><strong><a class="pull-right" data-toggle="modal" href="#myModal-{{$post->id}}">{{count($post->like)}}</a></strong></span>
                                <a href="/patinka/{{$post->id}}">
                                    <i class="fa fa-heart likeBtn pull-right" aria-hidden="true" style="vertical-align:middle"></i>
                                </a>
                                @endif
                                <span class="pull-right"><strong>{{count($post->comment)}}</strong></span>
                                <i class="fa fa-comment pull-right commentIcon" aria-hidden="true"></i>

                            </div>
                    </div>
                    @include('posts.comments')
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@stop
