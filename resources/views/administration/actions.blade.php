<div class="d-flex flex-column border rounded">
	<div class="p-2 bg-warning">@lang('messages.Actions')</div>
	@if (Gate::allows('module', 'businessrecords'))
		<div class="p-2 bg-info border-bottom">
			<a class="text-white" href="{{route('businessrecords.index')}}">@lang('messages.BusinessRecords')</a>
		</div>
	@endif
	<div class="p-2 bg-light border-bottom">
		<a class="text-body" href="{{route('businessrecords.index')}}">@lang('messages.BusinessRecords')</a>
	</div>
	<div class="p-2 bg-light">
		<a class="text-body" href="{{route('businessrecords.index')}}">@lang('messages.BusinessRecords')</a>
	</div>
</div>