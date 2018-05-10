@extends('layouts.app')
@section('content')
<div class="row justify-content-center">
	<div class="col-md-8">
		<div class="card">
			<div class="card-header">@lang('messages.Contact')</div>

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
					@if (isset($command->account))
						<?php $account_id = $command->account->id; ?>
					@else
						<?php $account_id = null; ?>
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
								{{ Form::select('user_id', $users, $user_id, ['required', 'placeholder' => 'Pick a user...', 'class' => 'form-control is-invalid'])}}
								<span class="invalid-feedback">
									<strong>{{ $errors->first('user_id') }}</strong>
								</span>
							@else
								{{ Form::select('user_id', $users, $user_id, ['required', 'placeholder' => 'Pick a user...', 'class' => 'form-control'])}}
							@endif
						</div>
					</div>
					
					<div class="form-group row">
						<label for="account_id" class="col-md-4 col-form-label text-md-right">@lang('messages.Account')</label>
						<div class="col-md-6">
							@if ($errors->has('account_id'))
								{{ Form::select('account_id', $accounts, $account_id, ['required', 'placeholder' => 'Pick a account...', 'class' => 'form-control is-invalid'])}}
								<span class="invalid-feedback">
									<strong>{{ $errors->first('account_id') }}</strong>
								</span>
							@else
								{{ Form::select('account_id', $accounts, $account_id, ['required', 'placeholder' => 'Pick a account...', 'class' => 'form-control'])}}
							@endif
						</div>
					</div>
					
					<div class="form-group row">
						<label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }})</label>

						<div class="col-md-6">
							<input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $command->email }}" required>

							@if ($errors->has('email'))
								<span class="invalid-feedback">
									<strong>{{ $errors->first('email') }}</strong>
								</span>
							@endif
						</div>
					</div>
					
					<div class="form-group row">
						<label for="phone" class="col-md-4 col-form-label text-md-right">@lang('messages.Phone')</label>

						<div class="col-md-6">
							<input id="phone" type="phone" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" name="phone" value="{{ $command->phone }}" required>

							@if ($errors->has('phone'))
								<span class="invalid-feedback">
									<strong>{{ $errors->first('phone') }}</strong>
								</span>
							@endif
						</div>
					</div>
					
					<div class="form-group row">
						<label for="position" class="col-md-4 col-form-label text-md-right">@lang('messages.Position')</label>
						<div class="col-md-6">
							<input id="position" type="text" class="form-control{{ $errors->has('position') ? ' is-invalid' : '' }}" name="position" value="{{ $command->position }}" required>
							@if ($errors->has('position'))
								<span class="invalid-feedback">
									<strong>{{ $errors->first('position') }}</strong>
								</span>
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
