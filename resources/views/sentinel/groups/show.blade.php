@extends(config('sentinel.layout'))

{{-- Web site Title --}}
@section('title')
    @parent
    Просмотр группы
@stop

{{-- Content --}}
@section('content')
    <div class="page-header">
        <h2>Группа: {{ $group['name'] }}</h2>
    </div>

    <div class="well clearfix">
        <div class="col-md-10">
            <h4>Разрешения:</h4>
            <ul>
                @foreach ($group->getPermissions() as $key => $value)
                    <li>{{ ucfirst($key) }}</li>
                @endforeach
            </ul>
        </div>
        <div class="col-md-2">
            <a class="btn btn-primary" href="{{ route('sentinel.groups.edit', array($group->hash)) }}">Редактировать</a>
        </div>
    </div>

@stop
