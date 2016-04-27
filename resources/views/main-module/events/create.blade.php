<div class="modal fade create_event" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Форма добавления события</h4>
            </div>
            {!! Form::open(array('class' => 'form-horizontal events_store')) !!}
            <div class="modal-body">
                @include('main-module/events.formFields')
            </div>

            <div class="modal-footer">
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="button" class="btn btn-raised btn-warning" data-dismiss="modal">Закрыть</button>
                        {!! Form::submit('Сохранить', ['class' => 'btn btn-raised btn-success']) !!}
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>