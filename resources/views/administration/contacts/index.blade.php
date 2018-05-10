@extends('administration.layout')
@section('content')
@include('confirmation_modal', ['headerText' => '', 'bodyText' => ''])
<div class="row justify-content-center">
	<div class="col-md-2">
		@include('admin.actions')
	</div>
	<div class="col-md-10">
		<div class="card">
			<div class="card-header">
				<nav class="navbar navbar-expand-sm navbar-dark">
					<form id="actionForm" class="form-inline" action="{{$action}}" method="GET">
						@csrf
						<input type="hidden" id="_method" name="_method" value="{{ $method }}">
						<span class="navbar-text text-dark">@lang('messages.Contacts')</span>
						<input type="hidden" id="page" name="page" value="{{ $page }}">
						<input type="hidden" id="id" name="id" value="">
						<input class="form-control mr-sm-2" type="text" placeholder="@lang('messages.Search')" id="name_filter" name="name_filter" value="{{ $filters->get('name_filter') }}" autofocus>
						{{ Form::select('user_id_filter', $users, $filters->get('user_id_filter'), ['placeholder' => 'Pick a user...', 'class' => 'form-control mr-sm-2'])}}
						{{ Form::select('account_id_filter', $accounts, $filters->get('account_id_filter'), ['placeholder' => 'Pick a account...', 'class' => 'form-control mr-sm-2'])}}
						<button class="btn btn-primary" type="submit">@lang('messages.Search')</button>
					</form>
				</nav>
			</div>
			<div class="card-body">
				<div class="row">
					<div class="container">
						@include('admin.status')
						<div class="table-responsive">
							<table class="table table-bordered table-hover">
								<thead>
								  <tr>
									<th>@lang('messages.Name')</th>
									<th>@lang('messages.User')</th>
									<th>@lang('messages.Account')</th>
								  </tr>
								</thead>
								<tbody>
									@foreach ($list as $command)
										<tr id="{{$entity}}_{{$command->id}}" class="@if ($command->trashed()) table-danger @endif" onclick="crudInstance.setCurrentRowId('{{$entity}}_{{$command->id}}');">
											<td>{{ $command->name }}</td>
											<td>{{ $command->user->name }}</td>
											<td>{{ $command->account->name }}</td>
										</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="container">
						<div class="float-left">{{ $list->links() }}</div>
						<div class="float-right">
							@include('admin.buttons', ['btn_new' => true, 'btn_view' => true, 'btn_edit' => true, 'btn_enable' => true, 'btn_remove' => true])
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection