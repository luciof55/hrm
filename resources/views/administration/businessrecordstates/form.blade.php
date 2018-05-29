@extends('administration.layout')
@section('content')
<div class="row justify-content-center">
	<div class="col-md-8">
		<div class="card">
			<div class="card-header">@lang('messages.BusinessRecordState')</div>

			<div class="card-body">
				<form id="commandForm" method="POST" action="{{ $action }}">
					@csrf
					<input id="id" name="id" type="hidden" value="{{ $command->id }}">
					<input type="hidden" id="_method" name="_method" value="{{ $method }}">
					<input type="hidden" id="page" name="page" value="{{ $page }}">
					@foreach ($filters->keys() as $filterKey)
						<input type="hidden" name="{{$filterKey}}" value="{{ $filters->get($filterKey) }}">
					@endforeach
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
						<label for="closed_state" class="col-md-4 col-form-label text-md-right">@lang('messages.RecordStateType')</label>
						<div class="col-md-6">
							@if ($errors->has('closed_state'))
								{{ Form::select('closed_state', $types, $command->closed_state, ['required', 'placeholder' => 'Pick a type...', 'class' => 'form-control is-invalid'])}}
							@else
								{{ Form::select('closed_state', $types, $command->closed_state, ['required', 'placeholder' => 'Pick a type...', 'class' => 'form-control'])}}
							@endif
							@if ($errors->has('closed_state'))
								<span class="invalid-feedback">
									<strong>{{ $errors->first('closed_state') }}</strong>
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
