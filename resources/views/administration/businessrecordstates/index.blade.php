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
					@include('admin.form', ['title' => 'messages.BusinessRecordStates'])
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
									<th>Name</th>
								  </tr>
								</thead>
								<tbody>
									@foreach ($list as $command)
										<tr id="{{$entity}}_{{$command->id}}" class="@if ($command->trashed()) text-muted @endif" onclick="crudInstance.setCurrentRowId('{{$entity}}_{{$command->id}}');">
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
