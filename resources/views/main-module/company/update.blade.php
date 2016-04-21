@extends('layouts.app')

@section('title')
    Изменить предприятие
@endsection

@section('content')
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="page-header">
                <h2>Изменить предприятие</h2>
            </div>

            <div class="col-md-12">
                {!! Form::model($company, ['route' => ['company.update', $company->id], 'method' => 'put']) !!}

                @include('main-module/company.form')

                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection