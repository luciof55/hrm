@extends('administration.layout')
@section('content')
<div class="row justify-content-center">
	<div class="col-md-8">
		<div class="card">
			<div class="card-header">@lang('messages.BusinessRecord')</div>

			<div class="card-body">
				<form id="commandForm" method="POST" action="{{ $action }}">
					@csrf
					<input id="id" name="id" type="hidden" value="{{ $command->id }}">
					<input type="hidden" id="_method" name="_method" value="{{ $method }}">
					<input type="hidden" id="page" name="page" value="{{ $page }}">
					@foreach ($filters->keys() as $filterKey)
						<input type="hidden" name="{{$filterKey}}" value="{{ $filters->get($filterKey) }}">
					@endforeach
					@if (isset($command->account))
						<?php $account_id = $command->account->id; ?>
					@else
						<?php $account_id = null; ?>
					@endif
					@if (isset($command->state))
						<?php $state_id = $command->state->id; ?>
					@else
						<?php $state_id = null; ?>
					@endif
					@if (isset($command->comercial))
						<?php $comercial_id = $command->comercial->id; ?>
					@else
						<?php $comercial_id = null; ?>
					@endif
					@if (isset($command->leader))
						<?php $leader_id = $command->leader->id; ?>
					@else
						<?php $leader_id = null; ?>
					@endif
					@if (isset($command->workflow))
						<?php $workflow_id = $command->workflow->id; ?>
					@else
						<?php $workflow_id = null; ?>
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
						<label for="state_id" class="col-md-4 col-form-label text-md-right">@lang('messages.BusinessRecordState')</label>
						<div class="col-md-6">
							@if ($errors->has('state_id'))
								{{ Form::select('state_id', $states, $state_id, ['required', 'placeholder' => 'Pick a state...', 'class' => 'form-control is-invalid'])}}
								<span class="invalid-feedback">
									<strong>{{ $errors->first('state_id') }}</strong>
								</span>
							@else
								{{ Form::select('state_id', $states, $state_id, ['required', 'placeholder' => 'Pick a state...', 'class' => 'form-control'])}}
							@endif
						</div>
					</div>

					<div class="form-group row">
						<label for="comercial_id" class="col-md-4 col-form-label text-md-right">@lang('messages.Comercial')</label>
						<div class="col-md-6">
							@if ($errors->has('comercial_id'))
								{{ Form::select('comercial_id', $comercials, $comercial_id, ['required', 'placeholder' => 'Pick a comercial...', 'class' => 'form-control is-invalid'])}}
								<span class="invalid-feedback">
									<strong>{{ $errors->first('comercial_id') }}</strong>
								</span>
							@else
								{{ Form::select('comercial_id', $comercials, $comercial_id, ['required', 'placeholder' => 'Pick a comercial...', 'class' => 'form-control'])}}
							@endif
						</div>
					</div>

					<div class="form-group row">
						<label for="leader_id" class="col-md-4 col-form-label text-md-right">@lang('messages.Leader')</label>
						<div class="col-md-6">
							@if ($errors->has('leader_id'))
								{{ Form::select('leader_id', $leaders, $leader_id, ['placeholder' => 'Pick a leader...', 'class' => 'form-control is-invalid'])}}
								<span class="invalid-feedback">
									<strong>{{ $errors->first('leader_id') }}</strong>
								</span>
							@else
								{{ Form::select('leader_id', $leaders, $leader_id, ['placeholder' => 'Pick a leader...', 'class' => 'form-control'])}}
							@endif
						</div>
					</div>

					<div class="form-group row">
						<label for="workflow_id" class="col-md-4 col-form-label text-md-right">Workflow</label>
						<div class="col-md-6">
							@if ($errors->has('workflow_id'))
								{{ Form::select('workflow_id', $workflows, $workflow_id, ['placeholder' => 'Pick a Workflow...', 'class' => 'form-control is-invalid'])}}
								<span class="invalid-feedback">
									<strong>{{ $errors->first('workflow_id') }}</strong>
								</span>
							@else
								{{ Form::select('workflow_id', $workflows, $workflow_id, ['placeholder' => 'Pick a Workflow...', 'class' => 'form-control'])}}
							@endif
						</div>
					</div>

					<div class="form-group row">
						<label for="management_tool" class="col-md-4 col-form-label text-md-right">@lang('messages.ManagementTool')</label>

						<div class="col-md-6">
							<input id="management_tool" type="text" class="form-control{{ $errors->has('management_tool') ? ' is-invalid' : '' }}" name="management_tool" value="{{ $command->management_tool }}" >

							@if ($errors->has('management_tool'))
								<span class="invalid-feedback">
									<strong>{{ $errors->first('management_tool') }}</strong>
								</span>
							@endif
						</div>
					</div>

					<div class="form-group row">
						<label for="repository" class="col-md-4 col-form-label text-md-right">@lang('messages.Repository')</label>

						<div class="col-md-6">
							<input id="repository" type="url" class="form-control{{ $errors->has('repository') ? ' is-invalid' : '' }}" name="repository" value="{{ $command->repository }}" >

							@if ($errors->has('repository'))
								<span class="invalid-feedback">
									<strong>{{ $errors->first('repository') }}</strong>
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
