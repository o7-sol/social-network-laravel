<div id="myModal-{{$com->id}}" class="modal fade in">
    <div class="modal-dialog">
        <div class="modal-content" style="padding-left: 5%">
            <div class="modal-header">
                <a class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span></a>
            </div>
            @foreach($com->commentLike as $like)
                <img class="pull-left profilePicPost" style="padding-right: 1%" src="/{{ $like->user->image }}" alt="{{ $like->user->name }}" />
                <h5><a style="color: black" href="{{ url('vartotojas/'.$like->user->id.'/'.$like->user->username) }}">{{ucfirst($like->user->name)}}</a>
                    <span class="username">&commat;<a style="color: #9a9696;" href="{{ url('vartotojas/'.$like->user->id.'/'.$like->user->username) }}">{{ $like->user->username }}</a></span>
                    <small>{{ $like->created_at }}</small></h5>
                <br>
            @endforeach
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dalog -->
</div><!-- /.modal -->