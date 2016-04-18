@extends('layouts.app')

@section('title')
   Предприятия
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2>Филиалы</h2>

            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (Sentry::getUser()->hasAccess('admin'))
                    <a href="#" class="btn btn-raised btn-success" data-toggle="modal" data-target=".create-branch">Добавить филиал</a>
                @endif
            </div>
    </div>
</div>
@endsection

@include('main-module.createBranch')
