@extends('layouts.app')

@section('content')
    <div class="container" style="background: white">
        <div class="row">
            <div class="col-md-10 col-md-offset-2">
                <h1>Vartotojo {{ $user->name }} (<small>&commat;{{ $user->username }}</small>) draugai</h1>
                @if(!$user->friends()->count())
                    <p>Kol kas draugų neturite.</p>
                @else
                    <ul class="list-unstyled">
                        @foreach($user->friends() as $user)
                            <li><img class="pull-left profilePicPost" src="/{{ $user->image }}" alt="{{ $user->name }}" />
                                <h3 style="margin-left: 7%"><a style="color: black" href="{{ url('vartotojas/'.$user->id.'/'.$user->username) }}">{{ucfirst($user->name)}}</a>
                                    <span class="username">&commat;<a style="color: #9a9696;" href="{{ url('vartotojas/'.$user->id.'/'.$user->username) }}">{{ $user->username }}</a></span></h3>

                                <a style="margin-left: 2%" href="{{ url('trinti-drauga/'.$user->id.'/'.$user->username) }}" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i> Trinti draugą</a>

                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
@stop