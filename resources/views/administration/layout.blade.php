@extends('layouts.app')
@section('header')
	<nav class="navbar navbar-expand-sm navbar-light bg-light">
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarAdministration" aria-controls="navbarAdministration" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="navbarAdministration">
			<ul class="navbar-nav mr-auto">
			  <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbmenuadmin">
				<span class="navbar-toggler-icon"></span>
			  </button>
			  <div class="collapse navbar-collapse" id="navbmenuadmin">
				<ul class="navbar-nav mr-auto">
					@if (Gate::allows('module', 'accounts'))
					<li class="nav-item active"><a class="nav-link" href="{{route('accounts.index')}}">@lang('messages.Accounts')</a></li>
					@endif
				 </ul>
			  </div>
			</ul>
		</div>
    </nav>
@endsection
@section('content')
@yield('administrationContent')
@endsection
@section('footer')
<div class="row justify-content-center">
	FOOTER
</div>
@endsection