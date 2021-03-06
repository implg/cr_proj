@extends(config('sentinel.layout'))

{{-- Web site Title --}}
@section('title')
    Вход
@stop

{{-- Content --}}
@section('content')
    <div class="row">
        <div class="col-md-4 col-md-offset-4">

            <h2 class="form-signin-heading">Войти в систему</h2>

            <form method="POST" action="{{ route('sentinel.session.store') }}" accept-charset="UTF-8">
                <div class="form-group {{ ($errors->has('email')) ? 'has-error' : '' }}">
                    <input class="form-control" placeholder="Email или логин" autofocus="autofocus" name="email"
                           type="text" value="{{ Request::old('email') }}">
                    {{ ($errors->has('email') ? $errors->first('email') : '') }}
                </div>

                <div class="form-group {{ ($errors->has('password')) ? 'has-error' : '' }}">
                    <input class="form-control" placeholder="Пароль" name="password" value="" type="password">
                    {{ ($errors->has('password') ?  $errors->first('password') : '') }}
                </div>

                <div class="form-group">
                    <div class="checkbox">
                        <label>
                            <input name="rememberMe" value="rememberMe" type="checkbox"> Запомнить меня
                        </label>
                    </div>
                </div>

                <input name="_token" value="{{ csrf_token() }}" type="hidden">
                <input class="btn btn-raised btn-primary" value="Войти" type="submit">
                <a class="btn btn-link" href="{{ route('sentinel.forgot.form') }}">Забыли пароль?</a>

            </form>
        </div>
    </div>

@stop
