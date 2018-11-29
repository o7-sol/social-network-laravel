<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Scripts -->
    <script src="https://js.pusher.com/3.2/pusher.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js" integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    {{-- <script src="{{ elixir('js/app.js') }}"></script> --}}
    <script src="{{url('js/login.js')}}"></script>
    <script src="{{url('js/post.js')}}"></script>
    <script src="{{url('js/comments.js')}}"></script>
    <script src="{{url('js/photo.js')}}"></script>
    <script src="{{url('js/fancybox.js')}}"></script>
    <script src="{{url('js/pusher.js')}}"></script>

    <!-- FancyBox -->
    <script type="text/javascript" src="{{url('js/jquery.fancybox.js?v=2.1.5')}}"></script>
    <link rel="stylesheet" type="text/css" href="{{url('styles/jquery.fancybox.css?v=2.1.5')}}" media="screen" />

    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">

    <!-- Styles -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}
    <link rel="stylesheet" href="{{url('styles/style.css')}}">
    <style>
        body {
            font-family: 'Lato';
        }

        .fa-btn {
            margin-right: 6px;
        }
    </style>
</head>
<body id="app-layout">
    <nav class="navbar navbar-default navbar-static-top" style="background-color: #472784">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}" style="color: white">
                    Tweegly
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
            @if(Auth::user())
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    <li><a href="{{ url('/') }}">Siena</a></li>
                    <li><a href="{{ url('/draugu-paieska') }}">Ieškoti draugų</a></li>
                    <li><a href="{{ url('/pokalbiai') }}">Pokalbiai</a></li>
                </ul>
            @endif
                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ url('/prisijungti') }}">Prisijungti</a></li>
                        <li><a href="{{ url('/registracija') }}">Registruotis</a></li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ ucfirst(Auth::user()->name) }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('/vartotojas/'.Auth::user()->id.'/'.Auth::user()->name) }}"><i class="fa fa-user" aria-hidden="true"></i> Profilis</a></li>
                                <li><a href="{{ url('kvietimai-draugauti') }}"><i class="fa fa-user-plus" aria-hidden="true"></i> Kvietimai draugauti</a></li>
                                <li><a href="{{ url('draugai/'.Auth::user()->username.'/'.Auth::user()->id) }}"><i class="fa fa-users" aria-hidden="true"></i> Mano draugai</a></li>
                                <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Atsijungti</a></li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>


    <div id="notzi"></div>
    @yield('content')
</body>
</html>
