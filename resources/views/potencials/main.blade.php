<div class="d-flex flex-column">
  <div class="p-2 text-white bg-info border-bottom rounded-top">
      <div class="d-flex">
        <div><span>Dashboard</span></diV>
        <div class="ml-auto">
          <div class="d-block d-md-none">@include('actions', ['sourceUrl' => '/home', 'collapse' => 'collapse', 'navactions_id' => 'navactions_sm'])</div>
        </div>
      </div>
  </div>
  <div class="p-2 text-black border-bottom bg-light">
    <form id="actionForm" action="{{$action}}" metdod="GET">
      @csrf
      <input type="hidden" id="method" name="method" value="{{ $method }}">
      <input type="hidden" id="page" name="page" value="{{ $page }}">
      <input type="hidden" id="id" name="id" value="">
      <input type="hidden" id="columnOrder" name="columnOrder" value="@if(isset($columnOrder)){{$columnOrder}}@endif">
      @include('order_fields')
      <div class="d-flex bg-light">
        <div class="p-1"><label for="name_filter" class="col-form-label text-md-right">@lang('messages.Name')</label></div>
        <div class="p-1"><input class="form-control" type="text" placeholder="@lang('messages.Name')" id="name_filter" name="name_filter" value="{{ $filters->get('name_filter') }}" autofocus></div>
        <div class="p-1"><label for="account_id_filter" class="col-form-label text-md-right">@lang('messages.Account')</label></div>
        <div class="p-1">{{ Form::select('account_id_filter', $accounts, $filters->get('account_id_filter'), ['placeholder' => 'Pick a account...', 'class' => 'form-control'])}}</div>
        <div class="p-1"><label for="state_id_filter" class="col-form-label text-md-right">@lang('messages.BusinessRecordState')</label></div>
        <div class="p-1">{{ Form::select('state_id_filter', $states, $filters->get('state_id_filter'), ['placeholder' => 'Pick a state...', 'class' => 'form-control'])}}</div>
        <div class="p-1">
            <button class="d-none d-sm-block btn btn-info" type="submit"><i class="pr-2 fa fa-search"></i>@lang('messages.Search')</button>
            <button class="d-block d-sm-none btn btn-info" type="submit"><i class="fa fa-search"></i></button>
          </div>
        <div class="p-1">
          <button class="d-none d-sm-block btn btn-info" type="reset"><i class="pr-2 fa fa-undo"></i>Reset</button>
          <button class="d-block d-sm-none btn btn-info" type="reset"><i class="fa fa-undo"></i></button>
        </div>
      </div>
    </form>
  </div>
</div>
<div class="card-body">
  <div class="row">
    <div class="container">
      @include('common_status')
      <div class="table-responsive">
        <table class="table table-striped table-hover">
          <thead>
            <tr>
            <td class="table-header">
              @include('column_order', ['column_order' => 'name_order', 'column_text' => 'messages.Name'])
            </td>
            <td class="table-header">
              @include('column_order', ['column_order' => 'account-name_order', 'column_text' => 'messages.Account'])
            </td>
            <td class="table-header">
              @include('column_order', ['column_order' => 'comercial-name_order', 'column_text' => 'messages.Comercial'])
            </td>
            <td class="table-header">
              @include('column_order', ['column_order' => 'state-name_order', 'column_text' => 'messages.BusinessRecordState'])
            </td>
            </tr>
          </thead>
          <tbody>
            @foreach ($list as $command)
              <tr id="{{$entity}}_{{$command->id}}" class="@if ($command->trashed()) bg-light text-muted @endif" onclick="potencialInstance.setCurrentRowId('{{$entity}}_{{$command->id}}');">
                <td>{{ $command->name }}</td>
                <td>{{ $command->account->name }}</td>
                <td>{{ $command->comercial->name }}</td>
                <td>{{ $command->state->name }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="container">
      <div class="d-flex flex-fill flex-row">
        <div class="p-1">{{ $list->links() }}</div>
        <div class="p-1 ml-auto">
          <div class="btn-group" role="group" aria-label="">
            <button id="button_excel" type="button" onclick="potencialInstance.generateExcel('{{$actionExcel}}', '{{$entity}}');" class="d-none d-md-block btn btn-info btn-md disabled"><i class="pr-2 fa fa-download mr-1"></i>@lang('messages.ExportFile')</button>
            <button id="button_excel_sm" type="button" onclick="potencialInstance.generateExcel('{{$actionExcel}}', '{{$entity}}');" class="d-block d-md-none btn btn-info btn-sm disabled"><i class="fa fa-download"></i></button>
            @if (Gate::allows('edit', $entity))
              <button id="button_edit_sm" type="button" onclick="crudInstance.edit('{{$entity}}', '{{$actionEdit}}');" class="d-block d-md-none btn btn-info btn-md disabled"><i class="fa fa-edit"></i></button>
              <button id="button_edit" type="button" onclick="crudInstance.edit('{{$entity}}', '{{$actionEdit}}');" class="d-none d-md-block btn btn-info btn-md disabled"><i class="pr-2 fa fa-edit mr-1"></i>@lang('messages.Edit')</button>
          	@endif
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
