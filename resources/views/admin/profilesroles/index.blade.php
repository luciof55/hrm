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
							<span class="navbar-text text-dark">@lang('messages.ProfilesRoles')</span>
							<input type="hidden" id="page" name="page" value="{{ $page }}">
							@foreach ($filters->keys() as $filterKey)
								@if ($filterKey == 'profile_id_filter')
									{{ Form::select($filterKey, $profiles, $filters->get($filterKey), ['autofocus', 'placeholder' => 'Pick a profile...', 'class' => 'form-control mr-sm-2'])}}
								@endif
								@if ($filterKey == 'role_id_filter')
									{{ Form::select($filterKey, $roles, $filters->get($filterKey), ['autofocus', 'placeholder' => 'Pick a role...', 'class' => 'form-control mr-sm-2'])}}
								@endif
							@endforeach
							<button class="btn btn-primary" type="submit">@lang('messages.Search')</button>
						</form>
					</nav>
				</div>
				<div class="row">
					<div class="container">
						<div class="table-responsive">
							<table class="table table-bordered table-hover">
								<thead>
								  <tr>
									<th>@lang('messages.Profile')</th>
									<th>@lang('messages.Role')</th>
								  </tr>
								</thead>
								<tbody>
									@foreach ($list as $command)
										<tr id="{{$entity}}_{{$command->id}}" onclick="crudInstance.setCurrentRowId('{{$entity}}_{{$command->id}}');">
											<td>{{ $command->profile->name }}</td>
											<td>{{ $command->role->name}}</td>
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