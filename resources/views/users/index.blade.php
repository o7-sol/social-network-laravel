@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-12 user-details">
                <div class="user-image">
                    <img src="/{{ $user->image }}" alt="{{ $user->name }}" title="{{ $user->name }}" class="img-circle profilePic">
                </div>
                <div class="user-info-block">
                    <div class="user-heading">
                        <h3>{{ucfirst($user->name)}}
                            <span class="username">&commat;{{ $user->username }}</span>
                        </h3>
                        @if($user->hasFriendRequestPending(Auth::user()))
                        <p>Kvietimas draugauti išsiųstas.</p>
                        @elseif(Auth::user()->hasFriendRequestPending($user) == false && Auth::user()->id !== $user->id && $user->isFriendsWith(Auth::user()) == false)
                        <a style="margin-left: 2%" href="/siusti-kvietima-draugauti/{{ $user->id }}/{{ $user->username }}" class="btn btn-primary"><i class="glyphicon glyphicon-plus"></i> Siųsti kvietimą draugauti</a>
                        @elseif(Auth::user()->hasFriendRequestPending($user))
                        <p>Priimti kvietim1</p>
                        @endif


                        @if(Auth::user()->isFriendsWith($user))
                        <span class="label label-success">Jūs esate draugai</span>
                        @endif
                        <span class="help-block">{{$user->location}}</span>
                    </div>
                    <ul class="navigation">
                        <li class="active">
                            <a data-toggle="tab" href="#information">
                                <span class="glyphicon glyphicon-user"></span>
                            </a>
                        </li>
                        @if(Auth::user()->id == $user->id)
                        <li>
                            <a data-toggle="tab" href="#settings">
                                <span class="glyphicon glyphicon-cog"></span>
                            </a>
                        </li>
                        @endif
                        <li>
                            <a data-toggle="tab" href="#email">
                                <span class="glyphicon glyphicon-envelope"></span>
                            </a>
                        </li>
                        @if(Auth::user()->id == $user->id)
                        <li>
                            <a data-toggle="tab" href="#password">
                                <span class="glyphicon glyphicon-lock"></span>
                            </a>
                        </li>
                        @endif
                    </ul>
                    <div class="user-body">
                        <div class="tab-content">
                            <div id="information" class="tab-pane active">
                                <h4>Daugiau apie vartotoją</h4>
                                <ul class="list-unstyled">
                                    <li>Vardas: {{ucfirst($user->name)}}</li>
                                    <li>Amžius: {{$user->age}}</li>
                                    <li>Apie mane: {{$user->about}}</li>
                                </ul>

                                <h4>Vartotojo draugai</h4>
                                @if(!$user->friends()->count())
                                    <p>Vartotojas neturi draugų.</p>
                                @else
                                <ul class="list-unstyled">
                                    @foreach($user->friends() as $friend)
                                        <li><img class="pull-left profilePicPost" src="/{{ $friend->image }}" alt="{{ $friend->name }}" />
                                            <h5 style="margin-left: 7%"><a style="color: black" href="{{ url('vartotojas/'.$friend->id.'/'.$friend->username) }}">{{ucfirst($friend->name)}}</a>
                                                <span class="username">&commat;<a style="color: #9a9696;" href="{{ url('vartotojas/'.$friend->id.'/'.$friend->username) }}">{{ $friend->username }}</a></span></h5>
                                            <br>
                                        </li>
                                    @endforeach
                                </ul>
                                @endif
                            </div>
                            @if(Auth::user()->id == $user->id)
                            <div id="settings" class="tab-pane">
                                <h4>Nustatymai</h4>
                                <ul class="list-unstyled">
                                <form method="post" enctype="multipart/form-data" action="/atnaujinti-informacija/{{$user->id}}">
                                    {!! csrf_field() !!}

                                     <div class="image-upload">
                                        <label for="image">
                                            <i class="fa fa-camera-retro" aria-hidden="true"></i> Keisti nuotrauką
                                        </label>

                                        <input id="image" name="image" type="file"/>
                                    </div>  
                                    <img id="uploadedimage" width="300px" />
                                    
                                    <li>Keisti vardą</li>
                                    <input type="text" name="name" class="form-control" value="{{$user->name}}">                              
                                    <li>Keisti el. pašto adresą</li>
                                    <input type="email" name="email" class="form-control" value="{{$user->email}}">
                                    <li>Keisti amžių</li>
                                    <input type="number" name="age" class="form-control" value="{{$user->age}}">
                                    <li>Apie mane</li>
                                    <textarea class="form-control" name="about">{{$user->about}}</textarea>
                                    <br><br>
                                    <button type="submit" class="btn btn-success">Atnaujinti informaciją</button>
                                </form>
                                </ul>
                            </div>

                            @endif
                            <div id="email" class="tab-pane">
                                <h4>Pranešimai</h4>
                                @foreach($user->post->reverse() as $post)
                                    @if(Auth::user()->isFriendsWith($post->user) || $post->friends == 0 || $post->user->id == Auth::user()->id)
                                    <div class="[ col-xs-12 col-sm-5 ]" id="postUser">
                                        <div class="[ panel panel-default ] panel-google-plus">
                                            <div class="dropdown">
                    <span class="dropdown-toggle" type="button" data-toggle="dropdown">
                        <span class="[ glyphicon glyphicon-chevron-down ]"></span>
                    </span>
                                                <ul class="dropdown-menu" role="menu">
                                                    <li role="presentation">
                                                        <a role="menuitem" tabindex="-1" href="/irasas/{{$post->id}}">Nuoroda į įrašą</a>
                                                    </li>                                                
                                                    <li role="presentation">
                                                        @if($user->id == Auth::user()->id)
                                                            <a role="menuitem" tabindex="-1" href="/trinti-irasa/{{$post->id}}">Trinti</a>
                                                        @endif</li>
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
                                                        ":)"=>"<img class='emoticon' style='height: 20px' src='/img/emoji/smile.png' />",
                                                        ":D"=>"<img class='emoticon' style='height: 20px' src='/img/emoji/grin.png'/>",
                                                        ":("=>"<img class='emoticon' style='height: 20px' src='/img/emoji/sad.png'/>",
                                                        ":P"=>"<img class='emoticon' style='height: 20px' src='/img/emoji/tongue.png'/>",
                                                        ":'D"=>"<img class='emoticon' style='height: 20px' src='/img/emoji/laugh.png'/>",
                                                        ":sleep:"=>"<img class='emoticon' style='height: 20px' src='/img/emoji/sleep.png'/>",
                                                        ":think:"=>"<img class='emoticon' style='height: 20px' src='/img/emoji/think.png'/>",
                                                ];
                                                ?>
                            <p class="post-body">{!!  preg_replace('/(\#)([^\s]+)/', ' <a href="/irasai-su-zyme/$2">#$2</a> ', strtr(strip_tags($post->post), $emotes)) !!}<br>
                        @if($post->image != null)
                         <a class="fancybox-thumb" rel="fancybox-thumb" href="/{{$post->image}}">
                            <img id="image" src="/{{$post->image}}" style="max-height: 300px">
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
                                @include('layouts.usercomments')
                            <!-- COMMENTS END  -->
                                        </div>
                                    </div>
                            @endif
                                @endforeach
                            </div>

                            @if(Auth::user()->id == $user->id)
                            <div id="password" class="tab-pane">
                                <h4>Keisti prisijungimo slaptažodį</h4>
                                <ul class="list-unstyled">
                                <form method="post" action="/keisti-slaptazodi/{{$user->id}}">
                                    {!! csrf_field() !!}

                                    <label>Dabartinis slaptažodis</label>
                                    <input type="password" name="passwordOld" class="form-control" >
                                    <label>Naujas slaptažodis</label>
                                    <input type="password" name="password" class="form-control">
                                    <br>
                                    <button type="submit" class="btn btn-success">Atnaujinti informaciją</button>

                                </form>
                                </ul>
                            </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
