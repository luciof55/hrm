<div class="btn-toolbar" role="toolbar" aria-label="">
	<div class="btn-group" role="group" aria-label="">
		@include('admin.only_buttons', ['btn_new' => $btn_new, 'btn_view' => $btn_view, 'btn_edit' => $btn_edit, 'btn_enable' => $btn_enable, 'btn_remove' => $btn_remove])
	</div>
	<div class="btn-group" role="group" aria-label="">
		@include('admin.only_buttons_small', ['btn_new' => $btn_new, 'btn_view' => $btn_view, 'btn_edit' => $btn_edit, 'btn_enable' => $btn_enable, 'btn_remove' => $btn_remove])
	</div>
</div>