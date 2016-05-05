@extends('layouts.app')

@section('title')
    Логи
@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="page-header">
            <h2>Логи</h2>
        </div>

        <form id="filter-form">
            <div class="pull-left">
                <label for="inputEmail3" class="control-label">Диапазон времени, от:</label>
                <input type="text" class="custom-input datetimepicker2" name="date-start">
            </div>
            <div class="pull-left">
                <label for="inputEmail3" class="control-label">Диапазон времени, до:</label>
                <input type="text" class="custom-input datetimepicker2" name="date-end">
            </div>
            <div class="pull-left">
                <button class="btn btn-raised btn-success btn-sm" type="submit">Поиск</button>
            </div>
        </form>

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
            paging: false,
            info: false,
            oLanguage: {
                sSearch: "Поиск:",
                sZeroRecords: "Ничего не найдено",
                sProcessing: "Загрузка"
            },
            ajax: {
                url: '{{ route('logs.data') }}',
                data: function (d) {
                    d.dateStart = $('input[name=date-start]').val();
                    d.dateEnd = $('input[name=date-end]').val();
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
