@extends('layouts.app')

@section('title')
    Задачи
@endsection

@section('content')

    <?php
    $users = Users::getAllUser();
    $companies = \App\Http\Controllers\CompanyController::getAllCompany()
    ?>

<div class="row">
    <div class="col-md-12">
        <div class="page-header">
            <h2>Задачи</h2>
        </div>

        {!! Form::open(array('id' => 'filter-form')) !!}

        <div class="pull-left">
            {!! Form::label('userId', 'Пользователь') !!}
            {!! Form::select('userId', ['' => '', 'Выберите' => $users->lists('full_name', 'id')], null, ['class' => 'custom-select']) !!}
        </div>
        <div class="pull-left">
            {!! Form::label('responsibleId', 'Ответственный') !!}
            {!! Form::select('responsibleId', ['' => '', 'Выберите' => $users->lists('full_name', 'id')], null, ['class' => 'custom-select']) !!}
        </div>
        <div class="pull-left">
            {!! Form::label('status', 'Статус') !!}
            {!! Form::select('status', ['' => '', 'Выберите' => ['Новая', 'В работе', 'Выполнена']], null, ['class' => 'custom-select event_status']) !!}
        </div>
        <div class="pull-left">
            {!! Form::label('companyId', 'Предприятие') !!}
            {!! Form::select('companyId', ['' => '', 'Выберите' => $companies->lists('name', 'id')], null, ['class' => 'custom-select event_status']) !!}
        </div>
        <div class="pull-left">
            {!! Form::submit('Поиск', ['class' => 'btn btn-raised btn-success btn-sm']) !!}
        </div>
        <div class="pull-left">
            <button class="btn btn-raised btn-danger btn-sm filter_reset" type="reset">Сбросить</button>
        </div>
        {!! Form::close() !!}

        <table class="table table-bordered" id="task-events">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Создатель</th>
                    <th>Ответственный</th>
                    <th>Статус</th>
                    <th>Предприятие</th>
                    <th>Актуальность</th>
                    <th>Описание</th>
                    <th>Действия</th>
                </tr>
            </thead>
        </table>
        </div>
    </div>
</div>
@include('main-module/events.update')
@endsection



@push('scripts')
<script>
    $(function() {

        var oTable = $('#task-events').DataTable({
            processing: true,
            //serverSide: true,
            bFilter: false,
            lengthMenu: [[25, 50, -1], [25, 50, "Все"]],
            language: {
                processing: "Подождите...",
                search: "Поиск:",
                lengthMenu: "Показать _MENU_ задач",
                info: "Задачи с _START_ до _END_ из _TOTAL_ задач",
                infoEmpty: "Задачи с 0 до 0 из 0 задач",
                infoFiltered: "(отфильтровано из _MAX_ задач)",
                infoPostFix: "",
                loadingRecords: "Загрузка задач...",
                zeroRecords: "Задачи отсутствуют.",
                emptyTable: "В таблице отсутствуют данные",
                paginate: {
                    first: "Первая",
                    previous: "Предыдущая",
                    next: "Следующая",
                    last: "Последняя"
                },
                aria: {
                    sortAscending: ": активировать для сортировки столбца по возрастанию",
                    sortDescending: ": активировать для сортировки столбца по убыванию"
                }
            },
            ajax: {
                url: '{{ route('tasks.data') }}',
                data: function (d) {
                    d.userId = $('select[name=userId]').val();
                    d.responsibleId = $('select[name=responsibleId]').val();
                    d.status = $('select[name=status]').val();
                    d.companyId = $('select[name=companyId]').val();
                }
            }
        });

        $('#filter-form').on('submit', function(e) {
            oTable.draw();
            e.preventDefault();
        });

        $('.filter_reset').on('click', function (e) {
            e.preventDefault();
            $('select[name=userId]').val("");
            $('select[name=responsibleId]').val("");
            $('select[name=status]').val("");
            $('select[name=companyId]').val("");
            oTable.draw();
        });
    });
</script>
@endpush
