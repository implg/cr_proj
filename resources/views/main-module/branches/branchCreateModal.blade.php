<div class="modal fade branch-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Создать филиал</h4>
            </div>
            {!! Form::open(array('route' => 'branches.store', 'class' => 'form-horizontal')) !!}
                @include('main-module/branches.formFields')
            {!! Form::close() !!}
        </div>
    </div>
</div>