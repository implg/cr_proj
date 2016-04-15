@extends(config('sentinel.layout'))

{{-- Web site Title --}}
@section('title')
@parent
Edit Group
@stop

{{-- Content --}}
@section('content')
<div class="row">
    <form method="POST" action="{{ route('sentinel.groups.update', $group->hash) }}" accept-charset="UTF-8">
        <div class="page-header">
            <h2>Редактирование группы</h2>
        </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">Название</div>
                        <div class="panel-body">
                            <div class="form-group {{ ($errors->has('name')) ? 'has-error' : '' }}">
                                <input class="form-control" placeholder="Name" name="name" value="{{ Request::old('name') ? Request::old('name') : $group->name }}" type="text">
                                {{ ($errors->has('name') ? $errors->first('name') : '') }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">Разрешения</div>
                        <div class="panel-body">
                            <div class="form-group">
                                <?php $defaultPermissions = config('sentinel.default_permissions', []); ?>
                                @foreach ($defaultPermissions as $permission)
                                    <label class="checkbox-inline">
                                        <input name="permissions[{{ $permission }}]" value="1" type="checkbox" {{ (isset($permissions[$permission]) ? 'checked' : '') }}>
                                        {{ ucwords($permission) }}
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <input name="_method" value="PUT" type="hidden">
            <input name="_token" value="{{ csrf_token() }}" type="hidden">
            <input class="btn btn-success" value="Сохранить" type="submit">

    </form>
</div>

@stop