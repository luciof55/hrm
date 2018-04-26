@extends('admin.layout')

@section('securityContent')
@include('confirmation_modal', ['headerText' => '', 'bodyText' => ''])
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-2">
            <div class="card">
                <div class="card-header">@lang('messages.Actions')</div>

                <div class="card-body">
                    <div class="content">
						<ul class="nav flex-column nav-pills">
						  <li class="nav-item">
							<a class="nav-link active" href="#">Opción 1</a>
						  </li>
						</ul>
					</div>
                </div>
            </div>
        </div>
		<div class="col-md-10">
            <div class="card">
                <div class="card-header">
					<nav class="navbar navbar-expand-sm  navbar-dark">
						<form id="actionForm" class="form-inline" action="{{$action}}" method="GET">
							@csrf
							<input type="hidden" id="_method" name="_method" value="{{ $method }}">
							<span class="navbar-text text-dark">@lang('messages.Profiles')</span>
							<input type="hidden" id="page" name="page" value="{{ $page }}">
							<input type="hidden" id="id" name="id" value="">
							@foreach ($filters->keys() as $filterKey)
								<input class="form-control mr-sm-2" type="text" placeholder="@lang('messages.Search')" id="{{$filterKey}}" name="{{$filterKey}}" value="{{ $filters->get($filterKey) }}" autofocus>
							@endforeach
							<button class="btn btn-primary" type="submit">@lang('messages.Search')</button>
						</form>
					</nav>
				</div>
				<div class="row">
					<div class="container">
						@if(isset($status))
							<div class="alert alert-success">
								{{ $status }}
							</div>
						@endif
						@if ($errors->any())
							<div class="alert alert-danger">
								<ul>
									@foreach ($errors->all() as $error)
										<li>{{ $error }}</li>
									@endforeach
								</ul>
							</div>
						@endif
						<div class="table-responsive">
							<table class="table table-bordered table-hover">
								<thead>
								  <tr>
									<th>Name</th>
									<th>ID</th>
								  </tr>
								</thead>
								<tbody>
									@foreach ($list as $command)
										<tr id="{{$entity}}_{{$command->id}}" class="@if ($command->trashed()) table-danger @endif" onclick="crudInstance.setCurrentRowId('{{$entity}}_{{$command->id}}');">
											<td>{{ $command->name }}</td>
											<td>{{$command->id}}</td>
										</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="container">
					<div class="float-left">{{ $list->links() }}</div>
					<div class="float-right">
						<div class="btn-group">
							<button type="button" onclick="crudInstance.create('{{route($actionCreate)}}');" class="btn btn-primary btn-md">@lang('messages.New')</button>
							<button type="button" onclick="crudInstance.view('{{$entity}}', '{{$actionView}}');" class="btn btn-primary btn-md">@lang('messages.View')</button>
							<button type="button" onclick="crudInstance.edit('{{$entity}}', '{{$actionEdit}}');" class="btn btn-primary btn-md">@lang('messages.Edit')</button>
							@if ($isSoftDelete)
							<button id="button_enable" data-action="{{$actionEnable}}" data-method="GET" data-entity="{{$entity}}" data-toggle="modal" data-target="#confirmation-modal" data-selectrowtext="@lang('messages.selectrowtext')" data-title="@lang('messages.EnableTitle')" data-body="@lang('messages.EnableRow')" class="btn btn-primary btn-md">@lang('messages.Enable')</button>
							@endif
							<button id="button_remove" data-action="{{$actionDelete}}" data-method="GET" data-entity="{{$entity}}" data-toggle="modal" data-target="#confirmation-modal" data-selectrowtext="@lang('messages.selectrowtext')" data-title="@lang('messages.RemoveTitle')" data-body="@lang('messages.RemoveRow')" class="btn btn-primary btn-md">@lang('messages.Remove')</button>
						</div>
					</div>
				</div>
			</div>
        </div>
    </div>
</div>
@endsection