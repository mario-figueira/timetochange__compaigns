<?php
	$transparent_img_url = $this->build_img_url("transparent.png");
	
	$prompt_delete_action_url = $this->build_action_url('explorer', 'delete_prompt');
	$prompt_edit_action_url = $this->build_action_url('explorer', 'edit_prompt');
?>

<script type="text/javascript">
	
	
	function before_submit(formData, jqForm, options){ 
		i=1; i++;
	}
	function handle_submit_response(responseText, statusText, xhr){ 
		i=1; i++; 
	}


	
	function prompt_delete(){
		mysubmit("prompt_list_form", "<?php echo $prompt_delete_action_url;?>")
	}
	
	function prompt_edit(){
		mysubmit("prompt_list_form", "<?php echo $prompt_edit_action_url;?>")
		
	}
	
	
</script>

    <div class="actionButtons">
        <ul>
            <li><a href="<?php echo $this->build_action_url('explorer', 'add_prompt'); ?>" title="Add Prompt"><img src="<?php echo $transparent_img_url; ?>" width="1" height="1" alt="" class="icoActionsNew"></a></li>
		<li><a href="javascript:void(0);" title="Delete Prompt" onclick="javascript:prompt_delete();"><img src="<?php echo $transparent_img_url; ?>" width="1" height="1" alt="" class="icoActionsTrash"></a></li>
		<li><a href="javascript:void(0);" title="Edit Prompt" onclick="javascript:prompt_edit();"><img src="<?php echo $transparent_img_url; ?>" width="1" height="1" alt="" class="icoActionsPencil"></a></li>
        </ul>        
    </div>
	
    <!--List Table Example-->
	<form id="prompt_list_form" method="post" action="" class="form">

    <div class="listTable">
    	<ul class="header">
        	<li class="w4">&nbsp;</li>
        	<li class="w24">Name</li>
		<li class="w24">Description</li>
		<li class="w24">Account</li>
		<li class="w24">Preview</li>
        </ul>
	    
<?php

foreach ($prompts as $prompt){
	
	$select_checkbox_field_name = "selected__" .$prompt->id;
	
	$description= $this->empty2nbsp($prompt->description);
	
	$description = truncate_with_elipsis($description,30,true);
?>
	<ul class="row">
        	<label>
                <li class="w4"><input name="selected[]" type="checkbox" value="<?php echo $prompt->id ;?>" class="formCheckbox"></li>
             </label>   
		    <li class="w24"><?php echo $prompt->name; ?></li>
		    <li class="w24"><?php echo $description; ?></li>
		    <li class="w24"><?php echo "Account"; ?></li>
		    <li class="w24"><?php echo "preview"; ?></li>
        </ul> 
<?php	    
}
?>
	                  
    </div>
		
	</form>
    
    
    <!--End of List Table Example-->
    

<?php
function truncate_with_elipsis($string, $length, $stopanywhere=false) {
    //truncates a string to a certain char length, stopping on a word if not specified otherwise.
    if (strlen($string) > $length) {
        //limit hit!
        $string = substr($string,0,($length -3));
        if ($stopanywhere) {
            //stop anywhere
            $string .= '...';
        } else{
            //stop on a word.
            $string = substr($string,0,strrpos($string,' ')).'...';
        }
    }
    return $string;
}
?>
