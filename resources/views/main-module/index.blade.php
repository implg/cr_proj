@extends('layouts.app')

@section('title')
   Предприятия
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2>Филиалы</h2>
            @if (Sentry::getUser()->hasAccess('admin'))
                <a href="#" class="btn btn-raised btn-success" data-toggle="modal" data-target=".create-branch">Добавить филиал</a>
            @endif
        </div>
    </div>
</div>
@endsection

@include('main-module.createBranch')
