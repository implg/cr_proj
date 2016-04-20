@extends('layouts.app')

@section('title')
    Создать предприятие
@endsection

@section('content')
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="page-header">
                <h2>Создать предприятие</h2>
            </div>

            <div class="col-md-12">
                {!! Form::open(['route' => 'company.store']) !!}

                @include('main-module/company.form')

                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection