@extends(config('sentinel.layout'))

{{-- Web site Title --}}
@section('title')
@parent
Home
@stop

{{-- Content --}}
@section('content')

    <?php
        // Determine the edit profile route
        if (($user->email == Sentry::getUser()->email)) {
            $editAction = route('sentinel.profile.edit');
        } else {
            $editAction =  action('\\Sentinel\Controllers\UserController@edit', [$user->hash]);
        }
    ?>

	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="well clearfix">

				<h3>Персональные данные</h3>
				<div class="col-md-8">
					@if ($user->first_name)
						<p><strong>Имя:</strong> {{ $user->first_name }} </p>
					@endif
					@if ($user->last_name)
						<p><strong>Фамилия:</strong> {{ $user->last_name }} </p>
					@endif
					<p><strong>Email:</strong> {{ $user->email }}</p>

				</div>
				<div class="col-md-4">
					<p><em>Дата создания: {{ $user->created_at }}</em></p>
					<p><em>Последнее обновление: {{ $user->updated_at }}</em></p>
					<button class="btn btn-raised btn-primary" onClick="location.href='{{ $editAction }}'">Изменить профиль</button>
				</div>
			</div>

			<?php $userGroups = $user->getGroups(); ?>
			<div class="well">
				<h3>Роли</h3>
				<ul>
					@if (count($userGroups) >= 1)
						@foreach ($userGroups as $group)
							<li>{{ $group['name'] }}</li>
						@endforeach
					@else
						<li>Нет ролей.</li>
					@endif
				</ul>
			</div>
		</div>
	</div>
@stop
