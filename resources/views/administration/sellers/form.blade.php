@extends('administration.layout')
@section('content')
<div class="row justify-content-center">
	<div class="col-md-8">
		<div class="card">
			<div class="card-header">Comercial</div>
			<div class="card-body">
				@if (isset($statusError))
					<div class="alert alert-danger">{{ $statusError }}</div>
				@else
					@if ($errors->has('auxInterviews'))
						<div class="alert alert-danger">{{ $errors->first('auxInterviews') }}</div>
					@endif
				@endif
				
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
						@include('administration.sellers.main')
					</div>
					<div class="tab-pane fade @if($activeTab == 'interviews') show active @endif" id="interviews" role="tabpanel" aria-labelledby="interviews-tab">
						@include('administration.sellers.interviews')
					</div>
				</div>
				<div class="row">
					<div class="mt-4 ml-auto">
						<button class="btn btn-info" onclick="sellerInstance.validateAndSubmitForm('commandForm');">@lang('messages.Save')</button>
						<button formnovalidate class="btn btn-outline-secondary" onclick="crudInstance.postFormBack('commandForm', '{{ $actionBack }}', 'GET');return;">@lang('messages.Cancel')</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
