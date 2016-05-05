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
            <a href="" class="btn btn-raised btn-warning btn-sm add_event" data-toggle="modal"
               data-target=".create_event">Добавить событие</a>
            <hr>
        </div>
    </div>

    <div class="row filter">
        <div class="col-md-12">
            <form id="search-form" method="POST" role="form">
                @if(count($branches))
                    <div class="pull-left">
                        <div class="selectbox">
                            <select id="branch_id" name="branch_id" class="form_select">
                                <option value="">Выберите филиал...</option>
                                @foreach($branches as $branch)
                                    <option value="{{ $branch->name }}">{{ $branch->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                @endif


                @if(count($groups))
                    <div class="pull-left">
                        <div class="selectbox">
                            <select id="group_id" name="group_id" class="form_select">
                                <option value="">Выберите группу...</option>
                                @foreach($groups as $group)
                                    <option value="{{ $group->name }}">{{ $group->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                @endif

                <div class="pull-left">
                    <div class="selectbox">
                        <select id="status" name="status" class="form_select">
                            <option value="">Выберите статус...</option>
                            <option value="0">Без статуса</option>
                            <option value="1">Черный список</option>
                            <option value="2">Налаживаем контакт</option>
                            <option value="3">Работаем</option>
                            <option value="4">VIP</option>
                        </select>
                    </div>
                </div>

                <div class="pull-left">
                    <button class="btn btn-raised btn-success btn-sm" type="submit">Поиск</button>
                </div>
                <div class="pull-left">
                    <button class="btn btn-raised btn-danger btn-sm filter_reset" type="reset">Сбросить</button>
                </div>
            </form>
        </div>
    </div>

    <div id="split" class="row">
        <div class="topPane">
            <div id="companies">
                <div class="company-table">
                    <div class="col-md-12">
                        <table class="table table-bordered" id="company-table">
                            <thead>
                            <tr>
                                <th>Id</th>
                                <th>Название</th>
                                <th>Филиал</th>
                                <th>Группа</th>
                                <th>Менеджер</th>
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
        </div>
        <div class="bottomPane">
            <div id="events"></div>
        </div>
    </div>

    @include('main-module/branches.branchCreateModal')
    @include('main-module/groups-company.groupCreateModal')
    @include('main-module/events.create')
    @include('main-module/events.update')
@endsection



@push('scripts')
<script>
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
            ajax: {
                url: '{!! route('company.index') !!}',
                data: function (d) {
                    d.branch_id = $('#branch_id').val();
                    d.group_id = $('#group_id').val();
                    d.status = $('#status').val();
                }
            },
            columns: [
                {data: 'id', name: 'company.id', title: 'Id'},
                {data: 'name', name: 'company.name', title: 'Название'},
                {data: 'branch_name', name: 'branch_id', title: 'Филиал'},
                {data: 'group_name', name: 'group_id', title: 'Группа'},
                {data: 'full_name', title: 'Менеджер', className: "bold"},
                {data: 'status', name: 'company.status', title: 'Статус', className: "status-column"},
                {data: 'phones', name: 'company.phones', title: 'Телефоны'},
                {data: 'director', name: 'company.director', title: 'Директор'},
                {data: 'email', name: 'company.email', title: 'Email'},
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false,
                    width: "8%",
                    className: "text-center"
                }
            ]
        });

        $('#search-form').on('submit', function (e) {
            e.preventDefault();
            table.draw();
        });

        $('.filter_reset').on('click', function (e) {
            e.preventDefault();
            $('#branch_id').val("");
            $('#group_id').val("");
            $('#status').val("");
            $('.event_type').val("");
            table.draw();
        });

        $('#company-table tbody').on('click', 'tr', function () {
            if ($(this).hasClass('selected')) {
                $(this).removeClass('selected');
                $('.add_event').fadeOut();
            } else {
                table.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');
                var rowID = $(this).data('id');
                $('.add_event').data('company-id', rowID).fadeIn();

                // Get events for company
                $.ajax({
                    url: 'events-company/' + rowID,
                    type: 'get',
                    data: {
                        'companyId': rowID
                    },
                    success: function (data) {
                        $('#events').html(data);
                    }
                });
            }
        });

        // Add event
        $('body').on('submit', '.events_store', function (e) {
            e.preventDefault();
            var responsible_id = $('.responsible_id').val(),
                    company_id = $('.add_event').data('company-id'),
                    type = $('.event_type').val(),
                    text = $('.event_text').val(),
                    date = $('.event_date').val(),
                    reminder = $('.event_reminder').prop('checked') ? 1 : 0;

            $.ajax({
                url: '{!! route('events.store') !!}',
                type: 'post',
                data: {
                    'responsible_id': responsible_id,
                    'company_id': company_id,
                    'type': type,
                    'text': text,
                    'date': date,
                    'reminder': reminder
                },
                success: function (data) {
                    $('.create_event').modal('hide');
                    jQuery('.events_store')[0].reset();

                    // Get events for company
                    $.ajax({
                        url: 'events-company/' + company_id,
                        type: 'get',
                        data: {
                            'companyId': company_id
                        },
                        success: function (data) {
                            $('#events').html(data);
                        }
                    });
                }
            });
        });

    });

</script>
@endpush
