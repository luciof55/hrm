function workflow() {

	this.processAction = function (formName, urlAction, urlRemove, method, tableId, clearBody, addRemoveButton) {
		options = {tableId: tableId, clearBody: clearBody, urlAction: urlAction, urlRemove: urlRemove};
		crudInstance.ajaxSubmit(formName, urlAction, method, options, function (data, options) {
				if (data.status == 'ok') {
					tableId = '#' + options.tableId;
					if (options.clearBody) {
							$(tableId + ' > tbody').html('');
							//$(tableId).append('<tbody />');
					}
					console.log(data.list);
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
						rowcontent = rowcontent + '</tr>';
						($(tableId + ' > tr').length > 0) ? $(tableId).children('tbody:last').children('tr:last').append(rowcontent): $(tableId).children('tbody:last').append(rowcontent);
						if (addRemoveButton) {
							if (options.urlRemove == '') {
								urlRemove = data.urlRemove;
							} else {
								urlRemove = options.urlRemove;
							}
							workflowInstance.addRemoveButton('transition_' + obj[data.key], obj['name'], urlRemove, options.urlRemove);
						}
						$( "#spanMessage").css("opacity", 0);
						$( "#spanMessage").css("display", 'none');
					}
					workflowInstance.updatePaginationLinks(data.paginationLinks, data.table_page);
				} else {
				  $( "#spanMessage > span" ).text( data.message );
				  $( "#spanMessage" ).stop().css( "opacity", 1 ).fadeIn( 30 );
					//alert("Error desde App: " + data.message)
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
		var td = $("#" + rowId).children('td:last');
		td.append('<button type="button" class="fa fa-remove delete-button"></button>');
		td.children('button').on("click", function() {
				//alert('name: ' + name);
				workflowInstance.removeElement('commandChildForm', urlAction, urlRemove, 'POST', name, 'transitions-table', true);
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
		event.preventDefault();
		event.stopPropagation();
		$('#deleteTransitionName').val(transitionName);
		this.processAction(formName, urlAction, urlRemove, method, tableId, clearBody, true);
		$('#deleteTransitionName').val('');
	}

	this.addElement = function (formName, urlAction, urlRemove, method, tableId, clearBody) {
			if ($('#'+formName)[0].checkValidity() === false) {
			} else {
				event.preventDefault();
				event.stopPropagation();
				this.processAction(formName, urlAction, urlRemove, method, tableId, clearBody, true);
			}
	}

	this.setActiveTab = function(tab) {
		$('#activeTab').val(tab);
		$('#commandForm  .form-control').each(function (index) {
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

};

module.exports = workflow;
