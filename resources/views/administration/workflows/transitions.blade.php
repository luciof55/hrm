<div class="card">
  <div class="card-body">
    <div class="row"><div id="spanMessage" class="alert alert-danger w-100" style="display:none;"><span></span></div></div>
    <div class="row">
      <div class="container">
        <div class="d-flex flex-fill flex-row">
            <div class="p-1">
              <form id="commandChildForm" method="POST" action="{{ $actionGetTransitions }}">
                @csrf
                <input type="hidden" id="tablePage" name="tablePage" value="{{ $tablePage }}">
                <input type="hidden" id="deleteTransitionName" name="deleteTransitionName" value="">
                @foreach ($filters->keys() as $filterKey)
                  <input type="hidden" name="{{$filterKey}}" value="{{ $filters->get($filterKey) }}">
                @endforeach
                <div class="form-group row">
                  <div class="form-row align-items-center">
                    <div class="col-auto"><label for="transition-name">@lang('messages.Name')</label></div>
                    <div class="col-auto"><input type="text" class="form-control" name="transition-name" id="transition-name" required></div>
                    <div class="invalid-feedback">No, you missed this one.</div>
                    <div class="col-auto"><label for="transition-from_state_id">@lang('messages.StateFrom')</label></div>
                    <div class="col-auto">
                      {{ Form::select('transition-from_state_id', $states, null, ['required', 'placeholder' => 'Pick a state...', 'class' => 'form-control'])}}
                    </div>
                    <div class="col-auto"><label for="transition-to_state_id" class="">@lang('messages.StateTo')</label></div>
                    <div class="col-auto">
                      {{ Form::select('transition-to_state_id', $states, null, ['required', 'placeholder' => 'Pick a state...', 'class' => 'form-control'])}}
                    </div>
                    <div class="col-auto">
                      <button type="submit" onclick="workflowInstance.addElement('commandChildForm', '{{$actionAddTransition}}', '{{$actionRemoveTransition}}', 'POST', 'transitions-table', true)" class="btn btn-info">Add</button>
                    </div>
                  </div>
                </div>
              </form>
            </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="table-responsive">
        <table id="transitions-table" class="table table-striped table-hover">
          <thead>
            <tr>
              <td class="table-header">@lang('messages.Name')</td>
              <td class="table-header">@lang('messages.BusinessRecordState')</td>
              <td class="table-header">@lang('messages.BusinessRecordState')</td>
              <td class="table-header"></td>
            </tr>
          </thead>
          <tbody>
            @foreach($transitions as $transition)
              <tr id="transition_.{{$transition->getCleanName()}}">
                <td>{{$transition->name}}</td>
                <td>{{$transition->fromState->name}}</td>
                <td>{{$transition->toState->name}}</td>
                <td><button type="button" onclick="workflowInstance.removeElement('commandChildForm', '{{$actionRemoveTransition}}', '{{$actionRemoveTransition}}', 'POST', '{{$transition->name}}', 'transitions-table', true);" class="fa fa-remove delete-button"></button></td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
    <div class="row">
      <div class="container">
        <div class="d-flex flex-fill flex-row">
          <div id="divTransitionPagination" class="p-1">{{ $transitions->links('vendor.pagination.bootstrap-4', ['paginationFunction' => 'workflowInstance.paginateTransitions']) }}</div>
        </div>
      </div>
    </div>
  </div>
</div>
