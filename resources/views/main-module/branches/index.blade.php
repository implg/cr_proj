@extends('layouts.app')

@section('title')
    Филиалы
@endsection

@section('content')

    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="page-header">
                <a href="#" class="btn btn-raised btn-primary pull-right" data-toggle="modal"
                   data-target=".branch-modal">Добавить филиал</a>
                <h2>Филиалы</h2>
            </div>

            <table class="table table-striped table-hover">
                <thead>
                <th>Название</th>
                <th></th>
                </thead>
                <tbody>
                @foreach ($branches as $branch)
                    <tr>
                        <td>{{ $branch->name }}</td>
                        <td>
                            <a href="{{ route('branches.edit', $branch->id) }}"
                               class="btn btn-raised btn-primary btn-sm pull-left">Изменить</a>

                            {!! Form::open(['method' => 'DELETE', 'route' => ['branches.destroy', $branch->id], 'onsubmit' => 'deleteBranch(this);return false;']) !!}
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

@include('main-module/branches.branchCreateModal')

@push('scripts')
<script>
    function deleteBranch(f) {
        $.confirm({
            title: 'Удалить филиал?',
            theme: 'black',
            confirmButton: 'Удалить',
            cancelButton: 'Отмена',
            content: 'Вы уверены, что хотите удалить этот филиал?',
            confirm: function () {
                f.submit();
            }
        });
    }
</script>
