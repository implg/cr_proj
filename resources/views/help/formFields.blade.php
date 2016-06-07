<?php
$users = Users::getAllUser();
?>

<div class="form-group">
    {!! Form::label('title', 'Название') !!}
    {!! Form::text('title', null, ['class' => 'custom-input', 'required']) !!}
</div>

<div class="form-group">
    {!! Form::label('addressee', 'Для пользователей (зажав ctrl можно выбрать несколько)') !!}
    {!! Form::select('addressee[]', $users->lists('full_name', 'id'), (isset($articleUsers) ? array_flatten($articleUsers->lists('id')) : null), ['class' => 'custom-select', 'multiple']) !!}
</div>

<div class="form-group">
    {!! Form::label('text', 'Название') !!}
    {!! Form::textarea('text', null, ['id' => 'editor', 'class' => 'custom-textarea', 'required']) !!}
</div>
{!! Form::hidden('created_user', Sentry::getUser()->id) !!}
{!! Form::submit('Сохранить', ['class' => 'btn btn-raised btn-success btn-sm']) !!}