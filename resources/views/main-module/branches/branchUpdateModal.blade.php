<div class="modal fade branch-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Изменить</h4>
            </div>
            {!! Form::model($branches, ['route' => ['branches.update', $branch->id], 'class' => 'form-horizontal', 'method' => 'put']) !!}
            @include('main-module/branches.formFields')
            {!! Form::close() !!}
        </div>
    </div>
</div>