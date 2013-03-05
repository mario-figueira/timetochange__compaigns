<?php
	$transparent_img_url = $this->build_img_url("transparent.png");
	
	$campaign_delete_action_url = $this->build_action_url('campaigns_mgnt', 'delete_campaign');
	$campaign_edit_action_url = $this->build_action_url('campaigns_mgnt', 'edit_campaign');
	$campaign_users_action_url = $this->build_action_url('campaigns_mgnt', 'campaign_users');
	$campaign_aliases_action_url = $this->build_action_url('campaigns_mgnt', 'campaign_aliases');
?>

<script type="text/javascript">
	
	
	function before_submit(formData, jqForm, options){ 
		i=1; i++;
	}
	function handle_submit_response(responseText, statusText, xhr){ 
		i=1; i++; 
	}


	
	function campaign_delete(){
		mysubmit("campaign_list_form", "<?php echo $campaign_delete_action_url;?>")
	}
	
	function campaign_edit(){
		mysubmit("campaign_list_form", "<?php echo $campaign_edit_action_url;?>")
		
	}
	
	function campaign_users(){
		mysubmit("campaign_list_form", "<?php echo $campaign_users_action_url;?>")
	}
	
	function campaign_aliases(){
		mysubmit("campaign_list_form", "<?php echo $campaign_aliases_action_url;?>")
	}
	
</script>

    <div class="actionButtons">
        <ul>
            <li><a href="<?php echo $this->build_action_url('campaigns_mgnt', 'add_campaign'); ?>" title="Add Campaign"><img src="<?php echo $transparent_img_url; ?>" width="1" height="1" alt="" class="icoActionsNew"></a></li>
		<li><a href="javascript:void(0);" title="Delete Campaign" onclick="javascript:campaign_delete();"><img src="<?php echo $transparent_img_url; ?>" width="1" height="1" alt="" class="icoActionsTrash"></a></li>
		<li><a href="javascript:void(0);" title="Edit Campaign" onclick="javascript:campaign_edit();"><img src="<?php echo $transparent_img_url; ?>" width="1" height="1" alt="" class="icoActionsPencil"></a></li>
		<li><a href="javascript:void(0);" title="Users Campaign" onclick="javascript:campaign_users();"><img src="<?php echo $transparent_img_url; ?>" width="1" height="1" alt="" class="icoActionsUser"></a></li>
		<li><a href="javascript:void(0);" title="Aliases Campaign" onclick="javascript:campaign_aliases();"><img src="<?php echo $transparent_img_url; ?>" width="1" height="1" alt="" class="icoActionsAlias"></a></li>
        </ul>        
    </div>

<!--List Table Example-->
	<form id="campaign_list_form" method="post" action="" class="form">

    <div class="listTable">
    	<ul class="header">
        	<li class="w5">&nbsp;</li>
        	<li class="w19">Campaign Name</li>
            <li class="w19">Account</li>
            <li class="w19">Start Date</li>
		<li class="w19">End Date</li>
            <li class="w19">Status</li>
        </ul>
	    
<?php

foreach ($campaigns as $campaign){
	$class_to_status = campaign_status_2_class_name($campaign->status);
	
	$select_checkbox_field_name = "selected__" .$campaign->id;
	
	$campaignName= $this->empty2nbsp($campaign->name);
	
	$startDate= $this->empty2nbsp($campaign->startDate);
	
	$endDate= $this->empty2nbsp($campaign->endDate);
?>
	<ul class="row">
        	<label>
                <li class="w5"><input name="selected[]" type="checkbox" value="<?php echo $campaign->id ;?>" class="formCheckbox"></li>
             </label>   
		    <li class="w19"><?php echo $campaignName; ?></li>
                <li class="w19"><?php echo "account"; ?></li>
                <li class="w19"><?php echo $startDate; ?></li>
		    <li class="w19"><?php echo $endDate; ?></li>
                <li class="w19"><img src="<?php echo $transparent_img_url; ?>" width="1" height="1" alt="" class="<?php echo $class_to_status;?>"></li>
        </ul> 
<?php	    
}
?>
	                  
    </div>
		
	</form>
    
 <?php
	function campaign_status_2_class_name($a_campaign_status) {
		DBCHelper2::require_that()->the_param($a_campaign_status)->is_an_integer_string();

		require_once REALPATH ."enums/campaign_status_enum.php";

		$ret_val = "";

		$status_class = "";
		switch ($a_campaign_status) {
			case campaign_status_enum::$C_INACTIVO:
				$status_class = "icoListBulletred";
				break;
			case campaign_status_enum::$C_ACTIVO:
				$status_class = "icoListBulletgreen";
				break;
			case campaign_status_enum::$C_CONFIGURADA:
				$status_class = "icoListBulletblue";
				break;
			case campaign_status_enum::$C_PARADA:
				$status_class = "icoListBulletyellow";
				break;
			default:
				throw new Exception("Unsuported case:[{$a_campaign_status}].");		
		}

		$ret_val = $status_class;

		DBCHelper2::ensure_that()->the_return_value($ret_val)->is_a_string();
		return $ret_val;
	}
 ?>
    
    <!--End of List Table Example-->
    
  