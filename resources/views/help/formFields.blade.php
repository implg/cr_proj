<?php
$users = Users::getAllUser();
?>

<div class="form-group">
    {!! Form::label('title', 'Название') !!}
    {!! Form::text('title', null, ['class' => 'custom-input', 'required']) !!}
</div>

<div class="form-group">
    {!! Form::label('addressee', 'Адресат') !!}
    {!! Form::select('addressee', ['' => '', 'Выберите' => $users->lists('full_name', 'id')], null, ['class' => 'custom-select']) !!}
</div>

<div class="form-group">
    {!! Form::label('text', 'Название') !!}
    {!! Form::textarea('text', null, ['id' => 'editor', 'class' => 'custom-textarea', 'required']) !!}
</div>
{!! Form::hidden('created_user', Sentry::getUser()->id) !!}
{!! Form::submit('Сохранить', ['class' => 'btn btn-raised btn-success btn-sm']) !!}