<div class="card">
	<div class="card-header"><nav class="navbar navbar-expand-sm navbar-dark">@lang('messages.Actions')</nav></div>
	<div class="card-body">
		<div class="content">
			<ul class="nav flex-column nav-pills">
			  <li class="nav-item">
				@if (!is_null(Request::get('googleAuthorize')) && Request::get('googleAuthorize'))
					<form id="authorizeForm" method="GET" action="{{ route('security_revokeToken') }}">
						@csrf
						<input type="hidden" id="sourceUrl" name="sourceUrl" value="{{$sourceUrl}}">
						<button type="submit" class="btn btn-danger">@lang('messages.Revoke')</button>
					</form>
				@else
					<form id="authorizeForm" method="GET" action="{{ route('security_authorizeInit') }}">
						@csrf
						<input type="hidden" id="sourceUrl" name="sourceUrl" value="{{$sourceUrl}}">
						<button type="submit" class="btn btn-primary">@lang('messages.Authorize')</button>
					</form>
				@endif
			  </li>
			</ul>
		</div>
	</div>
</div>