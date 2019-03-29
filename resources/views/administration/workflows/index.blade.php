@extends('administration.layout')
@section('administrationContent')
@include('confirmation_modal', ['headerText' => '', 'bodyText' => ''])
<div class="row justify-content-center">
	<div class="col-md-2">
		<div class="d-none d-md-block navbar-expand-md">
			@include('administration.actions', ['collapse' => '', 'navactions_id' => 'navactions'])
		</div>
	</div>
	<div class="col-md-10">
		<div class="card">
			<div class="d-flex flex-column">
				<div class="p-2 text-white bg-info border-bottom rounded-top">
					<div class="d-flex">
						<div><span>Comerciales</span></diV>
						<div class="ml-auto">
							<div class="d-block d-md-none">@include('administration.actions', ['collapse' => 'collapse', 'navactions_id' => 'navactions_sm'])</div>
						</div>
					</div>
				</div>
				<div class="p-2 text-black border-bottom bg-light">
					<form id="actionForm" action="{{$action}}" metdod="GET">
						@csrf
						<input type="hidden" id="method" name="method" value="{{ $method }}">
						<input type="hidden" id="page" name="page" value="{{ $page }}">
						<input type="hidden" id="id" name="id" value="">
						<input type="hidden" id="columnOrder" name="columnOrder" value="@if(isset($columnOrder)){{$columnOrder}}@endif">
						@include('order_fields')
						<div class="d-flex flex-row bg-light">
							<div class="p-1">
								<div class="d-flex flex-row">
									<div class="p-1"><label for="name_filter" class="col-form-label text-md-right">@lang('messages.Name')</label></div>
									<div class="p-1">
										<input class="form-control" type="text" placeholder="@lang('messages.Name')" id="name_filter" name="name_filter" value="{{ $filters->get('name_filter') }}" autofocus>
									</div>
									<div class="p-1"><label class="col-form-label text-md-right" for="entrevistado_filter">@lang('messages.Entrevistado')</label></div>
									<div class="p-1">
										{{ Form::select('entrevistado_filter', $entrevistadoOptions, $filters->get('entrevistado_filter'), ['placeholder' => 'Entrevistado...', 'class' => 'form-control', 'id' => 'entrevistado_filter'])}}
									</div>
								</div>
							</div>
							<div class="p-1">
								<div class="d-flex flex-row">
									<div class="p-1"><label for="transitions-account_id_filter" class="col-form-label text-md-right">@lang('messages.Account')</label></div>
									<div class="p-1">
										{{ Form::select('transitions-account_id_filter', $accounts, $filters->get('transitions-account_id_filter'), ['placeholder' => 'Empresa...', 'class' => 'form-control', 'id' => 'transitions-account_id_filter'])}}
									</div>
								
									<div class="p-1"><label for="transition-zonas_filter" class="col-form-label text-md-right">@lang('messages.Zonas')</label></div>
									<div class="p-1"><input class="form-control" type="text" placeholder="@lang('messages.Zonas')" id="transitions-zonas_filter" name="transitions-zonas_filter" value="{{ $filters->get('transitions-zonas_filter') }}"></div>
								
									<div class="p-1"><label for="transition-anio_filter" class="col-form-label text-md-right">@lang('messages.Anio')</label></div>
									<div class="p-1">
										<input class="form-control" type="text" placeholder="@lang('messages.Anio')" id="transitions-anio_filter" name="transitions-anio_filter" value="{{ $filters->get('transitions-anio_filter') }}">
									</div>
									<div class="p-1">
										<button class="d-none d-sm-block btn btn-info" type="submit"><i class="fa fa-search"></i></button>
										<button class="d-block d-sm-none btn btn-info" type="submit"><i class="fa fa-search"></i></button>
									</div>
									<div class="p-1">
										<button class="d-none d-sm-block btn btn-info" type="reset"><i class="fa fa-undo"></i></button>
										<button class="d-block d-sm-none btn btn-info" type="reset"><i class="fa fa-undo"></i></button>
									</div>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
			<div class="card-body">
				<div class="row">
					<div class="container">
						@include('admin.status')
						<div class="table-responsive">
							<table class="table table-bordered table-hover">
								<thead>
								  <tr>
										<td class="table-header">
											@include('column_order', ['column_order' => 'name_order', 'column_text' => 'messages.Name'])
										</td>
										<td class="table-header">Teléfono</td>
								  </tr>
								</thead>
								<tbody>
									@foreach ($list as $command)
										<tr id="{{$entity}}_{{$command->id}}" class="@if ($command->trashed()) bg-light text-muted @endif" onclick="potencialInstance.setCurrentRowId('{{$entity}}_{{$command->id}}');">
											<td>{{ $command->name }}</td>
											<td>{{ $command->telefono }}</td>
										</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="container">
						<div class="d-flex flex-fill flex-row">
							<div class="p-1">{{ $list->links() }}</div>
							@if($actionExportEnable)
								<div class="d-none d-md-block p-1"><button id="button_export" type="button" onclick="location.href='{{$actionExport}}';" class="btn btn-info btn-md"><i class="pr-2 fa fa-th-list"></i>@lang('messages.Export')</button></div>
							@endif
							<div class="p-1 ml-auto">
								@include('admin.buttons', ['btn_new' => true, 'btn_view' => true, 'btn_edit' => true, 'btn_enable' => true, 'btn_remove' => true])
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
