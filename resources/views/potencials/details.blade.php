@extends('layouts.app')
@section('header')
<ul class="navbar-nav mr-auto">
	@if (Gate::allows('module', 'businessrecords'))
		@if(Request::path() == 'businessrecords')
			<li class="nav-item nav-link active">@lang('messages.BusinessRecords')</li>
		@else
			<li class="nav-item"><a class="nav-link" href="{{route('main.businessrecords.index')}}">@lang('messages.BusinessRecords')</a></li>
		@endif
	@endif
</ul>
@endsection
@section('content')
<div class="card">
  <h4 class="card-header">
    <form method="GET" action="{{ $actionBack }}">
      @csrf
      <input type="hidden" id="_method" name="_method" value="{{ $method }}">
      <input type="hidden" name="page" value="{{ $page }}">
      @foreach ($filters->keys() as $filterKey)
        <input type="hidden" name="{{$filterKey}}" value="{{ $filters->get($filterKey) }}">
      @endforeach
      <input type="hidden" id="columnOrder" name="columnOrder" value="@if(isset($columnOrder)){{$columnOrder}}@endif">
      @include('order_fields')
      <button class="btn" type="submit"><i class="mr-2 fa fa-arrow-circle-left"></i>Volver</button> {{ $command->name }}
    </form>
  </h4>
  <div class="card-body">
    <div class="progress">
      <div class="progress-bar bg-danger" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">25%</div>
    </div>
    <h6><p class="mt-2 mb-2 card-text">{{$command->notes}}</p></h6>
    <div class="row">
        <div class="col-12">
          <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
              <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">General</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">PMO</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">...</a>
            </li>
          </ul>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
          <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
              <div class="card">
                <div class="card-body">
                    <div class="form-group row">
                      <div class="col-2">
                        <label for="account" class="col-form-label text-md-right">@lang('messages.Account')</label>
                      </div>
                      <div class="col-6">
                        <input id="account" type="text" class="form-control" name="acount" value="{{ $command->account->name }}" readonly>
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-2">
                        <label for="state_id" class="col-form-label text-md-right">@lang('messages.BusinessRecordState')</label>
                      </div>
                      <div class="col-6">
                        <input id="state_id" type="text" class="form-control" name="state_id" value="{{ $command->state->name }}" readonly>
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-2">
                        <label for="comercial" class="col-form-label text-md-right">@lang('messages.Comercial')</label>
                      </div>
                      <div class="col-6">
                        <input id="comercial" type="text" class="form-control" name="comercial" value="@if(isset($command->comercial)) {{ $command->comercial->name }} @endif" readonly>
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-2">
                        <label for="leader" class="col-form-label text-md-right">@lang('messages.Leader')</label>
                      </div>
                      <div class="col-6">
                        <input id="leader" type="text" class="form-control" name="leader" value="@if(isset($command->leader)) {{ $command->leader->name }} @endif" readonly>
                      </div>
                    </div>
                </div>
              </div>
            </div>
            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
              <div class="card">
                <div class="card-body">
                  <div class="form-group row">
                    <div class="col-2">
                      <label for="management_tool" class="col-form-label text-md-right">@lang('messages.ManagementTool')</label>
                    </div>
                    <div class="col-6">
                      <input id="management_tool" type="url" class="form-control" name="management_tool" value="{{ $command->management_tool }}" readonly>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-2">
                      <label for="repository" class="col-form-label text-md-right">@lang('messages.Repository')</label>
                    </div>
                    <div class="col-6">
                      <input id="repository" type="url" class="form-control" name="repository" value="{{ $command->repository }}" readonly>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">...</div>
          </div>
        </div>
    </div>
  </div>
</div>

@endsection
@section('footer')
@include('footer')
@endsection
