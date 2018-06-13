<button class="float-right navbar-toggler bg-light navbar-light" type="button" data-toggle="collapse" data-target="#{{$navactions_id}}" aria-controls="navactions" aria-expanded="false" aria-label="Toggle navigation">
	<span class="navbar-text navbar-toggler-icon"></span></button>
<div class="{{ $collapse }} navbar-collapse border rounded" id="{{$navactions_id}}">
	<div class="d-flex flex-column" style="width: 100%">
		<div class="d-none d-md-block p-2 bg-info text-white">@lang('messages.Actions')</div>
		@guest
			<div class="p-2 bg-light border-bottom">
				<a class="text-body" href="#">Opciones públicas</a>
			</div>
		@else
			<div class="p-2 bg-light border-bottom">
				<a class="text-body" href="#">ITEM 1</a>
			</div>
			@if (!is_null(Request::get('googleAuthorize')) && Request::get('googleAuthorize'))
				<div class="p-2 bg-light">
					<form id="authorizeForm" method="GET" action="{{ route('security_revokeToken') }}">
						@csrf
						@if(isset($sourceUrl))
							<input type="hidden" id="sourceUrl" name="sourceUrl" value="{{$sourceUrl}}">
						@endif
						<button type="submit" class="btn btn-danger btn-block"><i class="pr-2 fa fa-ban"></i>@lang('messages.Revoke')</button>
					</form>
				</div>
			@else
				<div class="p-2 bg-light">
					<form id="authorizeForm" method="GET" action="{{ route('security_authorizeInit') }}">
						@csrf
						@if(isset($sourceUrl))
							<input type="hidden" id="sourceUrl" name="sourceUrl" value="{{$sourceUrl}}">
						@endif
						<button type="submit" class="btn btn-success btn-block"><i class="pr-2 fa fa-check"></i>@lang('messages.Authorize')</button>
					</form>
				</div>
			@endif
		@endguest
	</div>
</div>
