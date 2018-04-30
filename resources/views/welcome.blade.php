@extends('layouts.app')


@section('header')
<div class="row justify-content-center">
	UN MENU
</div>
@endsection

@section('content')
<div class="row justify-content-center">
	<div class="col-md-2">
		<div class="card">
			<div class="card-header">@lang('messages.Actions')</div>
		</div>
	</div>
	<div class="col-md-10">
		@if(isset($status))
			<div class="alert alert-danger">
				{{ $status }}
			</div>
		@endif
	</div>
</div>
@endsection

@section('footer')
<div class="row justify-content-center">
	FOOTER
</div>
@endsection