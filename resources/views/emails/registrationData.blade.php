
<div style="padding: 30px; background-color: #dddddd; border: 1px solid #9b9b9b;">
    <h2>Для Вас был создан аккаунт в {{ env('APP_URL') }}</h2>
    <p>Логин: <b>{{ $username }}</b></p>
    <p>Пароль: <b>{{ $password }}</b></p>
</div>

<h4>Для входа перейдите по ссылке <a href="http://{{ env('APP_URL') }}">{{ env('APP_URL') }}</a></h4>
