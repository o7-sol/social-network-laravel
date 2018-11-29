<div class="panel-footer">
    <div class="input-placeholder">Žiūrėti komentarus</div>
</div>
<div class="panel-google-plus-comment">
    <form method="POST" action="/komentuoti/{{$p->id}}">
        {!! csrf_field() !!}
        <div class="panel-google-plus-textarea form-group">
            <input type="text" class="form-control" name="body" placeholder="Rašykite komentarą">
            <br>
            <button type="reset" class="btn btn-default">Slėpti komentarus</button>
    </form>
    <hr>
    <strong><h5>Komentarai</h5></strong>

    <!-- COMMENTS START  -->
    @foreach($p->comment as $com)
    <ul class="list-unstyled">
        <li> <img src="{{ $com->user->image }}" class="profilePicComment"> <strong><a style="color: black" href="{{ url('vartotojas/'.$com->user->id.'/'.$com->user->username) }}">{{ucfirst($com->user->name)}}</a></strong>
            <span class="username">&commat;<a style="color: #9a9696;" href="{{ url('vartotojas/'.$com->user->id.'/'.$com->user->username) }}">{{ $com->user->username }}</a>
                                         @if(Auth::user()->id == $com->user_id)
                                             <a href="/trinti-komentara/{{$com->id}}">Trinti</a>
                                         @endif
            </span>
            <small class="pull-right">{{$com->created_at}}</small>
            <br>
                <span style="padding-left: 8.5%;">{!! strtr(strip_tags($com->body), $emotes) !!}
                     <div style="margin-left: 8%">

                    <a class="comment_link" href="#"> Atsakyti</a>
                    <div class="comment_form">
                        <form action="/atsakymas-i-komentara/{{$com->id}}" method="post">
                            {!! csrf_field() !!}
                            <input type="text" name="reply" class="reply form-control" placeholder="Rašykite atsakymą...">
                        </form>
                    </div>

                                        @if(in_array($com->id, $likeArrCom))
                                            <a data-toggle="modal" href="#myModal-{{$com->id}}">
                                            <p class="pull-right">{{ count($com->commentLike) }}</p>
                                            </a>
                                            <i class="fa fa-heart pull-right comLikeBtn" aria-hidden="true" style="color: red"></i>
                                        @else
                                            <a data-toggle="modal" href="#myModal-{{$com->id}}">
                                         <p class="pull-right">{{ count($com->commentLike) }}</p>
                                         </a>
                                        <a href="{{ url('patinka-komentaras/'.$com->id) }}">
                                        <i class="fa fa-heart pull-right comLikeBtn" aria-hidden="true"></i>
                                         </a>
                                        @endif

 @if(count($com->reply))
                | <a class="replies_show" href="#">Rodyti atsakymus</a>
                @endif
                <!-- REPLIES TO COMMENTS START -->

                <ul class="list-unstyled replies">
                <a class="replies_hide" href="#">Slėpti atsakymus</a>
                     @foreach($com->reply as $reply) @include('layouts.RepliesLikeModule')
                    <li style="margin-left: 5%">
                        <img src="{{ $reply->user->image }}" class="profilePicComment">
                        <strong><a style="color: black" href="{{ url('vartotojas/'.$reply->user->id.'/'.$reply->user->username) }}">{{ucfirst($reply->user->name)}}</a></strong>
                        <span class="username">&commat;<a style="color: #9a9696;" href="{{ url('vartotojas/'.$reply->user->id.'/'.$reply->user->username) }}">{{ $reply->user->username }}</a></span><small class="pull-right">{{$reply->created_at}}</small>
                        <br>
                        <span style="padding-left: 8.5%">{!! strtr(strip_tags($reply->reply), $emotes) !!}</span> @if(in_array($reply->id, $likeArrRep))
                        <a data-toggle="modal" href="#myModal-{{$reply->id}}">
                            <p class="pull-right">{{ count($reply->likeReply) }}</p>
                        </a>
                        <i class="fa fa-heart pull-right comLikeBtn" aria-hidden="true" style="color: red; vertical-align: middle"></i> @else
                        <a data-toggle="modal" href="#myModal-{{$reply->id}}">
                            <p class="pull-right">{{ count($reply->likeReply) }}</p>
                        </a>
                        <a href="{{ url('patinka-atsakymas/'.$reply->id) }}">
                            <i class="fa fa-heart pull-right comLikeBtn" aria-hidden="true"></i>
                        </a>
                        @endif
                        <br> @if(Auth::user()->id == $reply->user_id)
                        <a href="/trinti-atsakyma/{{$reply->id}}">Trinti</a> @endif
                    </li>
                    @endforeach
                </ul>
                <!-- REPLIES TO COMMENTS END -->

                    </div>

                                    </span>
                                     @include('layouts.CommentLikeModule')
        </li>
    </ul>
    @endforeach
    <!-- COMMENTS END  -->

    </div>
    <div class="clearfix"></div>

</div>
