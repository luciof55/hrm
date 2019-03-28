	@if ($btn_new && Gate::allows('create', $entity))
		<button id="button_new_sm" type="button" onclick="crudInstance.create('{{route($actionCreate)}}');" class="d-block d-md-none btn btn-info btn-md"><i class="fa fa-plus"></i></button>
	@endif
	@if ($btn_view && Gate::allows('view', $entity))
		<button id="button_view_sm" type="button" onclick="crudInstance.view('{{$entity}}', '{{$actionView}}');" class="d-block d-md-none btn btn-info btn-md disabled"><i class="fa fa-file"></i></button>
	@endif
	@if ($btn_edit && Gate::allows('edit', $entity))
		<button id="button_edit_sm" type="button" onclick="crudInstance.edit('{{$entity}}', '{{$actionEdit}}');" class="d-block d-md-none btn btn-info btn-md disabled"><i class="fa fa-edit"></i></button>
	@endif
	@if ($btn_enable && Gate::allows('enable', $entity) && $isSoftDelete)
		<button id="button_enable_sm" data-action="{{$actionEnable}}" data-method="GET" data-entity="{{$entity}}" data-toggle="modal" data-target="#confirmation-modal" data-selectrowtext="@lang('messages.selectrowtext')" data-title="@lang('messages.EnableTitle')" data-body="@lang('messages.EnableRow')" class="d-block d-md-none btn btn-info btn-md disabled"><i class="fa fa-ban"></i></button>
	@endif
	@if ($btn_remove && Gate::allows('remove', $entity))
		<button id="button_remove_sm" data-action="{{$actionDelete}}" data-method="GET" data-entity="{{$entity}}" data-toggle="modal" data-target="#confirmation-modal" data-selectrowtext="@lang('messages.selectrowtext')" data-title="@lang('messages.RemoveTitle')" data-body="@lang('messages.RemoveRow')" class="d-block d-md-none btn btn-info btn-md disabled"><i class="fa fa-trash"></i></button>
	@endif