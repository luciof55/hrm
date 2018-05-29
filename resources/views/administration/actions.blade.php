
	<button class="float-right navbar-toggler bg-light navbar-light" type="button" data-toggle="collapse" data-target="#{{$navactions_id}}" aria-controls="navactions" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-text navbar-toggler-icon"></span></button>
	<div class="{{ $collapse }} navbar-collapse border rounded" id="{{$navactions_id}}">
		<div class="d-flex flex-column" style="width: 100%">
			<div class="d-none d-md-block p-2 bg-info text-white">@lang('messages.Actions')</div>
			<div class="p-2 bg-light border-bottom">
				<a class="text-body" href="{{route('administration.businessrecords.index')}}">ITEM 1</a>
			</div>
			<div class="p-2 bg-light">
				<a class="text-body" href="{{route('administration.businessrecords.index')}}">ITEM 2</a>
			</div>
		</div>
	</div>
