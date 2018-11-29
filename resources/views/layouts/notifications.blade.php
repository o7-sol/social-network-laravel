<div class="reqNotes">
    <h4 class="text-center"><span style="color:white">Prisijungę draugai</span></h4>
    <div style="background: #FFFFFF; padding: 10px">
       <ul class="list-unstyled" id="onlineUsers">
@foreach($activities as $user)
         <li>               @if(Auth::user()->isFriendsWith($user->user))
                            <img style="height: 10px" src="http://www.clker.com/cliparts/4/t/n/Q/b/d/green-glossy-icon-md.png">
                            <img style="height: 30px" src="{{url($user->user->image)}}" class="profilePicComment">
                            <span id="name">{{ucfirst($user->user->name)}}</span>
                            <small>&commat;{{$user->user->username}}</small>  
                            <a href="#-{{$user->user->id}}" id="sendMessage">Rašyti žinutę</a>
                            <hr>
                            @endif       
         </li>
         @endforeach
       </ul>
    </div>



    <h4 class="text-center"><span style="color:white">Pakvietimai draugauti</span></h4>
    <div style="background: #FFFFFF; padding: 10px">
      @if(count(Auth::user()->friendRequestsPending()))
       <ul class="list-unstyled text-center">
         @foreach($requests as $request)
         <li>
                            <img src="{{$request->user->image}}" class="profilePicComment">
                            {{ucfirst($request->user->name)}}
                            <small>&commat;{{$request->user->username}}</small>
                            <a href="{{ url('priimti-kvietima/'.$request->id) }}" class="btn btn-success"><i class="fa fa-user-plus" aria-hidden="true"></i> Priimti kvietimą</a>            
           
         </li>
         @endforeach
       </ul>
      @endif
    </div>

    <h4 class="text-center"><span style="color:white">Patikę įrašai</span></h4>
    <div style="background: #FFFFFF; padding: 10px">

        @foreach($likes as $like)
        @if(Auth::user()->isFriendsWith($like->user))

        <img class="pull-left" style="height: 30px; padding-right: 2%" src="/{{ $like->user->image }}" alt="{{$like->user->name }}" />

        <h6><strong><a style="color: black" href="{{ url('vartotojas/'.$like->user->id.'/'.$like->user->username) }}">{{ucfirst($like->user->name)}}</a></strong>
        mėgstą <a href="{{ url('irasas/'.$like->post->id) }}">įrašą</a>, kurį paskelbė
           <strong><a style="color: black" href="{{ url('vartotojas/'.$like->post->user->id.'/'.$like->post->user->username) }}">{{ucfirst($like->post->user->name)}}</a></strong>
        </h6>
        <hr>
        @endif
        @endforeach

    </div>
</div>


<div class="commentNotes">
  <h4 class="text-center"><span style="color:white">Nauji įrašai</span></h4>
  <div style="background: #FFFFFF; padding: 10px">
      @foreach($posts as $post)
      @if(Auth::user()->isFriendsWith($post->user))

      <img class="pull-left" style="height: 30px; padding-right: 2%" src="/{{ $post->user->image }}" alt="{{$post->user->name }}" />

      <h6><strong><a style="color: black" href="{{ url('vartotojas/'.$post->user->id.'/'.$post->user->username) }}">{{ucfirst($post->user->name)}}</a></strong>
      paskelbė naują <a href="{{ url('irasas/'.$post->id) }}">įrašą</a>


  </h6>
      <hr>
      @endif
      @endforeach
  </div>


    <h4 class="text-center"><span style="color:white">Komentarai</span></h4>
    <div style="background: #FFFFFF; padding: 10px">
        @foreach($comments as $comment)
        @if(Auth::user()->isFriendsWith($comment->user))

        <img class="pull-left" style="height: 30px; padding-right: 2%" src="/{{ $comment->user->image }}" alt="{{$comment->user->name }}" />

        <h6><strong><a style="color: black" href="{{ url('vartotojas/'.$comment->user->id.'/'.$comment->user->username) }}">{{ucfirst($comment->user->name)}}</a></strong>
        pakomentavo <a href="{{ url('irasas/'.$comment->post->id) }}">įrašą</a>, kurį paskelbė
           <strong><a style="color: black" href="{{ url('vartotojas/'.$comment->post->user->id.'/'.$comment->post->user->username) }}">{{ucfirst($comment->post->user->name)}}</a></strong>
    </h6>
        <hr>
        @endif
        @endforeach
    </div>
</div>