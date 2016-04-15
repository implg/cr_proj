@extends(config('sentinel.layout'))

{{-- Web site Title --}}
@section('title')
@parent
Редактировать профиль
@stop

{{-- Content --}}
@section('content')

<?php
    // Pull the custom fields from config
    $isProfileUpdate = ($user->email == Sentry::getUser()->email);
    $customFields = config('sentinel.additional_user_fields');

    // Determine the form post route
    if ($isProfileUpdate) {
        $profileFormAction = route('sentinel.profile.update');
        $passwordFormAction = route('sentinel.profile.password');
    } else {
        $profileFormAction =  route('sentinel.users.update', $user->hash);
        $passwordFormAction = route('sentinel.password.change', $user->hash);
    }
?>

<div class="row">
    <div class='page-header'>
        <h1>
            Редактировать
            @if ($isProfileUpdate)
                Ваш профиль
            @else
                профиль: {{ $user->first_name }} {{ $user->last_name }}
            @endif

        </h1>
    </div>
</div>

@if (! empty($customFields))
<div class="row">
    <div class="well">
        <h3>Профиль</h3>
        <form method="POST" action="{{ $profileFormAction }}" accept-charset="UTF-8" class="form-horizontal" role="form">
            <input name="_method" value="PUT" type="hidden">
            <input name="_token" value="{{ csrf_token() }}" type="hidden">

            @foreach(config('sentinel.additional_user_fields_ru') as $field => $ru)
            <div class="form-group {{ ($errors->has($field)) ? 'has-error' : '' }}" for="{{ $field }}">
                <label for="{{ $field }}" class="col-sm-2 control-label">{{ $ru }}</label>
                <div class="col-sm-10">
                    <input class="form-control" name="{{ $field }}" type="text" value="{{ Request::old($field) ? Request::old($field) : $user->$field }}">
                    {{ ($errors->has($field) ? $errors->first($field) : '') }}
                </div>
            </div>
            @endforeach

            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <input class="btn btn-raised btn-success" value="Сохранить изменения" type="submit">
                </div>
            </div>

        </form>
    </div>
</div>
@endif


<div class="row">
    <div class="well">
        <h3>Роли</h3>
        <form method="POST" action="{{ route('sentinel.users.memberships', $user->hash) }}" accept-charset="UTF-8" class="form-horizontal" role="form">

            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10 checkbox">
                    @foreach($groups as $group)
                        <label class="checkbox-inline">
                            <input type="checkbox" name="groups[{{ $group->name }}]" value="1" {{ ($user->inGroup($group) ? 'checked' : '') }}> {{ $group->name }}
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <input name="_token" value="{{ csrf_token() }}" type="hidden">
                    <input class="btn btn-raised btn-success" value="Сохранить изменения" type="submit">
                </div>
            </div>

        </form>
    </div>
</div>


<div class="row">
    <div class="well">
        <h3>Изменить пароль</h3>
        <form method="POST" action="{{ $passwordFormAction }}" accept-charset="UTF-8" class="form-inline" role="form">

            @if(! Sentry::getUser()->hasAccess('admin'))
            <div class="form-group {{ $errors->has('oldPassword') ? 'has-error' : '' }}">
                <label for="oldPassword" class="sr-only">Old Password</label>
                <input class="form-control" placeholder="Old Password" name="oldPassword" value="" id="oldPassword" type="password">
            </div>
            @endif

            <div class="form-group {{ $errors->has('newPassword') ? 'has-error' : '' }}">
                <label for="newPassword" class="sr-only">Новый пароль</label>
                <input class="form-control" placeholder="Новый пароль" name="newPassword" value="" id="newPassword" type="password">
            </div>

            <div class="form-group {{ $errors->has('newPassword_confirmation') ? 'has-error' : '' }}">
                <label for="newPassword_confirmation" class="sr-only">Подтвердите пароль</label>
                <input class="form-control" placeholder="Подтвердите пароль" name="newPassword_confirmation" value="" id="newPassword_confirmation" type="password">
            </div>

            <input name="_token" value="{{ csrf_token() }}" type="hidden">
            <input class="btn btn-raised btn-success" value="Изменить пароль" type="submit">

            {{ ($errors->has('oldPassword') ? '<br />' . $errors->first('oldPassword') : '') }}
            {{ ($errors->has('newPassword') ?  '<br />' . $errors->first('newPassword') : '') }}
            {{ ($errors->has('newPassword_confirmation') ? '<br />' . $errors->first('newPassword_confirmation') : '') }}

        </form>

    </div>
</div>
@stop
