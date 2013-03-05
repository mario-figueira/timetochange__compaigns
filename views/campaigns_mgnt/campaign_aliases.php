<?php
	$transparent_img_url = $this->build_img_url("transparent.png");
	
	$campaign_name = $campaign->name;
	$idCampaign = $campaign->id;

	
	$campaign_alias_delete_action_url = $this->build_action_url('campaigns_mgnt', 'delete_campaign_alias');
	$campaign_alias_edit_action_url = $this->build_action_url('campaigns_mgnt', 'edit_campaign_alias');
	$campaign_add_alias_action_url = $this->build_action_url('campaigns_mgnt', 'add_alias_to_campaign', "idCampaign/{$idCampaign}");
?>

<script type="text/javascript">
	
	
	function before_submit(formData, jqForm, options){ 
		i=1; i++;
	}
	function handle_submit_response(responseText, statusText, xhr){ 
		i=1; i++; 
	}


	
	function campaign_alias_delete(){
		mysubmit("campaign_list_form", "<?php echo $campaign_alias_delete_action_url;?>")
	}
	
	function campaign_alias_edit(){
		mysubmit("campaign_list_form", "<?php echo $campaign_alias_edit_action_url;?>")
		
	}
	
	function campaign_add_alias(){
		mysubmit("campaign_list_form", "<?php echo $campaign_add_alias_action_url;?>")
	}


	
</script>

    <div class="actionButtons">
        <ul>
            <li><a href="javascript:void(0);" title="Add Alias to Campaign" onclick="javascript:campaign_add_alias();"><img src="<?php echo $transparent_img_url; ?>" width="1" height="1" alt="" class="icoActionsNew"></a></li>
		<li><a href="javascript:void(0);" title="Delete Alias from Campaign" onclick="javascript:campaign_alias_delete();"><img src="<?php echo $transparent_img_url; ?>" width="1" height="1" alt="" class="icoActionsTrash"></a></li>
		<li><a href="javascript:void(0);" title="Edit Alias from Campaign" onclick="javascript:campaign_alias_edit();"><img src="<?php echo $transparent_img_url; ?>" width="1" height="1" alt="" class="icoActionsPencil"></a></li>
        </ul>        
    </div>
	
    <!--List Table Example-->
	<form id="campaign_list_form" method="post" action="" class="form">

    <div class="listTable">
    	<ul class="header">
        	<li class="w4">&nbsp;</li>
        	<li class="w24">Alias</li>
        	<li class="w24">Campaign</li>
        	<li class="w24">Prompt in</li>
        	<li class="w24">Prompt out</li>
        </ul>
	    
<?php

foreach ($campaign_aliases as $campaign_alias){
	$alias = $campaign_alias->alias;
	$campaign = $campaign_alias->campaign;
	$campaign_name = $campaign->name;
//	$prompt_in = $campaign_alias->prompt_in;
//	$prompt_out = $campaign_alias->prompt_out;
	
?>
	<ul class="row">
        	<label>
                <li class="w4"><input name="selected[]" type="checkbox" value="<?php echo $user->id ;?>" class="formCheckbox"></li>
             </label>   
		    <li class="w24"><?php echo $alias; ?></li>
                <li class="w24"><?php echo $campaign_name; ?></li>
                <li class="w24"><?php echo $prompt_in; ?></li>
                <li class="w24"><?php echo $prompt_out; ?></li>
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
    
    