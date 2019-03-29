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
			<div class="card-header bg-light" style="padding: 0px">
				<div class="p-2 text-white bg-info border-bottom rounded-top">
					<div class="d-flex">
						<div><span>Dashboard</span></div>
						<div class="ml-auto">
							<div class="d-block d-md-none">@include('actions', ['sourceUrl' => '/home', 'collapse' => 'collapse', 'navactions_id' => 'navactions_sm'])</div>
						</div>
					</div>
				</div>
				<div class="p-1 bg-light text-black">
					<form id="actionForm" action="{{route('home')}}" metdod="POST">
						@csrf
						<input type="hidden" id="method" name="method" value="POST">
						<input type="hidden" id="page" name="page" value="{{ $page }}">
						<input type="hidden" id="id" name="id" value="">
						<div class="form-row mb-2">
							<div class="col-1"><label for="name_filter" class="col-form-label text-md-right">@lang('messages.Name')</label></div>
							<div class="col-3">
								<input class="form-control" type="text" placeholder="@lang('messages.Name')" id="name_filter" name="name_filter" value="{{ $filters->get('name_filter') }}" autofocus>
							</div>
							<div class="col-1">
								<label class="col-form-label text-md-right" for="entrevistado_filter">@lang('messages.Entrevistado')</label>
							</div>
							<div class="col-3">
								{{ Form::select('entrevistado_filter', $entrevistadoOptions, $filters->get('entrevistado_filter'), ['placeholder' => 'Entrevistado...', 'class' => 'form-control', 'id' => 'entrevistado_filter'])}}
							</div>
							<div class="col-4">
								<div class="d-flex justify-content-end">
									<div class="p-1">
										<button class="d-none d-sm-block btn btn-info" type="submit"><i class="pr-2 fa fa-search"></i>@lang('messages.Search')</button>
										<button class="d-block d-sm-none btn btn-info" type="submit"><i class="fa fa-search"></i></button>
									</div>
									<div class="p-1">
										<button class="d-none d-sm-block btn btn-info" type="reset"><i class="pr-2 fa fa-undo"></i>Reset</button>
										<button class="d-block d-sm-none btn btn-info" type="reset"><i class="fa fa-undo"></i></button>
									</div>
									<div class="p-1">
										<button class="d-none d-sm-block btn btn-info" type="reset"><i class="pr-2 fa fa-undo"></i>@lang('messages.New')</button>
										<button class="d-block d-sm-none btn btn-info" type="reset"><i class="fa fa-undo"></i></button>
									</div>
								</div>
							</div>
						</div>
						<div class="form-row">
							<div class="col-1"><label for="transitions-account_id_filter" class="col-form-label text-md-right">@lang('messages.Account')</label></div>
							<div class="col-3">
								{{ Form::select('transitions-account_id_filter', $accounts, $filters->get('transitions-account_id_filter'), ['placeholder' => 'Empresa...', 'class' => 'form-control', 'id' => 'transitions-account_id_filter'])}}
							</div>
							<div class="col-1"><label for="transition-zonas_filter" class="col-form-label text-md-right">@lang('messages.Zonas')</label></div>
							<div class="col-3">
								<input class="form-control" type="text" placeholder="@lang('messages.Zonas')" id="transitions-zonas_filter" name="transitions-zonas_filter" value="{{ $filters->get('transitions-zonas_filter') }}">
							</div>
							<div class="col-1"><label for="transition-anio_filter" class="col-form-label text-md-right">@lang('messages.Anio')</label></div>
							<div class="col-3">
								<input class="form-control" type="text" placeholder="@lang('messages.Anio')" id="transitions-anio_filter" name="transitions-anio_filter" value="{{ $filters->get('transitions-anio_filter') }}">
							</div>
						</div>
					</form>
				</div>
			</div>
			
			<div class="card-body">
				<div class="row"><div class="container">@include('common_status')</div></div>
				<div class="row">
					<h5>{{$resultMessage}}</h5>
				</div>
				<div class="d-flex flex-column">	
					@foreach ($list as $command)
						@if ($loop->iteration % 3 == 1)
							<div class="card-deck d-flex flex-row">
						@endif
						<div class="card border-info mb-3" style="max-width: 18rem;">
							<div class="card-header">
								<a href="{{route('administration.workflows.edit', ['id' => $command->id])}}">{{ $command->name }}</a> - <span class="badge badge-light">{{count($command->transitions)}} Entrevistas</span>
								@if (!blank($command->files))
									<a href="{{route('administration.workflows_download')}}?id={{$command->id}}"><i class="fa fa-download"></i></a>
								@endif
							</div>
							<div class="card-body" style="padding: 0px">
								@if ($command->transitions)
									<ul class="list-group list-group-flush">
									@foreach ($command->transitions as $transition)
										<li class="list-group-item">{{$transition->anio}} - {{$transition->account->name}} - {{$transition->zonas}}</li>
									@endforeach
									</ul>
								@endif
							</div>
							<div class="card-footer"><small class="text-muted">Creado: {{$command->created_at}}</small></div>
						</div>
						@if ($loop->iteration % 3 == 0 || $loop->last)
							</div>
						@endif
					@endforeach
				</div>
			</div>
				
			<div class="card-footer bg-light" style="padding: 0px">
				<div class="p-2">{{ $list->links() }}</div>
			</div>
		</div>
	</div>
</div>
@endsection