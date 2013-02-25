//pre-submit callback 
function showRequest(formData, jqForm, options) { 
	var queryString = $.param(formData); 
	var id = '#upload_message_'+formData[0].value;
	
	$(id).show();
	
	return true;
}

function showResponse(responseText, statusText, xhr, $form)  { 
	for(x in responseText['response']['replace']){
		jQueryId = '#'+responseText['response']['replace'][x]['id'];
		$(jQueryId).html(responseText['response']['replace'][x]['innerHTML']);
	}
}

function showSlow(divId){
	$(divId).show(3000);
}

function selectMainDiv(divId){
	$('.tab_content').hide(3000);
	$(divId).show(3000);
	
}