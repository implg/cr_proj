@extends(config('sentinel.layout'))

{{-- Web site Title --}}
@section('title')
    @parent
    Users
@stop

{{-- Content --}}
@section('content')
    <div class="row">
        <div class="col-md-10  col-md-offset-1">
            <div class='page-header'>
                <div class='btn-toolbar pull-right'>
                    <div class='btn-group'>
                        <a class='btn btn-raised btn-primary' href="{{ route('sentinel.users.create') }}">Создать пользователя</a>
                    </div>
                </div>
                <h1>Список пользователей</h1>
            </div>

            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                    <th>Имя</th>
                    <th>Логин</th>
                    <th>Статус</th>
                    <th>Действия</th>
                    </thead>
                    <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td><a href="{{ route('sentinel.users.show', array($user->hash)) }}">{{ $user->first_name }} {{ $user->last_name }}</a></td>
                            <td>{{ $user->username }} </td>
                            <td>{{ $user->status == 'Banned'? 'Заблокирован' : 'Активен' }} </td>
                            <td>
                                <button class="btn btn-raised btn-success btn-sm" type="button" onClick="location.href='{{ route('sentinel.users.edit', array($user->hash)) }}'">Изменить</button>
                                @if ($user->status != 'Banned')
                                    <button class="btn btn-raised btn-warning btn-sm" type="button" onClick="location.href='{{ route('sentinel.users.ban', array($user->hash)) }}'">Заблокировать</button>
                                @else
                                    <button class="btn btn-raised btn-warning btn-sm" type="button" onClick="location.href='{{ route('sentinel.users.unban', array($user->hash)) }}'">Разблокировать</button>
                                @endif
                                <button class="btn btn-raised btn-danger action_confirm btn-sm" href="{{ route('sentinel.users.destroy', array($user->hash)) }}" data-token="{{ Session::getToken() }}" data-method="delete">Удалить</button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="row">
        {!! $users->render() !!}
    </div>
@stop
