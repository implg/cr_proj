@extends('layouts.app')

@section('title')
    {{ $article->title }}
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="page-header">
                <h2>{{ $article->title }}</h2>
            </div>
            {!! $article->text !!}
        </div>
    </div>
    @include('main-module/events.update')
@endsection