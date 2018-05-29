@extends('layouts.app')
@section('header')
<ul class="navbar-nav mr-auto">
	@if (Gate::allows('module', 'accounts'))
		@if(Request::path() == 'accounts')
			<li class="nav-item nav-link active">@lang('messages.Accounts')</li>
		@else
			<li class="nav-item"><a class="nav-link" href="{{route('administration.accounts.index')}}">@lang('messages.Accounts')</a></li>
		@endif
	@endif
	@if (Gate::allows('module', 'contacts'))
		@if(Request::path() == 'contacts')
			<li class="nav-item nav-link active">@lang('messages.Contacts')</li>
		@else
			<li class="nav-item"><a class="nav-link" href="{{route('administration.contacts.index')}}">@lang('messages.Contacts')</a></li>
		@endif
	@endif
	@if (Gate::allows('module', 'businessrecordstates'))
		@if(Request::path() == 'businessrecordstates')
			<li class="nav-item nav-link active">@lang('messages.BusinessRecordStates')</li>
		@else
			<li class="nav-item"><a class="nav-link" href="{{route('administration.businessrecordstates.index')}}">@lang('messages.BusinessRecordStates')</a></li>
		@endif
	@endif
	@if (Gate::allows('module', 'businessrecords'))
		@if(Request::path() == 'businessrecords')
			<li class="nav-item nav-link active">@lang('messages.BusinessRecords')</li>
		@else
			<li class="nav-item"><a class="nav-link" href="{{route('administration.businessrecords.index')}}">@lang('messages.BusinessRecords')</a></li>
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
