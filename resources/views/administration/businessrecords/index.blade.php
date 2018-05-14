@extends('administration.layout')
@section('content')
@include('confirmation_modal', ['headerText' => '', 'bodyText' => ''])
<div class="row justify-content-center">
	<div class="col-md-2">
		@include('administration.actions')
	</div>
	<div class="col-md-10">
		<div class="card">
			<div class="d-flex flex-column">
				<div class="p-2 text-white bg-info border-bottom rounded-top">@lang('messages.BusinessRecords')</div>
				<div class="p-2 text-black border-bottom bg-light">
					<form id="actionForm" action="{{$action}}" metdod="GET">
						@csrf
						<input type="hidden" id="method" name="method" value="{{ $method }}">
						<input type="hidden" id="page" name="page" value="{{ $page }}">
						<input type="hidden" id="id" name="id" value="">
						<div class="d-flex flex-fill flex-row d-inline-flex bg-light">
							<div class="p-1"><label for="name_filter" class="col-form-label text-md-right">@lang('messages.Name')</label></div>
							<div class="p-1"><input class="form-control" type="text" placeholder="@lang('messages.Search')" id="name_filter" name="name_filter" value="{{ $filters->get('name_filter') }}" autofocus></div>
							<div class="p-1"><label for="account_id_filter" class="col-form-label text-md-right">@lang('messages.Account')</label></div>
							<div class="p-1">{{ Form::select('account_id_filter', $accounts, $filters->get('account_id_filter'), ['placeholder' => 'Pick a account...', 'class' => 'form-control'])}}</div>
							<div class="p-1"><label for="comercial_id_filter" class="col-form-label text-md-right">@lang('messages.Comercial')</label></div>
							<div class="p-1">{{ Form::select('comercial_id_filter', $comercials, $filters->get('comercial_id_filter'), ['placeholder' => 'Pick a comercial...', 'class' => 'form-control'])}}</div>
							<div class="p-1"><label for="state_id_filter" class="col-form-label text-md-right">@lang('messages.BusinessRecordState')</label></div>
							<div class="p-1">{{ Form::select('state_id_filter', $states, $filters->get('state_id_filter'), ['placeholder' => 'Pick a state...', 'class' => 'form-control'])}}</div>
							<div class="p-1"><button class="btn btn-info" type="submit">@lang('messages.Search')</button></div>
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
								<tdead>
								  <tr>
									<td class="bg-info text-white">@lang('messages.Name')</td>
									<td class="bg-info text-white">@lang('messages.Account')</td>
									<td class="bg-info text-white">@lang('messages.Comercial')</td>
									<td class="bg-info text-white">@lang('messages.BusinessRecordState')</td>
								  </tr>
								</tdead>
								<tbody>
									@foreach ($list as $command)
										<tr id="{{$entity}}_{{$command->id}}" class="@if ($command->trashed()) bg-light text-muted @endif" onclick="crudInstance.setCurrentRowId('{{$entity}}_{{$command->id}}');">
											<td>{{ $command->name }}</td>
											<td>{{ $command->account->name }}</td>
											<td>{{ $command->comercial->name }}</td>
											<td>{{ $command->state->name }}</td>
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