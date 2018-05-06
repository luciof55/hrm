@extends('administration.layout')
@section('administrationContent')
<div class="row justify-content-center">
	<div class="col-md-2">
		@include('administration.actions')
	</div>
	<div class="col-md-10">
		<div class="card">
			<div class="card-header"><nav class="navbar navbar-expand-sm navbar-dark">NAVBAR</nav></div>
			<div class="card-body">
				<div class="row"><div class="container">@include('common_status')</div></div>
				<div class="row">
					<div class="container">
						Administration
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection