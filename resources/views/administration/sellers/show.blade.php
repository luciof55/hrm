@extends('administration.layout')
@section('content')
<div class="row justify-content-center">
	<div class="col-md-8">
		<div class="card">
			<div class="card-header">Comercial</div>
			<div class="card-body">
				<ul class="nav nav-tabs" id="myTab" role="tablist">
					<li class="nav-item">
						<a class="nav-link @if($activeTab == 'main') active @endif" onclick="sellerInstance.setActiveTab('main')"
						id="main-tab" data-toggle="tab" href="#main" role="tab" aria-controls="main" aria-selected="true">General</a>
					</li>
					<li class="nav-item">
						<a class="nav-link @if($activeTab == 'interviews') active @endif" onclick="sellerInstance.setActiveTab('interviews')"
						id="interviews-tab" data-toggle="tab" href="#interviews" role="tab" aria-controls="interviews" aria-selected="false">@lang('messages.Interviews')</a>
					</li>
				</ul>
				<div class="tab-content" id="myTabContent">
					<div class="tab-pane fade @if($activeTab == 'main') show active @endif" id="main" role="tabpanel" aria-labelledby="main-tab">
						<div class="card">
						  <div class="card-body">
								<form id="commandForm" method="GET" action="{{ $action }}">
									@csrf
									<input type="hidden" id="_method" name="_method" value="{{ $method }}">
									<input type="hidden" name="page" value="{{ $page }}">
									@foreach ($filters->keys() as $filterKey)
										<input type="hidden" name="{{$filterKey}}" value="{{ $filters->get($filterKey) }}">
									@endforeach
									@include('order_fields')
									<div class="form-group row">
										<label for="name" class="col-md-4 col-form-label text-md-right">@lang('messages.Name')</label>
										<div class="col-md-6">
											<input id="name" type="text" class="form-control-plaintext" name="name" value="{{ $command->name }}" autofocus readonly>
										</div>
									</div>
									<div class="form-group row">
										<label for="telefono" class="col-md-4 col-form-label text-md-right">@lang('messages.Telefono')</label>
										<div class="col-md-6">
											<input id="telefono" type="text" class="form-control-plaintext" name="telefono" value="{{$command->telefono}}" >
										</div>
									</div>
									<div class="form-group row">
										<label for="entrevistado" class="col-md-4 col-form-label text-md-right">@lang('messages.Entrevistado')</label>
										<div class="col-md-6">
											<input id="entrevistado" type="text" class="form-control-plaintext" name="entrevistado" value="@if ($command->entrevistado) Si @else No @endif" readonly>
										</div>
									</div>
									@if (!blank($command->files))
										<div class="form-group row">
											<label for="download" class="col-md-4 col-form-label text-md-right">Archivo</label>
											<div class="col-md-6">
												<button id="button_download_file" type="button" onclick="sellerInstance.downloadFile('fileForm', 'GET',  '{{route('administration.sellers_download')}}', '{{$command->files[0]->original_filename}}');" class="btn btn-info btn-md"><i class="pr-2 fa fa-download"></i>Descargar</button>
											</div>
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
					</div>
					<div class="tab-pane fade @if($activeTab == 'interviews') show active @endif" id="interviews" role="tabpanel" aria-labelledby="interviews-tab">
						<div class="card">
							<div class="card-body">
								<form id="commandChildForm" method="GET" action="{{ $actionView }}">
									@csrf
									<input type="hidden" id="tablePage" name="tablePage" value="{{ $tablePage }}">
									<input type="hidden" id="_method" name="_method" value="{{ $method }}">
									<input type="hidden" name="page" value="{{ $page }}">
									<input type="hidden" id="interviewName" name="interviewName" value="">
									<input type="hidden" id="activeTab" name="activeTab" value="{{ $activeTab }}">
									@foreach ($filters->keys() as $filterKey)
										<input type="hidden" name="{{$filterKey}}" value="{{ $filters->get($filterKey) }}">
									@endforeach
									@include('order_fields')
									<div class="form-group row">
										<div class="col-md-1"><label for="interview-anio" class="col-form-label">@lang('messages.Anio')</label></div>
										<div class="col-md-2"><input type="text" class="form-control-plaintext" name="interview-anio" id="interview-anio" readonly></div>
										<div class="col-md-2"><label for="interview-account_id" class="col-form-label">@lang('messages.Account')</label></div>
										<div class="col-md-3">
											<input type="text" class="form-control-plaintext" name="interview-account_id" id="interview-account_id" readonly>
										</div>
										<div class="col-md-2"><label for="interview-category_id" class="col-form-label">@lang('messages.Category')</label></div>
										<div class="col-md-2">
											<input type="text" class="form-control-plaintext" name="interview-category_id" id="interview-category_id" readonly>
										</div>
									</div>
									<div class="form-group row">
										<div class="col-md-1">
											<label for="interview-zonas" class="col-form-label">@lang('messages.Zonas')</label>
										</div>
										<div class="col-md-11">
											<input type="text" class="form-control-plaintext" name="interview-zonas" id="interview-zonas" readonly>
										</div>
									</div>
									<div class="form-group row">
										<div class="col-md-1">
											<label for="interview-comentarios" class="col-form-label">@lang('messages.Notes')</label>
										</div>
										<div class="col-md-11">
											<input type="text" class="form-control-plaintext" name="interview-comentarios" id="interview-comentarios" readonly>
										</div>
									</div>
								</form>
								<div class="row">
									<div class="table-responsive">
										<table id="interviews-table" class="table table-striped table-hover">
										  <thead>
											<tr>
												<td class="table-header">@lang('messages.Name')</td>
												<td class="table-header">@lang('messages.Account')</td>
												<td class="table-header">@lang('messages.Category')</td>
												<td class="table-header"></td>
											</tr>
										  </thead>
										  <tbody>
											@foreach($interviews as $interview)
												<tr id="interview_.{{$interview->getInterviewKey()}}">
													<td>{{$interview->anio}}</td>
													<td>{{$interview->account->name}}</td>
													<td>{{$interview->category->name}}</td>
													<td><button type="button" onclick="sellerInstance.loadElement('commandChildForm', '{{$actionLoadInterview}}', 'POST', '{{$interview->getInterviewKey()}}', false);" class="fa fa-search button"></button></td>
												</tr>
											@endforeach
										  </tbody>
										</table>
									</div>
								</div>
								<div class="row">
									<div class="container">
										<div class="d-flex flex-fill flex-row">
											<div id="divInterviewPagination" class="p-1">{{ $interviews->links('vendor.pagination.bootstrap-4', ['paginationFunction' => 'sellerInstance.paginateInterviewsShow']) }}</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="mt-4 ml-auto">
						<button type="submit" onclick="crudInstance.submitForm('commandForm')"class="btn btn-outline-secondary">@lang('messages.Cancel')</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
