<?php
	$transparent_img_url = $this->build_img_url("transparent.png");
?>

    <div class="actionButtons">
        <ul>
            <li><a href="<?php echo $this->build_action_url('campaigns_mgnt', 'add_account'); ?>" title="Add Account"><img src="<?php echo $transparent_img_url; ?>" width="1" height="1" alt="" class="icoActionsNew"></a></li>
		<li><a href="#" title="Delete Account"><img src="<?php echo $transparent_img_url; ?>" width="1" height="1" alt="" class="icoActionsTrash"></a></li>
		<li><a href="#" title="Edit Account"><img src="<?php echo $transparent_img_url; ?>" width="1" height="1" alt="" class="icoActionsPencil"></a></li>
		<li><a href="#" title="Users Account"><img src="<?php echo $transparent_img_url; ?>" width="1" height="1" alt="" class="icoActionsUser"></a></li>
        </ul>        
    </div>
	
    <!--List Table Example-->
    
    <div class="listTable">
    	<ul class="header">
        	<li class="w4">&nbsp;</li>
        	<li class="w24">Account Name</li>
            <li class="w24">Created By</li>
            <li class="w24">Date Created</li>
            <li class="w24">Status</li>
        </ul>
	    
<?php

foreach ($accounts as $account){
	$class_to_status = account_status_2_class_name($account->status);
	$auditUser = $account->auditUser;
	$auditUser_is_empty = !isset($auditUser) || !empty($auditUser) || trim($auditUser)==="";
	if($auditUser_is_empty){
		$auditUser = "&nbsp";
	}
	
?>
	<ul class="row">
        	<label>
                <li class="w4"><input name="id" type="checkbox" value="<?php echo $account->id ;?>" class="formCheckbox"></li>
             </label>   
		    <li class="w24"><?php echo $account->name; ?></li>
                <li class="w24"><?php echo $auditUser; ?></li>
                <li class="w24"><?php echo $account->auditTimestamp; ?></li>
                <li class="w24"><img src="<?php echo $transparent_img_url; ?>" width="1" height="1" alt="" class="<?php echo $class_to_status;?>"></li>
        </ul> 
<?php	    
}
?>
	                  
    </div>
    
 <?php
	function account_status_2_class_name($a_account_status) {
		DBCHelper2::require_that()->the_param($a_account_status)->is_an_integer_string();

		require_once REALPATH ."enums/account_status_enum.php";

		$ret_val = "";

		$status_class = "";
		switch ($a_account_status) {
			case account_status_enum::$C_INACTIVO:
				$status_class = "icoListBulletred";
				break;
			case account_status_enum::$C_ACTIVO:
				$status_class = "icoListBulletgreen";
				break;

			default:
				throw new Exception("Unsuported case:[{$a_account_status}].");		
		}

		$ret_val = $status_class;

		DBCHelper2::ensure_that()->the_return_value($ret_val)->is_a_string();
		return $ret_val;
	}
 ?>
    
    <!--End of List Table Example-->
    
    