@extends('layouts.chat')

@section('content')

<div class="container" style="">
    <div class="row">

      <div class="col-md-12">
          <div class="panel panel-primary">
              <div class="panel-heading">
                  <span class="glyphicon glyphicon-comment"></span> Pokalbiai
              </div>
              <div class="chat-panel-body"><br>
                  <ul class="chat">
                    @foreach($messages as $message)
                      <li class="left clearfix"><span class="chat-img pull-left">
                          <img class="profilePicPost" src="/{{ $message->user->image }}" />
                      </span>
                          <div class="chat-body clearfix">
                              <div class="header">
                                  <strong class="primary-font">{{ $message->user->name }}</strong><small> &commat;{{$message->user->username}}</small> <small class="pull-right text-muted">
                                      <span class="glyphicon glyphicon-time"></span>{{ $message->created_at->format('H:i:s') }}</small>
                              </div>

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

                              <p>
                                  {!! strtr(strip_tags($message->message), $emotes) !!}
                              </p>
                          </div>
                      </li>
                      @endforeach
                  </ul>
              </div>
              <div class="panel-footer">
                  <div class="input-group">
                    <form method="post" action="siusti-pranesima">
                      {{csrf_field()}}
                      <textarea cols="71" id="message" name="message" type="text" class="form-control input-sm" placeholder="Rašykite pranešima čia..."></textarea>
                      <br><br><br>
                      <button class="btn btn-warning btn-sm" id="btn-chat" type="submit">Siųsti</button>
                    </form>
                  </div>
              </div>
          </div>
    </div>
</div>

<script src="{{url('js/chat.js')}}"></script>
@stop
