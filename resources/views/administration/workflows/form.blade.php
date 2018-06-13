@extends('administration.layout')
@section('content')
<div class="row justify-content-center">
	<div class="col-md-8">
		<div class="card">
			<div class="card-header">Workflow</div>
			<div class="card-body">
				@if (isset($statusError))
					<div class="alert alert-danger">{{ $statusError }}</div>
				@else
					@if ($errors->has('auxTransitions'))
						<div class="alert alert-danger">{{ $errors->first('auxTransitions') }}</div>
					@endif
				@endif
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
						@include('administration.workflows.main')
					</div>
					<div class="tab-pane fade @if($activeTab == 'transitions') show active @endif" id="transitions" role="tabpanel" aria-labelledby="transitions-tab">
						@include('administration.workflows.transitions')
					</div>
				</div>
				<div class="row">
					<div class="mt-4 ml-auto">
						<button class="btn btn-info" onclick="workflowInstance.validateAndSubmitForm('commandForm');">@lang('messages.Save')</button>
						<button formnovalidate class="btn btn-outline-secondary" onclick="crudInstance.postFormBack('commandForm', '{{ $actionBack }}', 'GET');return;">@lang('messages.Cancel')</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
