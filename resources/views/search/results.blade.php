@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-2">
                <h1>Paieškos rezultatai</h1>
                      <ul class="list-unstyled">
                          @foreach($users as $user)
                          <li><img class="pull-left profilePicPost" src="/{{ $user->image }}" alt="{{ $user->name }}" />
                              <h3 style="margin-left: 7%"><a style="color: black" href="{{ url('vartotojas/'.$user->id.'/'.$user->username) }}">{{ucfirst($user->name)}}</a>
                                  <span class="username">&commat;<a style="color: #9a9696;" href="{{ url('vartotojas/'.$user->id.'/'.$user->username) }}">{{ $user->username }}</a></span></h3>

                                  @if($user->hasFriendRequestPending(Auth::user()))
                                  <p>Kvietimas draugauti išsiųstas.</p>
                                  @elseif(Auth::user()->hasFriendRequestPending($user) == false && Auth::user()->id !== $user->id && $user->isFriendsWith(Auth::user()) == false)
                                  <a style="margin-left: 2%" href="/siusti-kvietima-draugauti/{{ $user->id }}/{{ $user->username }}" class="btn btn-primary"><i class="glyphicon glyphicon-plus"></i> Siųsti kvietimą draugauti</a>
                                  @elseif(Auth::user()->hasFriendRequestPending($user))
                                  @foreach($requests as $request)
                                  <a style="margin-left: 2%" href="{{ url('priimti-kvietima/'.$request->id) }}" class="btn btn-primary"><i class="glyphicon glyphicon-plus"></i> Priimti kvietimą</a>
                                  @endforeach
                                  @endif

                                  @if(Auth::user()->hasFriendRequestPending($user))
                                      <p><strong>Šis vartotojas laukia kol priimsite jo kvietimą draugauti.</strong></p>
                                  @endif

                                  @if(Auth::user()->isFriendsWith($user))
                                  <span class="label label-success">Jūs esate draugai</span>
                                  @endif

                          </li>
                          @endforeach
                      </ul>
            </div>
        </div>
    </div>
@stop
