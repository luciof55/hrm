@extends('layouts.app')
@section('content')
<div class="row justify-content-center">
	<div class="col-md-8">
		<div class="card">
			<div class="card-header">@lang('messages.Account')</div>

			<div class="card-body">
				<form id="commandForm" method="POST" action="{{ $action }}">
					@csrf
					<input id="id" name="id" type="hidden" value="{{ $command->id }}">
					<input type="hidden" id="_method" name="_method" value="{{ $method }}">
					<input type="hidden" id="page" name="page" value="{{ $page }}">
					@foreach ($filters->keys() as $filterKey)
						<input type="hidden" name="{{$filterKey}}" value="{{ $filters->get($filterKey) }}">
					@endforeach
					@if (isset($command->user))
						<?php $user_id = $command->user->id; ?>
					@else
						<?php $user_id = null; ?>
					@endif
					<div class="form-group row">
						<label for="name" class="col-md-4 col-form-label text-md-right">@lang('messages.Name')</label>

						<div class="col-md-6">
							<input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ $command->name }}" required autofocus>

							@if ($errors->has('name'))
								<span class="invalid-feedback">
									<strong>{{ $errors->first('name') }}</strong>
								</span>
							@endif
						</div>
					</div>
					
					<div class="form-group row">
						<label for="user_id" class="col-md-4 col-form-label text-md-right">@lang('messages.User')</label>
						<div class="col-md-6">
							@if ($errors->has('user_id'))
								{{ Form::select('user_id', $users, $user_id, ['required', 'autofocus', 'placeholder' => 'Pick a user...', 'class' => 'form-control is-invalid'])}}
								<span class="invalid-feedback">
									<strong>{{ $errors->first('user_id') }}</strong>
								</span>
							@else
								{{ Form::select('user_id', $users, $user_id, ['required', 'placeholder' => 'Pick a user...', 'class' => 'form-control'])}}
							@endif
						</div>
					</div>
					
					<div class="form-group row">
						<label for="industry" class="col-md-4 col-form-label text-md-right">@lang('messages.Industry')</label>

						<div class="col-md-6">
							<input id="industry" type="text" class="form-control{{ $errors->has('industry') ? ' is-invalid' : '' }}" name="industry" value="{{ $command->industry }}" required>

							@if ($errors->has('industry'))
								<span class="invalid-feedback">
									<strong>{{ $errors->first('industry') }}</strong>
								</span>
							@endif
						</div>
					</div>
					
					<div class="form-group row">
						<label for="url" class="col-md-4 col-form-label text-md-right">URL</label>

						<div class="col-md-6">
							<input id="url" type="url" class="form-control{{ $errors->has('url') ? ' is-invalid' : '' }}" name="url" value="{{ $command->url }}" required>

							@if ($errors->has('url'))
								<span class="invalid-feedback">
									<strong>{{ $errors->first('url') }}</strong>
								</span>
							@endif
						</div>
					</div>
					
					<div class="form-group row">
						<label for="notes" class="col-md-4 col-form-label text-md-right">@lang('messages.Notes')</label>
						<div class="col-md-6">
							@if ($errors->has('notes'))
								{{ Form::textarea ('notes', $command->notes, ['class' => 'form-control is-invalid'])}}
								<span class="invalid-feedback">
									<strong>{{ $errors->first('notes') }}</strong>
								</span>
							@else
								{{ Form::textarea ('notes', $command->notes, ['class' => 'form-control'])}}
							@endif
						</div>
					</div>
					
					<div class="form-group row mb-0">
						@include('admin.down_buttons', ['btn_save' => true])
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection
