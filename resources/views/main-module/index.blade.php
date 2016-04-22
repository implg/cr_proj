@extends('layouts.app')

@section('title')
    Предприятия
@endsection

@section('content')

    <div class="row">

        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        <div class="col-md-12">

            @if (Sentry::getUser()->hasAccess('admin'))
                <a href="#" class="btn btn-raised btn-primary btn-sm" data-toggle="modal" data-target=".branch-modal">Добавить
                    филиал</a>
            @endif

            <a href="#" class="btn btn-raised btn-primary btn-sm" data-toggle="modal" data-target=".create-group">Добавить
                группу</a>
            <a href="{{ route('company.create') }}" class="btn btn-raised btn-primary btn-sm">Добавить предприятие</a>
            <hr>
        </div>
    </div>

    <div class="row filter">
        <div class="col-md-12">
            @if(count($branches))
                <div class="pull-left">
                    <div class="selectbox">
                        <select class="selectpicker" title="Выберите филиал...">
                            @foreach($branches as $branch)
                                <option>{{ $branch->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            @endif


            @if(count($groups))
                <div class="pull-left">
                    <div class="selectbox">
                        <select class="selectpicker" title="Выберите группу...">
                            @foreach($groups as $group)
                                <option>{{ $group->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <div id="companies" class="row">
        <div class="company-table">
            <div class="col-md-12">
                <table class="table table-bordered" id="company-table">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Название</th>
                        <th>Филиал</th>
                        <th>Группа</th>
                        <th>Статус</th>
                        <th>Телефоны</th>
                        <th>Директор</th>
                        <th>Email</th>
                        <th>Действия</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <div id="events">

    </div>

@endsection

@include('main-module/branches.branchCreateModal')
@include('main-module/groups-company.groupCreateModal')

@push('scripts')
<script>
    $(function () {


        var table = $('#company-table').DataTable({
            processing: true,
            serverSide: true,
            paging: false,
            info: false,
            oLanguage: {
                sSearch: "Поиск:",
                sZeroRecords: "Ничего не найдено",
                sProcessing: "Загрузка"
            },
            ajax: '{!! route('company.index') !!}',
            columns: [
                {data: 'id', name: 'company.id', title: 'Id'},
                {data: 'name', name: 'company.name', title: 'Название'},
                {data: 'branch_name', name: 'branch_id', title: 'Филиал'},
                {data: 'group_name', name: 'group_id', title: 'Группа'},
                {data: 'status', name: 'company.status', title: 'Статус', className: "status-column"},
                {data: 'phones', name: 'company.phones', title: 'Телефоны'},
                {data: 'director', name: 'company.director', title: 'Директор'},
                {data: 'email', name: 'company.email', title: 'Email'},
                {data: 'action', name: 'action', orderable: false, searchable: false, width: "8%", className: "text-center"}
            ]
        });

        $('#company-table tbody').on('click', 'tr', function () {
//            var data = table.row( this ).data();
//            alert( 'You clicked on '+data[0]+'\'s row' );
        });
    });

    function deleteName(f) {

        $.confirm({
            title: 'Удалить предприятие',
            theme: 'black',
            confirmButton: 'Удалить',
            cancelButton: 'Отмена',
            content: 'Вы уверены, что хотите удалить это предприятие?<br>Эта операция не восстановима.',
            confirm: function () {
                f.submit();
            }
        });
    }
</script>
@endpush
