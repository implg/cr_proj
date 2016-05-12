@extends('layouts.app')

@section('title')
    Редактированние статьи
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="page-header">
                <h2>Редактированние статьи</h2>
            </div>

            {!! Form::model($article, array('route' => ['help.update', $article->id], 'method' => 'put')) !!}
            @include('help.formFields')
            {!! Form::close() !!}

        </div>
    </div>
    @include('main-module/events.update')
@endsection



@push('scripts')
<script>
    $(document).ready(function() {
        var editor = CKEDITOR.replace('editor', {
            filebrowserBrowseUrl : '/elfinder/ckeditor'
        });
    });
</script>
@endpush