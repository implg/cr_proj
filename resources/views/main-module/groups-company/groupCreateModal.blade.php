<div class="modal fade create-group">
    <div class="modal-dialog">
        <div class="modal-content">
            {!! Form::open(array('route' => 'groups-company.store', 'class' => 'form-horizontal')) !!}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Создать группу</h4>
            </div>
            <div class="modal-body">

                @include('main-module/groups-company.formFields')


            </div>
            <div class="modal-footer">
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="button" class="btn btn-raised btn-warning" data-dismiss="modal">Закрыть</button>
                        {!! Form::submit('Сохранить', ['class' => 'btn btn-raised btn-success' ]) !!}
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>