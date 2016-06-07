<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h4 class="modal-title">Форма редактирования события</h4>
</div>
@if(isset($event))
{!! Form::model($event, ['route' => ['events.update', $event->id], 'class' => 'form-horizontal events_update', 'method' => 'put']) !!}
<div class="modal-body change_task">
    <div class="row">
        <?php
        $users = Users::getAllUser();
        ?>
        <div class="col-md-12">
            {!! Form::label('text', 'Описание') !!}
            {!! Form::textarea('text', null, ['class' => 'custom-textarea event_text', 'autofocus', 'required']) !!}

            {!! Form::label('responsible_id', 'Выберите ответственного') !!}
            {!! Form::select('responsible_id', $users->lists('full_name', 'id'), null, ['class' => 'custom-select responsible_id']) !!}

            @if($event->type == 1)
                {!! Form::label('status', 'Статус') !!}
                {!! Form::select('status', ['Новая', 'В работе', 'Выполнена'], null, ['class' => 'custom-select event_status']) !!}

                <div class="comment-task-complete">
                    {!! Form::label('taskComplete', 'Комментарий после выполнения') !!}
                    {!! Form::textarea('taskComplete', null, ['class' => 'custom-textarea taskComplete']) !!}
                </div>
            @endif

            {!! Form::label('type', 'Тип') !!}
            {!! Form::select('type', ['Событие', 'Задача'], null, ['class' => 'custom-select event_type']) !!}

            <p class="alert alert-warning">Обязательно укажите дату напоминания или "не напоминать":</p>

            {!! Form::label('date', 'Актуальная дата и время') !!}
            {!! Form::text('date', null, ['class' => 'custom-input event_date datetimepicker3']) !!}


            <div class="checkbox">
                <label>
                    {!! Form::checkbox('reminder', null, false, ['class' => 'event_reminder']) !!} Не напоминать
                </label>
            </div>
        </div>
    </div>
</div>

<div class="modal-footer">
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="button" class="btn btn-raised btn-warning" data-dismiss="modal">Закрыть</button>
            {!! Form::submit('Сохранить', ['class' => 'btn btn-raised btn-success', 'data-event-id' => $event->id]) !!}
        </div>
    </div>
</div>
{!! Form::close() !!}
@endif()