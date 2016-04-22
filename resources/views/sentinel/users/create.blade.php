@extends(config('sentinel.layout'))

{{-- Web site Title --}}
@section('title')
    @parent
    Создание нового пользователя
@stop

{{-- Content --}}
@section('content')
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <form method="POST" action="{{ route('sentinel.users.store') }}" accept-charset="UTF-8">

                <h2>Создание нового пользователя</h2>

                <div class="alert alert-success" role="alert">
                    После создания нового пользователя он автоматически добавится в группу "Менеджеры".
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">Персональные данные</div>
                            <div class="panel-body">
                                <div class="form-group {{ ($errors->has('first_name')) ? 'has-error' : '' }}">
                                    <input class="form-control" placeholder="Имя" name="first_name" type="text"
                                           value="{{ Request::old('first_name') }}">
                                    {{ ($errors->has('first_name') ? $errors->first('first_name') : '') }}
                                </div>
                                <div class="form-group {{ ($errors->has('last_name')) ? 'has-error' : '' }}">
                                    <input class="form-control" placeholder="Фамилия" name="last_name" type="text"
                                           value="{{ Request::old('last_name') }}">
                                    {{ ($errors->has('last_name') ? $errors->first('last_name') : '') }}
                                </div>
                                <div class="form-group {{ ($errors->has('username')) ? 'has-error' : '' }}">
                                    <input class="form-control" placeholder="Логин" name="username" type="text"
                                           value="{{ Request::old('username') }}">
                                    {{ ($errors->has('username') ? $errors->first('username') : '') }}
                                </div>

                                <div class="form-group {{ ($errors->has('email')) ? 'has-error' : '' }}">
                                    <input class="form-control" placeholder="E-mail" name="email" type="text"
                                           value="{{ Request::old('email') }}">
                                    {{ ($errors->has('email') ? $errors->first('email') : '') }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">Пароль</div>
                            <div class="panel-body">
                                <div class="form-group {{ ($errors->has('password')) ? 'has-error' : '' }}">
                                    <input class="form-control" placeholder="Пароль" name="password" value=""
                                           type="password">
                                    {{ ($errors->has('password') ?  $errors->first('password') : '') }}
                                </div>

                                <div class="form-group {{ ($errors->has('password_confirmation')) ? 'has-error' : '' }}">
                                    <input class="form-control" placeholder="Подтвердите пароль"
                                           name="password_confirmation" value="" type="password">
                                    {{ ($errors->has('password_confirmation') ?  $errors->first('password_confirmation') : '') }}
                                </div>
                                <div class="form-group">
                                    <div class="checkbox">
                                        <label>
                                            <input name="activate" value="activate" type="checkbox"> Активен
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <input name="_token" value="{{ csrf_token() }}" type="hidden">
                <input class="btn btn-raised btn-primary" value="Создать" type="submit">

            </form>
        </div>
    </div>


@stop