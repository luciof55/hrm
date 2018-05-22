@extends('layouts.app')
@section('header')
	<ul class="navbar-nav">
		<button class="navbar-toggler navbar-toggler-left" type="button" data-toggle="collapse" data-target="#navbmenuadmin">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbmenuadmin">
			<ul class="navbar-nav mr-auto">
				@if (Gate::allows('module', 'accounts'))
				<li class="nav-item active"><a class="nav-link" href="{{route('accounts.index')}}">@lang('messages.Accounts')</a></li>
				@endif
				@if (Gate::allows('module', 'contacts'))
				<li class="nav-item active"><a class="nav-link" href="{{route('contacts.index')}}">@lang('messages.Contacts')</a></li>
				@endif
				@if (Gate::allows('module', 'businessrecordstates'))
				<li class="nav-item active"><a class="nav-link" href="{{route('businessrecordstates.index')}}">@lang('messages.BusinessRecordStates')</a></li>
				@endif
				@if (Gate::allows('module', 'businessrecords'))
				<li class="nav-item active"><a class="nav-link" href="{{route('businessrecords.index')}}">@lang('messages.BusinessRecords')</a></li>
				@endif
			</ul>
		</div>
	</ul>
@endsection
@section('content')
@yield('administrationContent')
@endsection
@section('footer')
@include('footer')
@endsection