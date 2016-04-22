@extends(config('sentinel.layout'))

{{-- Web site Title --}}
@section('title')
    @parent
    Просмотр группы
@stop

{{-- Content --}}
@section('content')
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="page-header">
                <h2>Группа: {{ $group['name'] }}</h2>
            </div>

            <div class="well clearfix">
                <div class="col-md-10">
                    <h3>Разрешения:</h3>
                    <ul>
                        @foreach ($group->getPermissions() as $key => $value)
                            <li>{{ ucfirst($key) }}</li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-md-2"><br>
                    <a class="btn btn-raised btn-primary"
                       href="{{ route('sentinel.groups.edit', array($group->hash)) }}">Редактировать</a>
                </div>
            </div>
        </div>
    </div>
@stop
