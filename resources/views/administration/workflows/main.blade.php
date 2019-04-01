<div class="card">
  <div class="card-body">
		<div class="row"><div id="mainSpanMessage" class="alert alert-danger w-100" style="display:none;"><span></span></div></div>
		@if ($errors->all())
			<div class="alert alert-danger w-100">
			@foreach ($errors->all() as $message)
				<span>{{ $message }}</span>
			@endforeach
			</div>
		@endif
		<form id="commandForm" method="POST" action="{{ $action }}" enctype="multipart/form-data">
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
					<input id="telefono" type="text" class="form-control{{ $errors->has('telefono') ? ' is-invalid' : '' }}" name="telefono" value="{{$command->telefono}}" >
					@if ($errors->has('telefono'))
						<span class="invalid-feedback"><strong>{{ $errors->first('telefono') }}</strong></span>
					@endif
				</div>
			</div>
			<div class="form-group row">
				<label for="entrevistado" class="col-md-4 col-form-label text-md-right">@lang('messages.Entrevistado')</label>
				<div class="form-check mt-2 ml-3 col-md-6">
					<input type="checkbox" class="form-check-input" id="entrevistado" name="entrevistado" value="{{ $command->entrevistado}}" @if ($command->entrevistado) checked @endif>
				</div>
			</div>
			<div class="form-group row">
				<label for="filename" class="col-md-4 col-form-label text-md-right">Subir archivo</label>
				<div class="col-md-6">
					<div class="custom-file">
						<input type="file" class="form-control custom-file-input" id="filename" name="filename">
						<label class="custom-file-label" for="filename">Seleccionar archivo</label>
					</div>
				</div>					
			</div>
			@if (!blank($command->files))
				<div class="form-group row">
					<label for="download" class="col-md-4 col-form-label text-md-right">Archivo</label>
					<div class="col-md-6">
						<button id="button_download_file" type="button" onclick="workflowInstance.downloadFile('fileForm', 'GET',  '{{route('administration.workflows_download')}}', '{{$command->files[0]->original_filename}}');" class="btn btn-info btn-md"><i class="pr-2 fa fa-download"></i>Descargar</button>
						<button id="button_remove_file" type="button" onclick="workflowInstance.removeFile('fileForm', 'POST', '{{$action_removefile}}');" class="btn btn-danger btn-md"><i class="pr-2 fa fa-remove delete-button"></i>@lang('messages.Remove')</button>
						<span id="nofiles" style="display:none;">Sin archivo</span>
					</div>
				</div>
			@else
				<div class="form-group row">
					<label for="download" class="col-md-4 col-form-label text-md-right">Archivo</label>
					<div class="col-md-6">Sin archivo</div>
				</div>
			@endif
		</form>
		<form id="fileForm" method="POST" action="">
			@csrf
			<input id="id" name="id" type="hidden" value="{{ $command->id }}">
			<input type="hidden" id="_method" name="_method" value="POST">
		</form>
	</div>
</div>
