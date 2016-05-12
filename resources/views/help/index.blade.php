@extends('layouts.app')

@section('title')
    Помощь
@endsection

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="page-header">
                @if(Sentry::getUser()->hasAccess('admin'))
                    <a href="{{ route('help.create') }}" class="btn btn-raised btn-primary pull-right">Добавить
                        статью</a>
                @endif
                <h2>Помощь</h2>
            </div>

            @if($articles)
                <div class="row">
                    <div class="col-md-12">
                        @foreach($articles as $article)
                            <div class="article_item">
                                <h2>
                                    <a href="{{ route('help.show', $article['id']) }}">{{ $article['title'] }}</a>
                                    @if($article['addressee'] != 0)
                                        <small>Для пользователя: {{ Users::getUserName($article['addressee']) }}</small>
                                    @endif

                                </h2>
                                {!! mb_substr(strip_tags($article['text']), 0, 250, 'UTF-8') !!}
                                @if(Sentry::getUser()->hasAccess('admin'))
                                    <div class="control">
                                        {!! Form::open(['method' => 'DELETE', 'route' => ['help.destroy', $article->id], 'onsubmit' => 'deleteArticle(this);return false;']) !!}
                                        <a href="{{ route('help.edit', $article['id']) }}"
                                           class="btn btn-raised btn-success btn-sm">Изменить</a>
                                        {!! Form::submit('Удалить', ['class' => 'btn btn-raised btn-danger btn-sm']) !!}
                                        {!! Form::close() !!}
                                    </div>
                                @endif
                            </div>
                            <hr>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
    @include('main-module/events.update')
@endsection

@push('scripts')
<script>
    function deleteArticle(f) {
        $.confirm({
            title: 'Удалить статью?',
            theme: 'black',
            confirmButton: 'Удалить',
            cancelButton: 'Отмена',
            content: '',
            confirm: function () {
                f.submit();
            }
        });
    }
    ;
</script>
@endpush
