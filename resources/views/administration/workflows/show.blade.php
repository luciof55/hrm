@extends('administration.layout')
@section('content')
<div class="row justify-content-center">
	<div class="col-md-8">
		<div class="card">
			<div class="card-header">Workflow</div>
			<div class="card-body">
				<ul class="nav nav-tabs" id="myTab" role="tablist">
					<li class="nav-item">
						<a class="nav-link @if($activeTab == 'main') active @endif" onclick="workflowInstance.setActiveTab('main')"
						id="main-tab" data-toggle="tab" href="#main" role="tab" aria-controls="main" aria-selected="true">General</a>
					</li>
					<li class="nav-item">
						<a class="nav-link @if($activeTab == 'transitions') active @endif" onclick="workflowInstance.setActiveTab('transitions')"
						id="transitions-tab" data-toggle="tab" href="#transitions" role="tab" aria-controls="transitions" aria-selected="false">@lang('messages.Transitions')</a>
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
											<input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ $command->name }}" autofocus readonly>
										</div>
									</div>

									<div class="form-group row">
										<label for="initial_state_id" class="col-md-4 col-form-label text-md-right">@lang('messages.BusinessRecordState')</label>
										<div class="col-md-6">
											<input id="initial_state_id" type="text" class="form-control" name="initial_state_id" value="{{ $command->initialState->name }}" readonly>
										</div>
									</div>

									<div class="form-group row">
										<label for="final_state_id" class="col-md-4 col-form-label text-md-right">@lang('messages.BusinessRecordState')</label>
										<div class="col-md-6">
											<input id="final_state_id" type="text" class="form-control" name="final_state_id" value="{{ $command->finalState->name }}" readonly>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
					<div class="tab-pane fade @if($activeTab == 'transitions') show active @endif" id="transitions" role="tabpanel" aria-labelledby="transitions-tab">
						<div class="card">
						  <div class="card-body">
								<form id="commandChildForm" method="GET" action="{{ $actionView }}">
	                @csrf
	                <input type="hidden" id="tablePage" name="tablePage" value="{{ $tablePage }}">
									<input type="hidden" id="_method" name="_method" value="{{ $method }}">
									<input type="hidden" name="page" value="{{ $page }}">
									<input type="hidden" id="activeTab" name="activeTab" value="{{ $activeTab }}">
									@foreach ($filters->keys() as $filterKey)
										<input type="hidden" name="{{$filterKey}}" value="{{ $filters->get($filterKey) }}">
									@endforeach
									@include('order_fields')
	              </form>
								<div class="row">
						      <div class="table-responsive">
						        <table id="transitions-table" class="table table-striped table-hover">
						          <thead>
						            <tr>
						              <td class="table-header">@lang('messages.Name')</td>
						              <td class="table-header">@lang('messages.BusinessRecordState')</td>
						              <td class="table-header">@lang('messages.BusinessRecordState')</td>
						            </tr>
						          </thead>
						          <tbody>
						            @foreach($transitions as $transition)
						              <tr id="transition_.{{$transition->getCleanName()}}">
						                <td>{{$transition->name}}</td>
						                <td>{{$transition->fromState->name}}</td>
						                <td>{{$transition->toState->name}}</td>
						              </tr>
						            @endforeach
						          </tbody>
						        </table>
						      </div>
						    </div>
								<div class="row">
						      <div class="container">
						        <div class="d-flex flex-fill flex-row">
						          <div id="divTransitionPagination" class="p-1">{{ $transitions->links('vendor.pagination.bootstrap-4', ['paginationFunction' => 'workflowInstance.paginateTransitionsShow']) }}</div>
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
