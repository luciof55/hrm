function potencial() {
  
	this.setCurrentRowId = function (id) {
		crudInstance.setCurrentRowId(id);
		if ($('#' + id).hasClass('table-active')) {
			$('#button_excel').removeClass('disabled');
		} else {
			$('#button_excel').addClass('disabled');
		};
	};
	
	this.generateExcel = function (action, entity) {
		var id = crudInstance.getEntityId(entity);
		if (id == '' || id == null) {
			return 'empty!';
		} else {
			alert(action);
			action = action.replace("|id|", id);
			alert(action);
			crudInstance.postForm(action, 'GET');
		};
	};

	
};

module.exports = potencial;