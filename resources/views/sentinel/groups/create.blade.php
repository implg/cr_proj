@extends(config('sentinel.layout'))

{{-- Web site Title --}}
@section('title')
    @parent
    Создать группу
@stop

{{-- Content --}}
@section('content')
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <form method="POST" action="{{ route('sentinel.groups.store') }}" accept-charset="UTF-8">

                <div class="page-header">
                    <h2>Создать новую группу</h2>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">Название</div>
                            <div class="panel-body">
                                <div class="form-group {{ ($errors->has('name')) ? 'has-error' : '' }}">
                                    <input class="form-control" placeholder="Название" name="name" type="text"
                                           value="{{ Request::old('email') }}">
                                    {{ ($errors->has('name') ? $errors->first('name') : '') }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">Разрешения</div>
                            <div class="panel-body">
                                <div class="form-group checkbox">
                                    <?php $defaultPermissions = config('sentinel.default_permissions', []); ?>
                                    @foreach ($defaultPermissions as $permission)
                                        <label class="checkbox-inline">
                                            <input name="permissions[{{ $permission }}]" value="1" type="checkbox"
                                                   @if (Request::old('permissions[' . $permission .']'))
                                                   checked
                                                    @endif
                                            > {{ ucwords($permission) }}
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <input name="_token" value="{{ csrf_token() }}" type="hidden">
                <input class="btn btn-raised btn-success" value="Создать" type="submit">

            </form>
        </div>
    </div>

@stop