@extends('layouts.app')

@section('title')
    Филиалы
@endsection

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="page-header">
                <h2>Филиалы</h2>
            </div>
        </div>
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
                    <a href="#" class="btn btn-raised btn-primary btn-sm" data-toggle="modal" data-target=".branch-modal">Изменить
                        филиал</a>

                    {!! Form::open(['method' => 'DELETE', 'route' => ['branches.destroy', $branch->id], 'onsubmit' => 'deleteBranch(this);return false;']) !!}
                        {!! Form::submit('Удалить', ['class' => 'btn btn-raised btn-danger btn-sm']) !!}
                    {!! Form::close() !!}
                </td>

            </tr>
        @endforeach
        </tbody>
    </table>


@endsection

@include('main-module/branches.branchUpdateModal', ['branches' => $branches])

@push('scripts')
<script>
    function deleteBranch(f) {
        $.confirm({
            title: 'Удалить филиал?',
            theme: 'black',
            confirmButton: 'Удалить',
            cancelButton: 'Отмена',
            content: 'Вы уверены, что хотите удалить этот филиал?',
            confirm: function(){
                f.submit();
            }
        });
    }
</script>
