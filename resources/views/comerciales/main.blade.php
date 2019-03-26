@extends('administration.layout')
@section('administrationContent')
<div class="row justify-content-center">
	<div class="col-md-2">
		<div class="d-none d-md-block navbar-expand-md">
				@include('administration.actions', ['collapse' => '', 'navactions_id' => 'navactions'])
		</div>
	</div>
	<div class="col-md-10">
		<div class="card">
			<div class="d-flex flex-column">
			  <div class="p-2 text-white bg-info border-bottom rounded-top">
				  <div class="d-flex">
					<div><span>Dashboard</span></div>
					<div class="ml-auto">
					  <div class="d-block d-md-none">@include('actions', ['sourceUrl' => '/home', 'collapse' => 'collapse', 'navactions_id' => 'navactions_sm'])</div>
					</div>
				  </div>
			  </div>
			</div>
			<div class="card-body">
				<div class="row"><div class="container">@include('common_status')</div></div>
				<div class="row">
					<div class="col-sm-12">
						<div class="card">
							<div class="card-body">
								<h5 class="card-title">Últimos Comerciales</h5>
								@foreach ($list as $command)
									@if ($loop->iteration % 3 == 1)
										<div class="card-deck">
									@endif
									<div class="card border-info mb-3" style="max-width: 18rem;">
										<div class="card-header"><a href="{{route('administration.workflows.edit', ['id' => $command->id])}}">{{ $command->name }} - {{$command->telefono}}</a> - <span class="badge badge-light">{{count($command->transitions)}} Entrevistas</span></div>
										<div class="card-body text-info">
											@if ($command->transitions)
												<h5 class="card-title">{{$command->transitions[0]->account->name}} / {{$command->transitions[0]->anio}} </h5>
												<p class="card-text">{{$command->transitions[0]->comentarios}}</p>
											@endif
										</div>
										<div class="card-footer"><small class="text-muted">Creado: {{$command->transitions[0]->created_at}}</small></div>
									</div>
									@if ($loop->iteration % 3 == 0)
										</div>
									@endif
								@endforeach
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection