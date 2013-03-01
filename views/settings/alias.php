<?php
	$transparent_img_url = $this->build_img_url("transparent.png");
	
	$alias_delete_action_url = $this->build_action_url('settings', 'delete_alias');
	$alias_edit_action_url = $this->build_action_url('settings', 'edit_alias');
?>

<script type="text/javascript">
	
	
	function before_submit(formData, jqForm, options){ 
		i=1; i++;
	}
	function handle_submit_response(responseText, statusText, xhr){ 
		i=1; i++; 
	}


	
	function alias_delete(){
		mysubmit("alias_list_form", "<?php echo $alias_delete_action_url;?>")
	}
	
	function alias_edit(){
		mysubmit("alias_list_form", "<?php echo $alias_edit_action_url;?>")
		
	}
	
	
</script>

    <div class="actionButtons">
        <ul>
            <li><a href="<?php echo $this->build_action_url('settings', 'add_alias'); ?>" title="Add Alias"><img src="<?php echo $transparent_img_url; ?>" width="1" height="1" alt="" class="icoActionsNew"></a></li>
		<li><a href="javascript:void(0);" title="Delete Alias" onclick="javascript:alias_delete();"><img src="<?php echo $transparent_img_url; ?>" width="1" height="1" alt="" class="icoActionsTrash"></a></li>
		<li><a href="javascript:void(0);" title="Edit Alias" onclick="javascript:alias_edit();"><img src="<?php echo $transparent_img_url; ?>" width="1" height="1" alt="" class="icoActionsPencil"></a></li>
        </ul>        
    </div>
	
    <!--List Table Example-->
	<form id="alias_list_form" method="post" action="" class="form">

    <div class="listTable">
    	<ul class="header">
        	<li class="w4">&nbsp;</li>
        	<li class="w24">Number</li>
        </ul>
	    
<?php

foreach ($alias as $number){
	
	$select_checkbox_field_name = "selected__" .$number->id;
	
?>
	<ul class="row">
        	<label>
                <li class="w4"><input name="selected[]" type="checkbox" value="<?php echo $number->id ;?>" class="formCheckbox"></li>
             </label>   
		    <li class="w24"><?php echo $number->alias; ?></li>
        </ul> 
<?php	    
}
?>
	                  
    </div>
		
	</form>
    
    
    <!--End of List Table Example-->
    
    