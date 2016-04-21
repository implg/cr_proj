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
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Fonts -->
    <link href='https://fonts.googleapis.com/css?family=Open+Sans&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/icon?family=Material+Icons">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">


    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->


</head>

<body>

<nav class="navbar navbar-default ">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

        </div>
        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                @if (Sentry::check())
                    <li><a href="/">Предприятия</a></li>
                    <li><a href="{{ route('branches.index') }}">Филиалы</a></li>
                    <li><a href="{{ route('groups-company.index') }}">Группы</a></li>
                    <li><a href="/">Логи</a></li>
                    <li><a href="/">Помощь</a></li>
                @endif
            </ul>
            <ul class="nav navbar-nav navbar-right">

                @if (Sentry::check())
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="material-icons">keyboard_arrow_down</i> {{ Sentry::getUser()->first_name }} {{ Sentry::getUser()->last_name }}</a>
                        <ul class="dropdown-menu">
                            @if (Sentry::check() && Sentry::getUser()->hasAccess('admin'))
                                <li {!! (Request::is('users*') ? 'class="active"' : '') !!}><a href="{{ action('\\Sentinel\Controllers\UserController@index') }}">Пользователи</a></li>
                                <li {!! (Request::is('groups*') ? 'class="active"' : '') !!}><a href="{{ action('\\Sentinel\Controllers\GroupController@index') }}">Группы пользователей</a></li>
                            @endif
                            <li><a href="{{ route('sentinel.profile.show') }}">Личный кабинет</a>
                            <li role="separator" class="divider"></li>
                            <li><a href="{{ route('sentinel.logout') }}">Выйти</a></li>
                        </ul>
                    </li>
                @else
                    <li {!! (Request::is('login') ? 'class="active"' : '') !!}><a href="{{ route('sentinel.login') }}">Войти</a></li>
                @endif
            </ul>
        </div>
    </div>
</nav>

<!-- Container -->
<div class="container-fluid">
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
@stack('scripts')
</body>
</html>
