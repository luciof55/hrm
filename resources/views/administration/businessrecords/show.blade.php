@extends('layouts.app')
@section('content')
<div class="row justify-content-center">
	<div class="col-md-8">
		<div class="card">
			<div class="card-header">@lang('messages.Contact')</div>
			<div class="card-body">
				<form method="GET" action="{{ $action }}">
					@csrf
					<input type="hidden" id="_method" name="_method" value="{{ $method }}">
					<input type="hidden" name="page" value="{{ $page }}">
					@foreach ($filters->keys() as $filterKey)
						<input type="hidden" name="{{$filterKey}}" value="{{ $filters->get($filterKey) }}">
					@endforeach
					<div class="form-group row">
						<label for="name" class="col-md-4 col-form-label text-md-right">@lang('messages.Name')</label>
						<div class="col-md-6">
							<input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ $command->name }}" autofocus readonly>
						</div>
					</div>
					
					<div class="form-group row">
						<label for="account" class="col-md-4 col-form-label text-md-right">@lang('messages.Account')</label>
						<div class="col-md-6">
							<input id="account" type="text" class="form-control" name="acount" value="{{ $command->account->name }}" readonly>
						</div>
					</div>
					
					<div class="form-group row">
						<label for="state_id" class="col-md-4 col-form-label text-md-right">@lang('messages.BusinessRecordState')</label>
						<div class="col-md-6">
							<input id="state_id" type="text" class="form-control" name="state_id" value="{{ $command->state->name }}" readonly>
						</div>
					</div>
					
					<div class="form-group row">
						<label for="comercial" class="col-md-4 col-form-label text-md-right">@lang('messages.Comercial')</label>
						<div class="col-md-6">
							<input id="comercial" type="text" class="form-control" name="comercial" value="@if(isset($command->comercial)) {{ $command->comercial->name }} @endif" readonly>
						</div>
					</div>
					
					<div class="form-group row">
						<label for="leader" class="col-md-4 col-form-label text-md-right">@lang('messages.Leader')</label>
						<div class="col-md-6">
							<input id="leader" type="text" class="form-control" name="leader" value="@if(isset($command->leader)) {{ $command->leader->name }} @endif" readonly>
						</div>
					</div>
					
					<div class="form-group row">
						<label for="management_tool" class="col-md-4 col-form-label text-md-right">@lang('messages.ManagementTool')</label>
						<div class="col-md-6">
							<input id="management_tool" type="url" class="form-control" name="management_tool" value="{{ $command->management_tool }}" readonly>
						</div>
					</div>
					
					<div class="form-group row">
						<label for="repository" class="col-md-4 col-form-label text-md-right">@lang('messages.Repository')</label>
						<div class="col-md-6">
							<input id="repository" type="url" class="form-control" name="repository" value="{{ $command->repository }}" readonly>
						</div>
					</div>
					
					<div class="form-group row">
						<label for="notes" class="col-md-4 col-form-label text-md-right">@lang('messages.Notes')</label>
						<div class="col-md-6">
							{{ Form::textarea ('notes', $command->notes, ['readonly', 'class' => 'form-control'])}}
						</div>
					</div>

					<div class="form-group row mb-0">
						@include('admin.down_buttons', ['btn_save' => false])
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection
