<div class="card">
  <div class="card-body">
		<form id="commandForm" method="POST" action="{{ $action }}">
			@csrf
			<input id="id" name="id" type="hidden" value="{{ $command->id }}">
			<input type="hidden" id="_method" name="_method" value="{{ $method }}">
			<input type="hidden" id="page" name="page" value="{{ $page }}">
			<input type="hidden" id="activeTab" name="activeTab" value="{{ $activeTab }}">
			@foreach ($filters->keys() as $filterKey)
				<input type="hidden" name="{{$filterKey}}" value="{{ $filters->get($filterKey) }}">
			@endforeach
			@include('order_fields')
			<div class="form-group row">
				<label for="name" class="col-md-4 col-form-label text-md-right">@lang('messages.Name')</label>
				<div class="col-md-6">
					<input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ $command->name }}" required autofocus>
					@if ($errors->has('name'))
						<span class="invalid-feedback"><strong>{{ $errors->first('name') }}</strong></span>
					@endif
				</div>
			</div>
			<div class="form-group row">
				<label for="telefono" class="col-md-4 col-form-label text-md-right">@lang('messages.Telefono')</label>
				<div class="col-md-6">
					<input id="telefono" type="text" class="form-control{{ $errors->has('telefono') ? ' is-invalid' : '' }}" name="telefono" value="{{ $command->telefono	 }}" autofocus>
					@if ($errors->has('telefono'))
						<span class="invalid-feedback"><strong>{{ $errors->first('telefono') }}</strong></span>
					@endif
				</div>
			</div>
		</form>
	</div>
</div>
