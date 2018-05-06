@extends('layouts.app')
@section('content')
<div class="row justify-content-center">
	<div class="col-md-8">
		<div class="card">
			<div class="card-header">@lang('messages.Account')</div>
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
						<label for="user" class="col-md-4 col-form-label text-md-right">@lang('messages.User')</label>
						<div class="col-md-6">
							<input id="user" type="text" class="form-control" name="user" value="{{ $command->user->name }}" readonly>
						</div>
					</div>
					
					<div class="form-group row">
						<label for="industry" class="col-md-4 col-form-label text-md-right">@lang('messages.Industry')</label>
						<div class="col-md-6">
							<input id="industry" type="text" class="form-control" name="industry" value="{{ $command->industry }}" readonly>
						</div>
					</div>
					
					<div class="form-group row">
						<label for="url" class="col-md-4 col-form-label text-md-right">URL</label>
						<div class="col-md-6">
							<input id="url" type="text" class="form-control" name="url" value="{{ $command->url }}" readonly>
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
