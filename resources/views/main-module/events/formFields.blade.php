<div class="row">
    <?php
        $users = Users::getAllUser();
    ?>
    <div class="col-md-12">
        {!! Form::label('text', 'Добавить событие для предприятия') !!}
        {!! Form::textarea('text', null, ['class' => 'custom-textarea event_text', 'autofocus', 'required']) !!}

        {!! Form::label('responsible_id', 'Выберите ответственного') !!}
        {!! Form::select('responsible_id', $users->lists('full_name', 'id'), null, ['class' => 'custom-select responsible_id']) !!}

        {!! Form::label('type', 'Тип') !!}
        {!! Form::select('type', ['Событие', 'Задача'], null, ['class' => 'custom-select event_type']) !!}

        <p class="alert alert-warning">Обязательно укажите дату напоминания или "не напоминать":</p>

        {!! Form::label('date', 'Актуальная дата и время') !!}
        {!! Form::text('date', null, ['class' => 'custom-input event_date datetimepicker']) !!}


        <div class="checkbox">
            <label>
                {!! Form::checkbox('reminder', null, false, ['class' => 'event_reminder']) !!} Не напоминать
            </label>
        </div>
    </div>
</div>