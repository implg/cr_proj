<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>
        @section('title')
        @show
    </title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Fonts -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans&subset=latin,cyrillic' rel='stylesheet' type='text/css'>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->


</head>

<body>

<!-- Navbar -->
<div class="navbar navbar-default navbar-static-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

        </div>
        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                @if (Sentry::check() && Sentry::getUser()->hasAccess('admin'))
                    <li {!! (Request::is('users*') ? 'class="active"' : '') !!}><a href="{{ action('\\Sentinel\Controllers\UserController@index') }}">Пользователи</a></li>
                    <li {!! (Request::is('groups*') ? 'class="active"' : '') !!}><a href="{{ action('\\Sentinel\Controllers\GroupController@index') }}">Группы пользователей</a></li>
                @endif
            </ul>
            <ul class="nav navbar-nav navbar-right">


                @if (Sentry::check())
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{ Sentry::getUser()->first_name }} {{ Sentry::getUser()->last_name }} <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ route('sentinel.profile.show') }}">Личный кабинет</a>
                            <li role="separator" class="divider"></li>
                            <li><a href="{{ route('sentinel.logout') }}">Выйти</a></li>
                        </ul>
                    </li>
                @else
                    <li {!! (Request::is('login') ? 'class="active"' : '') !!}><a href="{{ route('sentinel.login') }}">Войти</a></li>
                    {{--<li {!! (Request::is('users/create') ? 'class="active"' : '') !!}><a href="{{ route('sentinel.register.form') }}">Register</a></li>--}}
                @endif
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</div>
<!-- ./ navbar -->

<!-- Container -->
<div class="container">
    <!-- Notifications -->
    @include('Sentinel::layouts/notifications')
            <!-- ./ notifications -->

    <!-- Content -->
    @yield('content')
            <!-- ./ content -->
</div>

<!-- ./ container -->

<!-- Javascripts
================================================== -->
<script src="{{ asset('js/dependencies.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('packages/rydurham/sentinel/js/restfulizer.js') }}"></script>

</body>
</html>
