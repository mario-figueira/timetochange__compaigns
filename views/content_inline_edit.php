<!-- <?php if(SHOW_FILE_PATHS_IN_HTML===TRUE){ echo __FILE__;} ?> -->
<script language="javascript" type="text/javascript">
	function content_edit(a_content_id){
		//alert("content_id=" + a_content_id);
		content_edit_editor_popup(a_content_id);
	}
	
	function content_edit_editor_popup(a_content_id){
			//alert(a_content_id);
			var content_edit_url_template = "<?php echo $this->build_action_url("contentEditor", "edit", "content_id/\{\$content_id\}"); ?>";
			var content_edit_url = content_edit_url_template.replace("{$content_id}", a_content_id);
			//alert(content_edit_url);
		      var content_edit_iframe = '<iframe id="frameTiny" src="' + content_edit_url + '" width="700px" height="500px" scrolling="no" frameborder="no" marginwidth="0" marginheight="0"></iframe>';

                    TINY.box.show({
                        //iframe:popupUrl,
                        html:content_edit_iframe,
                        post:'',
                        width:700,
                        height:500,
                        openjs: function (){
					content_edit_editor_load_popup_events();
				}
                    });
	}
	
	function content_edit_editor_load_popup_events(){
		
	}
	
	function content_edit_menu_show(a_content_id){
		//alert(a_content_id);
		var content_edit_url_template = "<?php echo $this->build_action_url("contentEditor", "menu_show", "content_id/\{\$content_id\}"); ?>";
		var content_edit_url = content_edit_url_template.replace("{$content_id}", a_content_id);
		//alert(content_edit_url);
		var content_edit_iframe = '<iframe id="frameTiny" src="' + content_edit_url + '" width="700px" height="500px" scrolling="no" frameborder="no" marginwidth="0" marginheight="0"></iframe>';

		  TINY.box.show({
			//iframe:popupUrl,
			html:content_edit_iframe,
			post:'',
			width:700,
			height:500,
			openjs: function (){
				content_edit_editor_load_popup_events();
			}
		  });		
		
	}
</script>

<?php 
	function content_edit_render_editor_call_build($a_page_content, $a_content_name){
		$inline_editing = (INLINE_CONTENT_EDITING===true);
		$abort = !$inline_editing;
		
		$abort = $abort || !isset($a_page_content); 
		$abort = $abort || !isset($a_content_name);
		
		if($abort) {return null;}
		
		
		$content_id = $a_page_content->get_content_id($a_content_name);
		//$content_descriptor = $a_page_content->array_of_contents['zContentDescriptors'][$a_content_name];
		
		$str_to_echo = "oncontextmenu=\"javascript:content_edit_menu_show('{$content_id}');return false;\"";
		$ret_val = $str_to_echo;
		
		return $ret_val;
	}

	function content_edit_render_editor_call($a_page_content, $a_content_name){
		$str_to_echo = content_edit_render_editor_call_build($a_page_content, $a_content_name);
		echo $str_to_echo;
	} 
?>