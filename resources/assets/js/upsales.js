var potencial = require('./potencial.js');

var potencialInstance = new potencial();

window.potencialInstance = potencialInstance;

var workflow = require('./workflow.js');

var workflowInstance = new workflow();

window.workflowInstance = workflowInstance;

$(window).scroll(function() {
    if ($(this).scrollTop() > 50 ) {
        $('.scrolltop:hidden').stop(true, true).fadeIn();
    } else {
        $('.scrolltop').stop(true, true).fadeOut();
    }
});

$(function() {
	$(".scroll").click(function() {
		$("html,body").animate( {
			scrollTop:$(".thetop").offset().top
		},
		"1000");
		return false;
	})
});