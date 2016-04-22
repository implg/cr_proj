@extends('layouts.app')

@section('title')
    Изменить филиал
@endsection

@section('content')

    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="page-header">
                <h2>Изменить филиал</h2>
            </div>

            {!! Form::model($branch, ['route' => ['branches.update', $branch->id], 'class' => 'form-horizontal', 'method' => 'put']) !!}
            @include('main-module/branches.formFields')
            <div class="col-md-12">
                <div class="form-group">
                    {!! Form::submit('Сохранить', ['class' => 'btn btn-raised btn-success']) !!}
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection

