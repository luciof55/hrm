<div class="card">
  <div class="card-body">
    <form id="commandForm" method="POST" action="{{ $action }}">
      @csrf
      <input id="id" name="id" type="hidden" value="{{ $command->id }}">
      <input type="hidden" id="_method" name="_method" value="{{ $method }}">
      <input type="hidden" id="page" name="page" value="{{ $page }}">
      <input type="hidden" id="activeTab" name="activeTab" value="{{ $activeTab }}">
      @foreach ($filters->keys() as $filterKey)
        <input type="hidden" name="{{$filterKey}}" value="{{ $filters->get($filterKey) }}">
      @endforeach
      @include('order_fields')
      @if (isset($command->initialState))
        <?php $initial_state_id = $command->initialState->id; ?>
      @else
        <?php $initial_state_id = null; ?>
      @endif
      @if (isset($command->finalState))
        <?php $final_state_id = $command->finalState->id; ?>
      @else
        <?php $final_state_id = null; ?>
      @endif
      <div class="form-group row">
        <label for="name" class="col-md-4 col-form-label text-md-right">@lang('messages.Name')</label>
        <div class="col-md-6">
          <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ $command->name }}" required autofocus>
          @if ($errors->has('name'))
            <span class="invalid-feedback">
              <strong>{{ $errors->first('name') }}</strong>
            </span>
          @endif
        </div>
      </div>
      <div class="form-group row">
        <label for="initial_state_id" class="col-md-4 col-form-label text-md-right">@lang('messages.BusinessRecordState')</label>
        <div class="col-md-6">
          @if ($errors->has('initial_state_id'))
            {{ Form::select('initial_state_id', $states, $initial_state_id, ['required', 'placeholder' => 'Pick a state...', 'class' => 'form-control is-invalid'])}}
            <span class="invalid-feedback">
              <strong>{{ $errors->first('initial_state_id') }}</strong>
            </span>
          @else
            {{ Form::select('initial_state_id', $states, $initial_state_id, ['required', 'placeholder' => 'Pick a state...', 'class' => 'form-control'])}}
          @endif
        </div>
      </div>
      <div class="form-group row">
        <label for="final_state_id" class="col-md-4 col-form-label text-md-right">@lang('messages.BusinessRecordState')</label>
        <div class="col-md-6">
          @if ($errors->has('final_state_id'))
            {{ Form::select('final_state_id', $states, $final_state_id, ['required', 'placeholder' => 'Pick a state...', 'class' => 'form-control is-invalid'])}}
            <span class="invalid-feedback">
              <strong>{{ $errors->first('final_state_id') }}</strong>
            </span>
          @else
            {{ Form::select('final_state_id', $states, $final_state_id, ['required', 'placeholder' => 'Pick a state...', 'class' => 'form-control'])}}
          @endif
        </div>
      </div>
    </form>
  </div>
</div>
