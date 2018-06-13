function potencial() {

	this.setCurrentRowId = function (id) {
		crudInstance.setCurrentRowId(id);
		if ($('#' + id).hasClass('table-active')) {
			$('#button_excel').removeClass('disabled');
      $('#button_excel_sm').removeClass('disabled');
		} else {
			$('#button_excel').addClass('disabled');
      $('#button_excel_sm').addClass('disabled');
		};
	};

	this.generateExcel = function (action, entity) {
		var id = crudInstance.getEntityId(entity);
		if (id == '' || id == null) {
			return 'empty!';
		} else {
			//alert(action);
			action = action.replace("|id|", id);
			//alert(action);
			crudInstance.postForm(action, 'GET');
		};
	};

	this.columnOrder = function (columnName) {
		$('#columnOrder').val(columnName);
		if ($('#'+columnName).val() == 'asc') {
			$('#'+columnName).val('desc');
		} else {
			$('#'+columnName).val('asc');
		}
		crudInstance.executeAction();
	}

	this.removeColumnOrder = function (columnName) {
		$('#columnOrder').val('');
		$('#'+columnName).val('');
		crudInstance.executeAction();
	}

};

module.exports = potencial;
