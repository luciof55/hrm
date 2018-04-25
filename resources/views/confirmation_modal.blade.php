<div class="modal fade" id="confirmation-modal" tabindex="-1" role="dialog" aria-labelledby="confirmation-modal-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 id="header_confirm_title">{{ $headerText }}</h4>
            </div>
            <div id="body_div_confirm_modal" class="modal-body">
                {{ $bodyText }}
            </div>
            <div class="modal-footer">
				<button type="button" class="btn btn-primary" data-dismiss="modal">@lang('messages.Cancel')</button>
				<button id="button_confirm_modal" class="btn btn-danger btn-ok" onclick="crudInstance.executeAction();">@lang('messages.Confirm')</button>
            </div>
        </div>
    </div>
</div>