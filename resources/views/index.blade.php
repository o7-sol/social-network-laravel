@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
      @include('flash::message')

        <div class="post-panel">
            <form role="form" method="POST" action="/skelbti-irasa" enctype="multipart/form-data" id="post" class="center-block">
                {!! csrf_field() !!}
                <div class="form-group">
                    <textarea id="message" name="post" class="form-control" placeholder="Apie ką galvoji...?"></textarea>
                    <br>

                     <div class="image-upload">
                        <label for="image">
                            <i class="fa fa-camera-retro" aria-hidden="true"></i> Nuotrauka / GIF
                        </label>

                        <input id="image" name="image" type="file"/>
                    </div>
                    <img id="uploadedimage" width="300px" />
                    <br>
                    <label>
                        <input type="checkbox" name="public" checked/>Viešas</label>
                    <label>
                        <input type="checkbox" name="friends" />Draugai</label>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-success"><i class="fa fa-paper-plane" aria-hidden="true"></i> Skelbti</button>
                </div>

            </form>
        </div>
        <div class="col-md-8 mainPosts">
            @include('layouts.notifications')
            @foreach($posts as $p)
            @if(Auth::user()->isFriendsWith($p->user) || Auth::user()->id == $p->user->id)

            <div class="col-xs-12 col-sm-5" id="postUser" style="background: rgba(255, 255, 255, 0.5)">
                <div class="panel-google-plus">
                    <div class="dropdown">
                        <span class="dropdown-toggle" type="button" data-toggle="dropdown">
                        <span class="[ glyphicon glyphicon-chevron-down ]"></span>
                        </span>
                        <ul class="dropdown-menu" role="menu">
                            <li role="presentation">
                                <a role="menuitem" tabindex="-1" href="/irasas/{{$p->id}}">Nuoroda į įrašą</a>
                            </li>
                            <li role="presentation">
                                @if($p->user_id == Auth::user()->id)
                                <a role="menuitem" tabindex="-1" href="/trinti-irasa/{{$p->id}}">Trinti</a> @endif
                            </li>
                        </ul>
                    </div>
                    <div class="panel-heading">
                        <img class="pull-left profilePicPost" src="/{{ $p->user->image }}" alt="{{ $p->user->name }}" />

                        <h5><strong><a style="color: black" href="{{ url('vartotojas/'.$p->user->id.'/'.$p->user->username) }}">{{ucfirst($p->user->name)}}</a></strong>

                         <span class="username">&commat;<a style="color: #9a9696;" href="{{ url('vartotojas/'.$p->user->id.'/'.$p->user->username) }}">{{ $p->user->username }}</a></span></h5>
                        <h5><span>
                                @if($p->friends == 1)
                                    <i class="fa fa-users" aria-hidden="true"></i>
                                @else
                                    <i class="fa fa-globe" aria-hidden="true"></i>
                                @endif
                            </span> - <span style="font-size: 12px">{{$p->created_at}}</span> </h5>
                    </div>
                    <div class="panel-body">
                          <!--  <p class="post-body">{!! strtr(strip_tags($p->post), $emotes) !!}</p>-->
                        <p class="post-body">{!!  preg_replace('/(\#)([^\s]+)/', ' <a href="/irasai-su-zyme/$2">#$2</a> ', strtr(strip_tags($p->post), $emotes)) !!}
                        <br>
                        @if($p->image != null)
                         <a class="fancybox-thumb" rel="fancybox-thumb" href="/{{$p->image}}">
                            <img src="/{{$p->image}}" style="max-height: 300px" class="img-responsive">
                            </a>
                        @endif
                        </p>
                            @include('layouts.likesModule')
                            <div>
                                @if(in_array($p->id,$likeArr))
                                <span class="pull-right"><strong><a data-toggle="modal" href="#myModal-{{$p->id}}">{{count($p->like)}}</a></strong></span>
                                <i class="fa fa-heart liked pull-right" aria-hidden="true" style="vertical-align:middle"></i> @else
                                <span class="pull-right"><strong><a class="pull-right" data-toggle="modal" href="#myModal-{{$p->id}}">{{count($p->like)}}</a></strong></span>
                                <a href="/patinka/{{$p->id}}">
                                    <i class="fa fa-heart likeBtn pull-right" aria-hidden="true" style="vertical-align:middle"></i>
                                </a>
                                @endif
                                <span class="pull-right"><strong>{{count($p->comment)}}</strong></span>
                                <i class="fa fa-comment pull-right commentIcon" aria-hidden="true"></i>

                            </div>
                    </div>
                    @include('layouts.comments')
                </div>
            </div>
            @endif
            @endforeach
        </div>
                <div id="chat_box" hidden="true">
                    <div id="chat_box_head"></div>
                    <div id="chat_box_body">
                    <ul class="list-unstyled messages">

                    </ul>
                    </div>
                        <form id="chatForm" method="post" action="siusti-zinute">
                        {{csrf_field()}}
                            <input type="text" id="inputMessage" name="message">
                        </form>
                </div>
    </div>
</div>

<script type="text/javascript">
    $("#sendMessage").on('click', function(){
        $("#chat_box").toggle('fast');
        $("#chat_box_head").append($("#name").text());
    });


  var pusher = new Pusher('f0946efe2974212caafa', {
    cluster: 'eu',
    encrypted: true
  });

  var channel = pusher.subscribe('chat_channel');
  channel.bind('chat_event', function(data) {
    $('.messages').append('<li><img src="'+data.avatar+'" style="height: 30px">'+" "+data.message+'</li>');
  });


  $('#chatForm').submit(function( event ) {
  event.preventDefault();
  $.ajax({
      url: 'siusti-zinute/'+$("#userId").text()+'',
      type: 'post',
      data: $('#chatForm').serialize(), // Remember that you need to have your csrf token included
      dataType: 'json',
      success: function( _response ){
        $("#inputMessage").val('');
        $('#chat_box_body').animate({scrollTop: $('#chat_box_body').prop("scrollHeight")}, 500);
        },
      error: function( _response ){
          // Handle error
      }
  });
});

</script>

@endsection
