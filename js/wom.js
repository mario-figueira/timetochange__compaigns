//var messageDelay = 2000; // How long to display status messages (in
// milliseconds)

// Init the form once the document is ready
//$(init);

// Initialize the form
$(document).ready(function() {
	$("#popupContactClose").bind('click',function() {
		disablePopup();
	});
	// Click out event!
	$("#backgroundPopup").bind('click',function() {
		disablePopup();
	});
	
});
//);
//
//// Submit the form via Ajax
//
//function submitForm() {
//	var contactForm = $(this);
//	TINY.box.show({post:contactForm.serialize(),width:480,height:250,opacity:20,topsplit:3});	
//	return false;
//}


var popupStatus = 0;

function loadPopup() {
	// loads popup only if it is disabled
	if (popupStatus == 0) {
		$("#backgroundPopup").css({
			"opacity" : "0.7"
		});
		$("#backgroundPopup").fadeIn("slow");
		$("#messageDiv").fadeIn("slow");
		popupStatus = 1;
	}
}

function centerPopup() {
	// request data for centering
	var windowWidth = document.documentElement.clientWidth;
	var windowHeight = document.documentElement.clientHeight;
	var popupHeight = $("#messageDiv").height();
	var popupWidth = $("#messageDiv").width();
	// centering
	$("#messageDiv").css({
		"position" : "absolute",
		"top" : windowHeight / 2 - popupHeight / 2,
		"left" : windowWidth / 2 - popupWidth / 2
	});
	// only need force for IE6

	$("#backgroundPopup").css({
		"height" : windowHeight
	});

}

// disabling popup with jQuery magic!
function disablePopup() {
	// disables popup only if it is enabled
	if (popupStatus == 1) {
		$("#backgroundPopup").fadeOut("slow");
		$("#messageDiv").fadeOut("slow");
		popupStatus = 0;
	}
}

// pre-submit callback
function showRequest(formData, jqForm, options) {
	// centering with css
	centerPopup();
	// load popup
	loadPopup();
}

// CLOSING POPUP
// Click the x event!
// Press Escape event!
// $(document).keypress(function(e){
// if(e.keyCode==27 amp;amp;amp;amp;amp;amp;&amp;amp;amp;amp;amp;amp;
// popupStatus==1){
// disablePopup();
// }
// });

function showResponse(responseText, statusText, xhr, $form) {
	for (x in responseText['replace']) {
		jQueryId = '#' + responseText['replace'][x]['id'];
		$(jQueryId).html(responseText['replace'][x]['innerHTML']);
	}
}


function showSlow(divId) {
	$(divId).show(3000);
}

function selectMainDiv(divId) {
	$('.tab_content').hide(3000);
	$(divId).show(3000);

}