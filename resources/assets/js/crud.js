function crud() {
  var _values_id = {};

	this.setCurrentRowId = function (id) {
		var array_id = id.split('_');
		var variable_name = 'crud_' + array_id[0] + '_id';
		old_id = this.getEntityId(array_id[0]);
		if (old_id != '' && old_id != null) {
			$('#' + array_id[0] + '_' + old_id).removeClass('table-active');
			if (old_id == array_id[1]) {
				_values_id[variable_name] = null;
				$('#button_view').addClass('disabled');
				$('#button_edit').addClass('disabled');
				$('#button_enable').addClass('disabled');
				$('#button_remove').addClass('disabled');
				$('#button_view_sm').addClass('disabled');
				$('#button_edit_sm').addClass('disabled');
				$('#button_enable_sm').addClass('disabled');
				$('#button_remove_sm').addClass('disabled');
				return;
			};
		};
		_values_id[variable_name] = array_id[1];
		$('#button_view').removeClass('disabled');
		$('#button_edit').removeClass('disabled');
		$('#button_enable').removeClass('disabled');
		$('#button_remove').removeClass('disabled');
		$('#button_view_sm').removeClass('disabled');
		$('#button_edit_sm').removeClass('disabled');
		$('#button_enable_sm').removeClass('disabled');
		$('#button_remove_sm').removeClass('disabled');

		if ($('#' + id).hasClass('text-muted')) {
			$('#button_enable').html('<i class="pr-2 fa fa-check mr-1"></i>' + 'Habilitar');
			$('#button_enable_sm').html('<i class="fa fa-check"></i>');
		} else {
			$('#button_enable').html('<i class="pr-2 fa fa-ban mr-1"></i>' + 'Deshabilitar');
			$('#button_enable_sm').html('<i class="fa fa-ban"></i>');
		}

		$('#' + id).addClass('table-active');
	};
	
	this.columnOrder = function (columnName) {
		$('#columnOrder').val(columnName);
		if ($('#'+columnName).val() == 'asc') {
			$('#'+columnName).val('desc');
		} else {
			$('#'+columnName).val('asc');
		}
		this.executeAction();
	};

	this.removeColumnOrder = function (columnName) {
		$('#columnOrder').val('');
		$('#'+columnName).val('');
		this.executeAction();
	};

	this.postForm = function (action, method) {
		//alert('uno ' + $('#method').val());
		$('#_method').val(method);
		//alert('dos ' + $('#method').val());
		$('#actionForm').attr('action', action);
		$("#actionForm").submit();
	};

	this.getEntityId = function (entity) {
		//alert(entity);
		var variable_name = 'crud_' + entity + '_id';
		//alert(_values_id[variable_name]);
		return _values_id[variable_name];
	};

	this.create = function (action) {
		//alert(action);
		this.postForm(action, 'GET');
	};

	this.edit = function (entity, action) {
		//alert(entity);
		var id = this.getEntityId(entity);
		if (id == '' || id == null) {
			return 'empty!';
		} else {
			action = action.replace("|id|", id);
			this.postForm(action, 'GET');
		};
	};

	this.view = function (entity, action) {
		//alert(entity);
		var id = this.getEntityId(entity);
		if (id == '' || id == null) {
			return 'empty!';
		} else {
			action = action.replace("|id|", id);
			this.postForm(action, 'GET');
		};
	};

	/*
	*Esta funcion asume que el formulario ya ha sido seteado.
	*/
	this.executeAction = function() {
		$("#actionForm").submit();
	};

	/*
	*Esta funcion asume que el formulario ya ha sido seteado.
	*/
	this.submitForm = function(formName) {
		$("#" + formName).submit();
	};

  this.validateAndSubmitForm = function(formName) {
    if ($('#'+formName)[0].checkValidity() === false) {
        $('#'+formName).addClass('was-validated');
        return false;
    } else {
      $("#" + formName).submit();
      return true;
    }
  };


	$(document).on('show.bs.modal','#confirmation-modal', function (e) {
		entity = $(e.relatedTarget).data('entity');
		var id = crudInstance.getEntityId(entity);
		title = $(e.relatedTarget).data('title');
		$('#header_confirm_title').text(title);
		if (id == '' || id == null) {
			//alert('empty');
			$('#button_confirm_modal').hide();
			selectRowText = $(e.relatedTarget).data('selectrowtext');
			$('#body_div_confirm_modal').text(selectRowText);
			return 'empty!';
		} else {
			dataBody = $(e.relatedTarget).data('body');
			$('#body_div_confirm_modal').text(dataBody);
			var action = $(e.relatedTarget).data('action');
			action = action.replace("|id|", id);
			method = $(e.relatedTarget).data('method');
			$('#_method').val(method);
			$('#id').val(id);
			$('#actionForm').attr('action', action);
			$('#button_confirm_modal').show();
			//alert('Set done: ' + $('#_method').val());
		};
    });

	this.postFormPagination = function (page) {
		//alert(page);
		$('#page').val(page);
		//alert('page ' + $('#page').val())
		$("#actionForm").submit();
	};

	this.postFormBack = function (form, action, method) {
		$('#_method').val(method);
		$('#'+form).attr('action', action);
		$('#'+form).submit();
	};

  this.ajaxSubmit = function (formName, url, method, options, callbackSuccess) {
    // alert('formName: ' + formName);
    // alert('url: ' + url);
    // alert('method: ' + method);
    $.ajaxSetup({header:$('meta[name="_token"]').attr('content')});

    $.ajax({
       type:method,
       url:url,
       data:$('#'+formName).serialize(),
       dataType: 'json',
       success: function(data){
           callbackSuccess(data, options);
       },
       error: function(data){
		   console.log('**********HUBO ERROR');
			console.log(data);
			console.log('**********HUBO ERROR');
			//alert('error: ' + data);
       }
     })
   }
   
   this.ajaxFileSubmit = function (formName, url, method, options, callbackSuccess) {
    // alert('formName: ' + formName);
    // alert('url: ' + url);
    // alert('method: ' + method);
    $.ajaxSetup({header:$('meta[name="_token"]').attr('content')});

    $.ajax({
       type:method,
       url:url,
       data:$('#'+formName).serialize(),
       processData: false,
	   contentType: "multipart/form-data",
	   xhrFields: {
            responseType: 'blob'
       },
       success: function(data){
           callbackSuccess(data, options);
       },
       error: function(data){
		   console.log('**********HUBO ERROR');
			console.log(data);
			console.log('**********HUBO ERROR');
         //alert('error: ' + data);
       }
     })
   }
};

module.exports = crud;
