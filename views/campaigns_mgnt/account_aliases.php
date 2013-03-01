<?php
	$transparent_img_url = $this->build_img_url("transparent.png");
	
	$account_name = $account->name;
	$idAccount = $account->id;

	
	$account_alias_delete_action_url = $this->build_action_url('campaigns_mgnt', 'delete_account_alias');
	$account_alias_edit_action_url = $this->build_action_url('campaigns_mgnt', 'edit_account_alias');
	$account_add_alias_action_url = $this->build_action_url('campaigns_mgnt', 'add_alias_to_account', "idAccount/{$idAccount}");
?>

<script type="text/javascript">
	
	
	function before_submit(formData, jqForm, options){ 
		i=1; i++;
	}
	function handle_submit_response(responseText, statusText, xhr){ 
		i=1; i++; 
	}


	
	function account_alias_delete(){
		mysubmit("account_list_form", "<?php echo $account_alias_delete_action_url;?>")
	}
	
	function account_alias_edit(){
		mysubmit("account_list_form", "<?php echo $account_alias_edit_action_url;?>")
		
	}
	
	function account_add_alias(){
		mysubmit("account_list_form", "<?php echo $account_add_alias_action_url;?>")
	}


	
</script>

    <div class="actionButtons">
        <ul>
            <li><a href="javascript:void(0);" title="Add Alias to Account" onclick="javascript:account_add_alias();"><img src="<?php echo $transparent_img_url; ?>" width="1" height="1" alt="" class="icoActionsNew"></a></li>
		<li><a href="javascript:void(0);" title="Delete Alias from Account" onclick="javascript:account_alias_delete();"><img src="<?php echo $transparent_img_url; ?>" width="1" height="1" alt="" class="icoActionsTrash"></a></li>
		<li><a href="javascript:void(0);" title="Edit Alias from Account" onclick="javascript:account_alias_edit();"><img src="<?php echo $transparent_img_url; ?>" width="1" height="1" alt="" class="icoActionsPencil"></a></li>
        </ul>        
    </div>
	
    <!--List Table Example-->
	<form id="account_list_form" method="post" action="" class="form">

    <div class="listTable">
    	<ul class="header">
        	<li class="w4">&nbsp;</li>
        	<li class="w24">Alias</li>
        </ul>
	    
<?php

foreach ($account_aliases as $account_alias){
	$alias = $account_alias->alias;
	
	$alias_alias = $alias->alias;
?>
	<ul class="row">
        	<label>
                <li class="w4"><input name="selected[]" type="checkbox" value="<?php echo $user->id ;?>" class="formCheckbox"></li>
             </label>   
		    <li class="w24"><?php echo $alias_alias; ?></li>
                <li class="w24"><?php echo $account_name; ?></li>
                <li class="w24"><img src="<?php echo $transparent_img_url; ?>" width="1" height="1" alt="" class="<?php echo $class_to_status;?>"></li>
        </ul> 
<?php	    
}
?>
	                  
    </div>
		
	</form>
    
 <?php
 ?>
    
    <!--End of List Table Example-->
    
    