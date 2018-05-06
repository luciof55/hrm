@extends('admin.layout')
@section('securityContent')
<div class="row justify-content-center">
	<div class="col-md-2">
		@include('actions', ['sourceUrl' => '/security'])
	</div>
	<div class="col-md-10">
		<div class="card">
			<div class="card-header"><nav class="navbar navbar-expand-sm navbar-dark">NAVBAR</nav></div>
			<div class="card-body">
				<div class="row"><div class="container">@include('common_status')</div></div>
				<div class="row">
					<div class="container">
						@if ($authorize)
							<h3>{{$AppName}}</h3>
							@if (isset($results))
								<div class="table-responsive">
									<table class="table table-bordered table-hover">
										<thead>
										  <tr>
											<th>@lang('messages.Files')</th>
										  </tr>
										</thead>
										<tbody>
											@foreach ($results->getFiles() as $file)
												<tr>
													<td><img src="{{ asset('public/img/icon_1_spreadsheet_x16.png')}}" alt=""> {{ $file->getName() }}</td>
												</tr>
											@endforeach
										</tbody>
									</table>
								</div>
							@endif
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection