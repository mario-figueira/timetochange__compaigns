<?php
	$transparent_img_url = $this->build_img_url("transparent.png");
	
	$account_delete_action_url = $this->build_action_url('campaigns_mgnt', 'delete_account');
	$account_edit_action_url = $this->build_action_url('campaigns_mgnt', 'edit_account');
	$account_add_user_action_url = $this->build_action_url('campaigns_mgnt', 'add_user_to_account');
?>

<script type="text/javascript">
	
	
	function before_submit(formData, jqForm, options){ 
		i=1; i++;
	}
	function handle_submit_response(responseText, statusText, xhr){ 
		i=1; i++; 
	}


	
	function account_delete(){
		mysubmit("account_list_form", "<?php echo $account_delete_action_url;?>")
	}
	
	function account_edit(){
		mysubmit("account_list_form", "<?php echo $account_edit_action_url;?>")
		
	}
	
	function account_add_user(){
		mysubmit("account_list_form", "<?php echo $account_add_user_action_url;?>")
	}
	
	
</script>

    <div class="actionButtons">
        <ul>
            <li><a href="#" title="Add User to Account"><img src="<?php echo $transparent_img_url; ?>" width="1" height="1" alt="" class="icoActionsNew"></a></li>
		<li><a href="#" title="Invite User to Account"><img src="<?php echo $transparent_img_url; ?>" width="1" height="1" alt="" class="icoActionsNew"></a></li>
		<li><a href="javascript:void(0);" title="Delete User from Account" ><img src="<?php echo $transparent_img_url; ?>" width="1" height="1" alt="" class="icoActionsTrash"></a></li>
		<li><a href="javascript:void(0);" title="Edit User from Account" ><img src="<?php echo $transparent_img_url; ?>" width="1" height="1" alt="" class="icoActionsPencil"></a></li>
        </ul>        
    </div>
	
    <!--List Table Example-->
	<form id="account_list_form" method="post" action="" class="form">

    <div class="listTable">
    	<ul class="header">
        	<li class="w4">&nbsp;</li>
        	<li class="w24">Name</li>
            <li class="w24">Role</li>
            <li class="w24">Account</li>
            <li class="w24">Status</li>
        </ul>
	    
<?php

foreach ($account_users as $account_user){
	//$class_to_status = account_status_2_class_name($account_user->user->status);
	$class_to_status = account_status_2_class_name(1);
	//$role_name = $account_user->acountrole->name;
	$role_name = "&nbsp";
	$account_name = "&nbsp";
?>
	<ul class="row">
        	<label>
                <li class="w4"><input name="selected[]" type="checkbox" value="<?php echo $user->id ;?>" class="formCheckbox"></li>
             </label>   
		    <li class="w24"><?php echo $account_user->name; ?></li>
                <li class="w24"><?php echo $role_name; ?></li>
                <li class="w24"><?php echo $account_name; ?></li>
                <li class="w24"><img src="<?php echo $transparent_img_url; ?>" width="1" height="1" alt="" class="<?php echo $class_to_status;?>"></li>
        </ul> 
<?php	    
}
?>
	                  
    </div>
		
	</form>
    
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
    
    