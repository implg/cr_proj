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

        <table class="table table-bordered" id="task-events">
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
    {{--$(function() {--}}
        {{--$('#task-events').DataTable({--}}
            {{--processing: true,--}}
            {{--serverSide: true,--}}
            {{--paging: false,--}}
            {{--info: false,--}}
            {{--oLanguage: {--}}
                {{--sSearch: "Поиск:",--}}
                {{--sZeroRecords: "Ничего не найдено",--}}
                {{--sProcessing: "Загрузка"--}}
            {{--},--}}
            {{--ajax: '{{ route('tasks.data') }}',--}}
            {{--columns: [--}}
                {{--null,--}}
                {{--{ "width": "10%", className: "bold" },--}}
                {{--{ "width": "12%", className: "bold" },--}}
                {{--{ "width": "12%"},--}}
                {{--{ "width": "12%" },--}}
                {{--{ "width": "49%" },--}}
                {{--{--}}
                    {{--width: "8%",--}}
                    {{--className: "text-center"--}}
                {{--}--}}
            {{--]--}}
        {{--});--}}
    {{--});--}}
</script>
@endpush
