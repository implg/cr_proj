@extends('layouts.app')

@section('title')
    Логи
@endsection

@section('content')
    <?php
    $users = Users::getAllUser();
    ?>
<div class="row">
    <div class="col-md-12">
        <div class="page-header">
            <h2>Логи</h2>
        </div>

        {!! Form::open(array('id' => 'filter-form')) !!}
            <div class="pull-left">
                {!! Form::label('userId', 'Пользователь') !!}
                {!! Form::select('userId', ['' => '', 'Выберите' => $users->lists('full_name', 'id')], null, ['class' => 'custom-select']) !!}
            </div><div class="pull-left">
                {!! Form::label('date-start', 'Диапазон времени, от:') !!}
                {!! Form::text('date-start', null, ['class' => 'custom-input datetimepicker2']) !!}
            </div>
            <div class="pull-left">
                {!! Form::label('date-end', 'Диапазон времени, до:') !!}
                {!! Form::text('date-end', null, ['class' => 'custom-input datetimepicker2']) !!}
            </div>
            <div class="pull-left">
                {!! Form::submit('Поиск', ['class' => 'btn btn-raised btn-success btn-sm']) !!}
            </div>
        {!! Form::close() !!}

        <table class="table table-bordered" id="logs">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Время</th>
                    <th>Пользователь</th>
                    <th>Действие</th>
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


        var oTable = $('#logs').DataTable({
            processing: true,
            serverSide: true,
            bFilter: false,
            lengthMenu: [[25, 50, -1], [25, 50, "Все"]],
            language: {
                processing: "Подождите...",
                search: "Поиск:",
                lengthMenu: "Показать _MENU_ записей",
                info: "Записи с _START_ до _END_ из _TOTAL_ записей",
                infoEmpty: "Записи с 0 до 0 из 0 записей",
                infoFiltered: "(отфильтровано из _MAX_ записей)",
                infoPostFix: "",
                loadingRecords: "Загрузка записей...",
                zeroRecords: "Записи отсутствуют.",
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
                url: '{{ route('logs.data') }}',
                data: function (d) {
                    d.dateStart = $('input[name=date-start]').val();
                    d.dateEnd = $('input[name=date-end]').val();
                    d.userId = $('select[name=userId]').val();
                }
            }
        });

        $('#filter-form').on('submit', function(e) {
            oTable.draw();
            e.preventDefault();
        });
    });
</script>
@endpush
