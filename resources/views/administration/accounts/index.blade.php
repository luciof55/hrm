@extends('administration.layout')
@section('content')
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
							<div><span>@lang('messages.Accounts')</span></diV>
							<div class="ml-auto">
								<div class="d-block d-md-none">@include('administration.actions', ['collapse' => 'collapse', 'navactions_id' => 'navactions_sm'])</div>
							</div>
						</div>
				</div>
				<div class="p-2 text-black border-bottom bg-light">
					<form id="actionForm" action="{{$action}}" method="GET">
						@csrf
						<input type="hidden" id="_method" name="_method" value="{{ $method }}">
						<input type="hidden" id="page" name="page" value="{{ $page }}">
						<input type="hidden" id="id" name="id" value="">
						<div class="d-flex flex-fill flex-row d-inline-flex bg-light">
							<div class="p-1"><label for="name_filter" class="col-form-label text-md-right">@lang('messages.Name')</label></div>
							<div class="p-1"><input class="form-control" type="text" placeholder="@lang('messages.Name')" id="name_filter" name="name_filter" value="{{ $filters->get('name_filter') }}" autofocus></div>
							<div class="p-1">
									<button class="d-none d-sm-block btn btn-info" type="submit"><i class="pr-2 fa fa-search"></i>@lang('messages.Search')</button>
									<button class="d-block d-sm-none btn btn-info" type="submit"><i class="fa fa-search"></i></button>
								</div>
							<div class="p-1">
								<button class="d-none d-sm-block btn btn-info" type="reset"><i class="pr-2 fa fa-undo"></i>Reset</button>
								<button class="d-block d-sm-none btn btn-info" type="reset"><i class="fa fa-undo"></i></button>
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
									<td class="bg-info text-white">Name</td>
								  </tr>
								</thead>
								<tbody>
									@foreach ($list as $command)
										<tr id="{{$entity}}_{{$command->id}}" class="@if ($command->trashed()) bg-light text-muted @endif" onclick="crudInstance.setCurrentRowId('{{$entity}}_{{$command->id}}');">
											<td>{{ $command->name }}</td>
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
							<div class="p-1 ml-auto">@include('admin.buttons', ['btn_new' => true, 'btn_view' => true, 'btn_edit' => true, 'btn_enable' => true, 'btn_remove' => true])</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
