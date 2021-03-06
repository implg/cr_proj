@extends(config('sentinel.layout'))

{{-- Web site Title --}}
@section('title')
    @parent
    Группы пользователей
@stop

{{-- Content --}}
@section('content')
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class='page-header'>
                <div class='btn-toolbar pull-right'>
                    <div class='btn-group'>
                        <a class='btn btn-raised btn-primary' href="{{ route('sentinel.groups.create') }}">Создать
                            группу</a>
                    </div>
                </div>
                <h2>Доступные группы</h2>
            </div>


            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                    <th>Название</th>
                    <th>Разрешения</th>
                    <th>Действия</th>
                    </thead>
                    <tbody>
                    @foreach ($groups as $group)
                        <tr>
                            <td><a href="{{ route('sentinel.groups.show', $group->hash) }}">{{ $group->name }}</a></td>
                            <td>
                                <?php
                                $permissions = $group->getPermissions();
                                $keys = array_keys($permissions);
                                $last_key = end($keys);
                                ?>
                                @foreach ($permissions as $key => $value)
                                    {{ ucfirst($key) . ($key == $last_key ? '' : ', ') }}
                                @endforeach
                            </td>
                            <td>
                                <button class="btn btn-raised btn-success btn-sm"
                                        onClick="location.href='{{ route('sentinel.groups.edit', [$group->hash]) }}'">
                                    Изменить
                                </button>
                                <button class="btn btn-raised btn-danger btn-sm action_confirm {{ ($group->name == 'Admins') ? 'disabled' : '' }}"
                                        type="button" data-token="{{ csrf_token() }}" data-method="delete"
                                        href="{{ route('sentinel.groups.destroy', [$group->hash]) }}">Удалить
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="row">
        {!! $groups->render() !!}
    </div>
    <!--
        The delete button uses Resftulizer.js to restfully submit with "Delete".  The "action_confirm" class triggers an optional confirm dialog.
        Also, I have hardcoded adding the "disabled" class to the Admin group - deleting your own admin access causes problems.
    -->
@stop

