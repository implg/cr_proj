@extends('layouts.app')

@section('title')
    Создание статьи
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="page-header">
                <h2>Создание статьи</h2>
            </div>

            {!! Form::open(array('route' => 'help.store')) !!}
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