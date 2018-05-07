@extends('layouts.app')
@section('content')
<div class="row justify-content-center">
	<div class="col-md-8">
		<div class="card">
			<div class="card-header">@lang('messages.MenuItem')</div>
			<div class="card-body">
				<form method="GET" action="{{ $action }}">
					@csrf
					<input type="hidden" id="_method" name="_method" value="{{ $method }}">
					<input type="hidden" name="page" value="{{ $page }}">
					@foreach ($filters->keys() as $filterKey)
						<input type="hidden" name="{{$filterKey}}" value="{{ $filters->get($filterKey) }}">
					@endforeach
					<div class="form-group row">
						<label for="resource" class="col-md-4 col-form-label text-md-right">@lang('messages.Resource')</label>
						<div class="col-md-6">
							<input id="resource" type="text" class="form-control" name="resource" value="{{ $command->resource->display_name }}" autofocus readonly>
						</div>
					</div>
					
					<div class="form-group row">
						<label for="type" class="col-md-4 col-form-label text-md-right">@lang('messages.MenuType')</label>
						<div class="col-md-6">
							<input id="type" type="text" class="form-control" name="type" value="{{ $command->getType() }}" readonly>
						</div>
					</div>
					
					<div class="form-group row">
						<label for="url" class="col-md-4 col-form-label text-md-right">URL</label>
						<div class="col-md-6">
							<input id="url" type="text" class="form-control" name="url" value="{{ $command->url }}" readonly>
						</div>
					</div>

					<div class="form-group row mb-0">
						@include('admin.down_buttons', ['btn_save' => false])
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection
