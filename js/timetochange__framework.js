function mysubmitbyajax(a_form_id, a_post_url, a_success_url, a_handle_submit_response, a_before_submit){

		/*
		if($submit_process_is_running){
			//submit process already running
			return;
		}

		$submit_process_is_running = true;
		*/
		
		$("#".concat(a_form_id)).ajaxForm(
			{ 
				async:false,
				beforeSubmit : a_before_submit,
				success: a_handle_submit_response,			// post-submit callback 
				cache:false,
				type:'post',
				//contentType:'text/html;charset=utf-8',
				//dataType:"html",
				url: a_post_url     // override for form's 'action' attribute 
			} 
		);
		$("#".concat(a_form_id)).submit();
}
	
	
function mysubmitbyajax_before_submit_sample(formData, jqForm, options){ 
		i=1; i++;
}

function mysubmitbyajax_handle_submit_response_sample(responseText, statusText, xhr){ 
		i=1; i++; 
}

	
	
function mysubmit(a_form_id, a_post_url){

		$("#".concat(a_form_id)).attr('action', a_post_url);
		
		$("#".concat(a_form_id)).submit();
}