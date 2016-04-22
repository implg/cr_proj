@extends('layouts.app')

@section('title')
    Группы
@endsection

@section('content')

    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="page-header">
                <a href="#" class="btn btn-raised btn-primary pull-right" data-toggle="modal"
                   data-target=".create-group">Добавить
                    Группу</a>
                <h2>Группы</h2>
            </div>

            <table class="table table-striped table-hover">
                <thead>
                <th>Название</th>
                <th></th>
                </thead>
                <tbody>
                @foreach ($groups as $group)
                    <tr>
                        <td>{{ $group->name }}</td>
                        <td>
                            <a href="{{ route('groups-company.edit', $group->id) }}"
                               class="btn btn-raised btn-primary btn-sm pull-left">Изменить</a>

                            {!! Form::open(['method' => 'DELETE', 'route' => ['groups-company.destroy', $group->id], 'onsubmit' => 'deleteBranch(this);return false;']) !!}
                            {!! Form::submit('Удалить', ['class' => 'btn btn-raised btn-danger btn-sm pull-left']) !!}
                            {!! Form::close() !!}
                        </td>

                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@include('main-module/groups-company.groupCreateModal')

@push('scripts')
<script>
    function deleteBranch(f) {
        $.confirm({
            title: 'Удалить группу?',
            theme: 'black',
            confirmButton: 'Удалить',
            cancelButton: 'Отмена',
            content: 'Вы уверены, что хотите удалить эту группу?',
            confirm: function () {
                f.submit();
            }
        });
    }
</script>
