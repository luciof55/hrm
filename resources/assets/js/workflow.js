function workflow() {

	this.processAction = function (formName, urlAction, urlRemove, method, tableId, clearBody, addRemoveButton) {
		options = {tableId: tableId, clearBody: clearBody, urlAction: urlAction, urlRemove: urlRemove};
		crudInstance.ajaxSubmit(formName, urlAction, method, options, function (data, options) {
				if (data.status == 'ok') {
					tableId = '#' + options.tableId;
					if (options.clearBody) {
						$(tableId + ' > tbody').html('');
					}
					//console.log(data.list);
					var arrayList = JSON.parse(data.list);
					console.log(arrayList.length);
					for (var i = 0; i < arrayList.length; i++) {
						var obj = arrayList[i];
						rowcontent = '<tr id="transition_' + obj[data.key] + '">';
						console.log(obj);
						for (var key in obj) {
							if (key != data.key) {
								 var value = obj[key];
								 rowcontent = rowcontent + '<td>' + value + '</td>';
							 }
						}
						if (addRemoveButton) {
							rowcontent = rowcontent + '<td></td>';
						}
						
						//load button column
						rowcontent = rowcontent + '<td></td>';
						
						rowcontent = rowcontent + '</tr>';
						($(tableId + ' > tr').length > 0) ? $(tableId).children('tbody:last').children('tr:last').append(rowcontent): $(tableId).children('tbody:last').append(rowcontent);
						if (addRemoveButton) {
							if (options.urlRemove == '') {
								urlRemove = data.urlRemove;
							} else {
								urlRemove = options.urlRemove;
							}
							workflowInstance.addRemoveButton('transition_' + obj[data.key], obj[data.key], urlRemove, options.urlRemove);
						}
						
						//alert(data.urlLoad);
						
						workflowInstance.addLoadButton('transition_' + obj[data.key], obj[data.key], data.urlLoad);
					}
					workflowInstance.clearFields();
					$( "#spanMessage").css("opacity", 0);
					$( "#spanMessage").css("display", 'none');
					workflowInstance.updatePaginationLinks(data.paginationLinks, data.table_page);
				} else {
					$( "#spanMessage > span" ).text( data.message );
					$( "#spanMessage" ).stop().css( "opacity", 1 ).fadeIn( 30 );
					//alert("Error desde App: " + data.message);
				}
		});
	}

	this.updatePaginationLinks = function (paginationLinks, currentPage) {
		$('#tablePage').val(currentPage);
		var arrayList = JSON.parse(paginationLinks);
		//console.log(arrayList['html_content']);
		$('#divTransitionPagination').empty().append(arrayList['html_content']);
	}

	this.addRemoveButton = function (rowId, name, urlAction, urlRemove) {
		var td = $("#" + rowId).children('td:last').prev();
		td.append('<button type="button" class="fa fa-remove delete-button"></button>');
		td.children('button').on("click", function() {
				//alert('name: ' + name);
				workflowInstance.removeElement('commandChildForm', urlAction, urlRemove, 'POST', name, 'transitions-table', true);
			});
	}
	
	this.addLoadButton = function (rowId, name, urlLoad) {
		var td = $("#" + rowId).children('td:last');
		td.append('<button type="button" class="fa fa-search button"></button>');
		td.children('button:last').on("click", function() {
			//alert('name: ' + name);
			workflowInstance.loadElement('commandChildForm', urlLoad, 'POST', name, true);
		});
	}

	this.paginateTransitions = function(page) {
		urlAction = $('#commandChildForm').attr('action');
		$('#tablePage').val(page);
		workflowInstance.loadTranstions('commandChildForm', urlAction, '', 'POST', 'transitions-table', true, true);
	}

	this.paginateTransitionsShow = function(page) {
		$('#tablePage').val(page);
		crudInstance.submitForm('commandChildForm');
	}

	this.loadTranstions = function (formName, urlAction, urlRemove, method, tableId, clearBody, addRemoveButton) {
		this.processAction(formName, urlAction, urlRemove, method, tableId, clearBody, addRemoveButton);
	}

	this.removeElement = function (formName, urlAction, urlRemove, method, transitionName, tableId, clearBody) {
		$('#transitionName').val(transitionName);
		this.processAction(formName, urlAction, urlRemove, method, tableId, clearBody, true);
		$('#transitionName').val('');
	}

	this.addElement = function (formName, urlAction, urlRemove, method, tableId, clearBody) {
		if ($('#'+formName)[0].checkValidity() === false) {
		} else {
			event.preventDefault();
			event.stopPropagation();
			this.processAction(formName, urlAction, urlRemove, method, tableId, clearBody, true);
		}
	}
	
	this.loadElement = function (formName, urlAction, method, transitionName, showId) {
		$('#transitionName').val(transitionName);
		
		options = {urlAction: urlAction};
		crudInstance.ajaxSubmit(formName, urlAction, method, options, function (data, options) {
			if (data.status == 'ok') {
				//console.log(data.transition);
				$('#transition-anio').val(data.transition.anio);
				$('#transition-anio').attr('readonly', 'readonly');
				
				if (showId) {
					$('#transition-account_id').val(data.transition.account_id);
					$('#transition-category_id').val(data.transition.category_id);
				} else {
					$('#transition-account_id').val(data.transition.account.name);
					$('#transition-category_id').val(data.transition.category.name);
				}
				
				$('#transition-account_id').attr('readonly', 'readonly');
				
				$('#transition-zonas').val(data.transition.zonas);
				$('#transition-comentarios').val(data.transition.comentarios);
				$('#addButton').text('Modificar');
				$('#addButton').attr('role', 'update');
				$('#transition-comentarios').focus();
			} else {
				$( "#spanMessage > span" ).text( data.message );
				$( "#spanMessage" ).stop().css( "opacity", 1 ).fadeIn( 30 );
			}
		});
		$('#transitionName').val('');
	}
	
	this.clearFields = function() {
		$('#transition-anio').val('');
		$('#transition-anio').removeAttr('readonly');
		$('#transition-account_id').val('');
		$('#transition-account_id').removeAttr('readonly');
		$('#transition-category_id').val('');
		$('#transition-zonas').val('');
		$('#transition-comentarios').val('');
		$('#addButton').text('Agregar');
		$('#addButton').attr('add');
		$('#transition-anio').focus();
		
	}

	this.setActiveTab = function(tab) {
		$('#activeTab').val(tab);
		$('#commandForm .form-control').each(function (index) {
				var textbox = document.getElementById($(this).attr('id'));
				textbox.focus();
				textbox.scrollIntoView();
				return false;
		});
	}

	this.validateAndSubmitForm = function (formName) {
		if (!crudInstance.validateAndSubmitForm(formName)) {
			//workflowInstance.setActiveTab('main');
			$('#main-tab').click();
		}
	}
	
	this.removeFile = function (formName, method, urlAction) {
		options = {urlAction: urlAction};
		crudInstance.ajaxSubmit(formName, urlAction, method, options, function (data, options) {
			if (data.status == 'ok') {
				//alert('Eliminado');
				$( "#button_download_file").remove();
				$( "#button_remove_file").remove();
				$( "#nofiles" ).stop().css( "opacity", 1 ).fadeIn( 30 );
			} else {
				$( "#mainSpanMessage > span" ).text( data.message );
				$( "#mainSpanMessage" ).stop().css( "opacity", 1 ).fadeIn( 30 );
			}
		});
	}
	
	this.downloadFile = function (formName, method, urlAction, fileName) {
		options = {urlAction: urlAction, fileName: fileName};
		
		crudInstance.ajaxFileSubmit(formName, urlAction, method, options, function (data, options) {
			//alert('Ejecutado');
			console.log(data);
			if (navigator.msSaveOrOpenBlob) {
				navigator.msSaveOrOpenBlob(data, options.fileName);
			} else {
				var a = document.createElement('a');
				var url = window.URL.createObjectURL(data);
				a.href = url;
				console.log(options);
				a.download = options.fileName;
				document.body.appendChild(a);
				a.click();
				window.URL.revokeObjectURL(url);
				a.remove();
			}
		});
	}
};
module.exports = workflow;