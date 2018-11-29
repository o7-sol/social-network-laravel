@extends('layouts.app')

@section('content')
    <div class="container" style="background: white">
        <div class="row">
            <div class="col-md-10 col-md-offset-2">
                <h1>Kvietimai draugauti</h1>
                @if(count($requests))
                <ul class="list-unstyled">
                    @foreach($requests as $request)
                        <li><img class="pull-left profilePicPost" src="/{{ $request->user->image }}" alt="{{ $request->user->name }}" />
                            <h3 style="margin-left: 7%"><a style="color: black" href="{{ url('vartotojas/'.$request->user->id.'/'.$request->user->username) }}">{{ucfirst($request->user->name)}}</a>
                                <span class="username">&commat;<a style="color: #9a9696;" href="{{ url('vartotojas/'.$request->user->id.'/'.$request->user->username) }}">{{ $request->user->username }}</a></span></h3>
                            <a style="margin-left: 2%" href="{{ url('priimti-kvietima/'.$request->id) }}" class="btn btn-primary"><i class="glyphicon glyphicon-plus"></i> Priimti kvietimą</a>
                        </li>
                    @endforeach
                </ul>
                @else
                    <p>Pakvietimų draugauti niekas neatsiuntė.</p>
                @endif
            </div>
        </div>
    </div>
@stop