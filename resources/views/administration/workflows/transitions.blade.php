<div class="card">
  <div class="card-body">
    <div class="row"><div id="spanMessage" class="alert alert-danger w-100" style="display:none;"><span></span></div></div>
    <div class="row">
      <div class="container"> 
		<form id="commandChildForm" method="POST" action="{{ $actionGetTransitions }}">
			@csrf
			<input type="hidden" id="tablePage" name="tablePage" value="{{ $tablePage }}">
			<input type="hidden" id="transitionName" name="transitionName" value="">
			@foreach ($filters->keys() as $filterKey)
			  <input type="hidden" name="{{$filterKey}}" value="{{ $filters->get($filterKey) }}">
			@endforeach
			<div class="form-group row">
				<div class="col-1"><label for="transition-anio" class="col-form-label">@lang('messages.Anio')</label></div>
				<div class="col-2"><input type="text" class="form-control" name="transition-anio" id="transition-anio" required></div>
				<div class="invalid-feedback">No, you missed this one.</div>
				<div class="col-2"><label for="transition-account_id" class="col-form-label">@lang('messages.Account')</label></div>
				<div class="col-3">
					{{ Form::select('transition-account_id', $accounts, null, ['required', 'placeholder' => 'Empresa...', 'class' => 'form-control', 'id' => 'transition-account_id'])}}
				</div>
				<div class="col-2"><label for="transition-category_id" class="col-form-label">@lang('messages.Category')</label></div>
				<div class="col-2">
					{{ Form::select('transition-category_id', $categories, null, ['required', 'placeholder' => 'Puesto...', 'class' => 'form-control', 'id' => 'transition-category_id'])}}
				</div>
			</div>
			<div class="form-group row">
				<div class="col-1"><label for="transition-zonas" class="col-form-label">@lang('messages.Zonas')</label></div>
				<div class="col-11"><input type="text" class="form-control" name="transition-zonas" id="transition-zonas" required></div>
			</div>
			<div class="form-group row">
				<div class="col-md-1">
					<label for="transition-comentarios" class="col-form-label">@lang('messages.Notes')</label>
				</div>
				<div class="col-md-11">
					@if ($errors->has('transition-comentarios'))
						{{ Form::textarea ('transition-comentarios', $command->comentarios, ['id' => 'transition-comentarios', 'class' => 'form-control is-invalid'])}}
						<span class="invalid-feedback">
							<strong>{{ $errors->first('transition-comentarios') }}</strong>
						</span>
					@else
						{{ Form::textarea ('transition-comentarios', $command->comentarios, ['id' => 'transition-comentarios', 'class' => 'form-control'])}}
					@endif
				</div>
			</div>
			<div class="row">
				<div class="mt-1 ml-auto">
				  <button type="reset" formnovalidate href="#" id="clearButton" onclick="workflowInstance.clearFields()" class="btn btn-info"><i class="pr-2 fa fa-undo"></i>Limpiar</button>
				  <button type="submit" id="addButton" onclick="workflowInstance.addElement('commandChildForm', '{{$actionAddTransition}}', '{{$actionRemoveTransition}}', 'POST', 'transitions-table', true)" role="add" class="btn btn-info">Agregar</button>
				</div>
			</div>
		</form>
      </div>
    </div>
    <div class="row mt-2">
      <div class="table-responsive">
        <table id="transitions-table" class="table table-striped table-hover">
          <thead>
            <tr>
              <td class="table-header">@lang('messages.Anio')</td>
              <td class="table-header">@lang('messages.Account')</td>
              <td class="table-header">@lang('messages.Category')</td>
              <td class="table-header"></td>
			  <td class="table-header"></td>
            </tr>
          </thead>
          <tbody>
            @foreach($transitions as $transition)
              <tr id="transition_.{{$transition->getTransitionKey()}}">
                <td>{{$transition->anio}}</td>
                <td>{{$transition->account->name}}</td>
                <td>{{$transition->category->name}}</td>
                <td><button type="button" onclick="workflowInstance.removeElement('commandChildForm', '{{$actionRemoveTransition}}', '{{$actionRemoveTransition}}', 'POST', '{{$transition->getTransitionKey()}}', 'transitions-table', true);" class="fa fa-remove delete-button"></button></td>
				<td><button type="button" onclick="workflowInstance.loadElement('commandChildForm', '{{$actionLoadTransition}}', 'POST', '{{$transition->getTransitionKey()}}', true);" class="fa fa-search button"></button></td>
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
