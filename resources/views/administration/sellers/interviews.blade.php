<div class="card">
  <div class="card-body">
    <div class="row"><div id="spanMessage" class="alert alert-danger w-100" style="display:none;"><span></span></div></div>
    <div class="row">
      <div class="container"> 
		<form id="commandChildForm" method="POST" action="{{ $actionGetInterviews }}">
			@csrf
			<input type="hidden" id="tablePage" name="tablePage" value="{{ $tablePage }}">
			<input type="hidden" id="interviewName" name="interviewName" value="">
			@foreach ($filters->keys() as $filterKey)
			  <input type="hidden" name="{{$filterKey}}" value="{{ $filters->get($filterKey) }}">
			@endforeach
			<div class="form-group row">
				<div class="col-1"><label for="interview-anio" class="col-form-label">@lang('messages.Anio')</label></div>
				<div class="col-2"><input type="text" class="form-control" name="interview-anio" id="interview-anio" required></div>
				<div class="col-2"><label for="interview-account_id" class="col-form-label">@lang('messages.Account')</label></div>
				<div class="col-3">
					{{ Form::select('interview-account_id', $accounts, null, ['required', 'placeholder' => 'Empresa...', 'class' => 'form-control', 'id' => 'interview-account_id'])}}
				</div>
				<div class="col-2"><label for="interview-category_id" class="col-form-label">@lang('messages.Category')</label></div>
				<div class="col-2">
					{{ Form::select('interview-category_id', $categories, null, ['required', 'placeholder' => 'Puesto...', 'class' => 'form-control', 'id' => 'interview-category_id'])}}
				</div>
			</div>
			<div class="form-group row">
				<div class="col-1"><label for="interview-zonas" class="col-form-label">@lang('messages.Zonas')</label></div>
				<div class="col-11"><input type="text" class="form-control" name="interview-zonas" id="interview-zonas" required></div>
			</div>
			<div class="form-group row">
				<div class="col-md-1">
					<label for="interview-comentarios" class="col-form-label">@lang('messages.Notes')</label>
				</div>
				<div class="col-md-11">
					@if ($errors->has('interview-comentarios'))
						{{ Form::textarea ('interview-comentarios', $command->comentarios, ['id' => 'interview-comentarios', 'class' => 'form-control is-invalid', 'required' => 'required'])}}
						<span class="invalid-feedback">
							<strong>{{ $errors->first('interview-comentarios') }}</strong>
						</span>
					@else
						{{ Form::textarea ('interview-comentarios', $command->comentarios, ['id' => 'interview-comentarios', 'class' => 'form-control', 'required' => 'required'])}}
					@endif
				</div>
			</div>
			<div class="row">
				<div class="mt-1 ml-auto">
				  <button type="reset" formnovalidate href="#" id="clearButton" onclick="sellerInstance.clearFields()" class="btn btn-info"><i class="pr-2 fa fa-undo"></i>Limpiar</button>
				  <button type="submit" id="addButton" onclick="sellerInstance.addElement('commandChildForm', '{{$actionAddInterview}}', '{{$actionRemoveInterview}}', 'POST', 'interviews-table', true)" role="add" class="btn btn-info">Agregar</button>
				</div>
			</div>
		</form>
      </div>
    </div>
    <div class="row mt-2">
      <div class="table-responsive">
        <table id="interviews-table" class="table table-striped table-hover">
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
            @foreach($interviews as $interview)
              <tr id="interview_.{{$interview->getInterviewKey()}}">
                <td>{{$interview->anio}}</td>
                <td>{{$interview->account->name}}</td>
                <td>{{$interview->category->name}}</td>
                <td><button type="button" onclick="sellerInstance.removeElement('commandChildForm', '{{$actionRemoveInterview}}', '{{$actionRemoveInterview}}', 'POST', '{{$interview->getInterviewKey()}}', 'interviews-table', true);" class="fa fa-remove delete-button"></button></td>
				<td><button type="button" onclick="sellerInstance.loadElement('commandChildForm', '{{$actionLoadInterview}}', 'POST', '{{$interview->getInterviewKey()}}', true);" class="fa fa-search button"></button></td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
    <div class="row">
      <div class="container">
        <div class="d-flex flex-fill flex-row">
          <div id="divInterviewPagination" class="p-1">{{ $interviews->links('vendor.pagination.bootstrap-4', ['paginationFunction' => 'sellerInstance.paginateInterviews']) }}</div>
        </div>
      </div>
    </div>
  </div>
</div>
