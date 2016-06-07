<div class="row">
    <div class="col-md-7">
        <div class="form-group">
            {!! Form::label('branch_id', 'Филиал', ['class' => 'control-label']) !!}
            <div class="selectbox">
                {!! Form::select('branch_id', $branches->lists('name', 'id'), null,
                    [
                        'title' => 'Выберите филиал...',
                        'class' => 'selectpicker form-control',
                        'required'
                    ]
                ) !!}
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('group_id', 'Группа', ['class' => 'control-label']) !!}
            <div class="selectbox">
                {!! Form::select('group_id', $groups->lists('name', 'id'), null,
                    [
                        'title' => 'Выберите группу...',
                        'class' => 'selectpicker form-control',
                        'required'
                    ]
                ) !!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('manager_id', 'Менеджер', ['class' => 'control-label']) !!}
            <div class="selectbox">
                {!! Form::select('manager_id', $users->lists('full_name', 'id'), null,
                    [
                        'title' => 'Выберите менеджера...',
                        'class' => 'selectpicker form-control',
                        'required'
                    ]
                ) !!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('status', 'Статус', ['class' => 'control-label']) !!}
            <div class="selectbox">
                {!! Form::select('status', [
                        'Без статуса',
                        'Черный список',
                        'Налаживаем контакт',
                        'Работаем',
                        'VIP',
                    ], null,
                    [
                        'title' => 'Выберите статус...',
                        'class' => 'selectpicker form-control',
                        'required'
                    ]
                ) !!}
            </div>
        </div>

        <div class="form-group label-floating">
            {!! Form::label('name', 'Наименование предприятия', ['class' => 'control-label']) !!}
            {!! Form::text('name', null, ['class' => 'form-control', 'required'] ) !!}
        </div>

        <div class="form-group label-floating">
            {!! Form::label('phone_accountant', 'Телефон бухгалтера', ['class' => 'control-label']) !!}
            {!! Form::text('phone_accountant', null, ['class' => 'form-control'] ) !!}
        </div>

        <div class="form-group label-floating">
            {!! Form::label('phones', 'Телефоны', ['class' => 'control-label']) !!}
            {!! Form::text('phones', null, ['class' => 'form-control'] ) !!}
        </div>

        <div class="form-group label-floating">
            {!! Form::label('director', 'Директор', ['class' => 'control-label']) !!}
            {!! Form::text('director', null, ['class' => 'form-control'] ) !!}
        </div>

        <div class="form-group label-floating">
            {!! Form::label('address_legal', 'Адрес юридический', ['class' => 'control-label']) !!}
            {!! Form::text('address_legal', null, ['class' => 'form-control'] ) !!}
        </div>

        <div class="form-group label-floating">
            {!! Form::label('address_physical', 'Адрес фактический', ['class' => 'control-label']) !!}
            {!! Form::text('address_physical', null, ['class' => 'form-control'] ) !!}
        </div>

        <div class="form-group label-floating">
            {!! Form::label('city', 'Город', ['class' => 'control-label']) !!}
            {!! Form::text('city', null, ['class' => 'form-control'] ) !!}
        </div>

        <div class="form-group">
            {!! Form::submit('Сохранить', ['class' => 'btn btn-raised btn-success']) !!}
        </div>
    </div>
    <div class="col-md-5">
        <div class="form-group label-floating">
            {!! Form::label('site', 'Сайт', ['class' => 'control-label']) !!}
            {!! Form::text('site', null, ['class' => 'form-control'] ) !!}
        </div>

        <div class="form-group label-floating">
            {!! Form::label('employee', 'Сотрудник', ['class' => 'control-label']) !!}
            {!! Form::text('employee', null, ['class' => 'form-control'] ) !!}
        </div>

        <div class="form-group label-floating">
            {!! Form::label('email', 'E-mail', ['class' => 'control-label']) !!}
            {!! Form::text('email', null, ['class' => 'form-control'] ) !!}
        </div>

        <div class="form-group label-floating">
            {!! Form::label('isq', 'ICQ', ['class' => 'control-label']) !!}
            {!! Form::text('isq', null, ['class' => 'form-control'] ) !!}
        </div>

        <div class="form-group label-floating">
            {!! Form::label('skype', 'Skype', ['class' => 'control-label']) !!}
            {!! Form::text('skype', null, ['class' => 'form-control'] ) !!}
        </div>

        <div class="form-group label-floating">
            {!! Form::label('facebook', 'Facebook', ['class' => 'control-label']) !!}
            {!! Form::text('facebook', null, ['class' => 'form-control'] ) !!}
        </div>

        <div class="form-group label-floating">
            {!! Form::label('vk', 'VKontakte', ['class' => 'control-label']) !!}
            {!! Form::text('vk', null, ['class' => 'form-control'] ) !!}
        </div>

        <div class="form-group label-floating">
            {!! Form::label('postcode', 'Почтовый индекс', ['class' => 'control-label']) !!}
            {!! Form::text('postcode', null, ['class' => 'form-control'] ) !!}
        </div>

        <div class="form-group label-floating">
            {!! Form::label('okpo', 'ОКПО', ['class' => 'control-label']) !!}
            {!! Form::text('okpo', null, ['class' => 'form-control'] ) !!}
        </div>

        <div class="form-group label-floating">
            {!! Form::label('inn', 'ИНН', ['class' => 'control-label']) !!}
            {!! Form::text('inn', null, ['class' => 'form-control'] ) !!}
        </div>

        <div class="form-group label-floating">
            {!! Form::label('num_certificate', '№ Свидетельства', ['class' => 'control-label']) !!}
            {!! Form::text('num_certificate', null, ['class' => 'form-control'] ) !!}
        </div>
    </div>
</div>



