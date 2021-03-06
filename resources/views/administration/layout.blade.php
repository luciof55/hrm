@extends('layouts.app')
@section('header')
<div id="thetop" class='thetop'></div>
<ul class="navbar-nav mr-auto">
	@if (Gate::allows('module', 'sellers'))
		@if(Request::path() == 'sellers')
			<li class="nav-item nav-link active">Comerciales</li>
		@else
			<li class="nav-item"><a class="nav-link" href="{{route('administration.sellers.index')}}">Comerciales</a></li>
		@endif
	@endif
	@if (Gate::allows('module', 'accounts'))
		@if(Request::path() == 'accounts')
			<li class="nav-item nav-link active">@lang('messages.Accounts')</li>
		@else
			<li class="nav-item"><a class="nav-link" href="{{route('administration.accounts.index')}}">@lang('messages.Accounts')</a></li>
		@endif
	@endif
	@if (Gate::allows('module', 'categories'))
		@if(Request::path() == 'categories')
			<li class="nav-item nav-link active">Puestos</li>
		@else
			<li class="nav-item"><a class="nav-link" href="{{route('main.categories.index')}}">Puestos</a></li>
		@endif
	@endif
</ul>
@endsection
@section('content')
@yield('administrationContent')
@endsection
@section('footer')
@include('footer')
@endsection
