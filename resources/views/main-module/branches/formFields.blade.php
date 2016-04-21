<div class="modal-body">

    <div class="form-group">
        <div class="col-sm-10">
            {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Название', 'autofocus']) !!}
        </div>
    </div>


</div>
<div class="modal-footer">
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="button" class="btn btn-raised btn-warning" data-dismiss="modal">Закрыть</button>
            <button type="submit" class="btn btn-raised btn-success">Сохранить</button>
        </div>
    </div>
</div>