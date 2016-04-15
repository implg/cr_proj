<div class="modal fade create-branch">
    <div class="modal-dialog">
        <div class="modal-content">
            {!! Form::open(array('route' => 'create-branch', 'class' => 'form-horizontal')) !!}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Создать филиал</h4>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <div class="col-sm-10">
                            <input type="email" class="form-control" id="inputEmail3" placeholder="Название" autofocus>
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
            {!! Form::close() !!}
        </div>
    </div>
</div>