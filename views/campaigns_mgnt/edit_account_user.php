<?php
	$transparent_img_url = $this->build_img_url("transparent.png");
?>

    <div class="actionButtons">
        <ul>
            <li><a href="<?php echo $this->build_action_url('campaigns_mgnt', 'accounts'); ?>" title="Back"><img src="<?php echo $transparent_img_url; ?>" width="1" height="1" alt="" class="icoActionsBack"></a></li>
        </ul>        
    </div>


<?php
	$submit_action_url = $this->build_action_url('campaigns_mgnt','save_user_to_account');
?>

    <!--List fields-->
    <form id="account_form" method="post" action="<?php echo $submit_action_url;?>" class="form">

	    
	<input name="field__idAccount" type="hidden" value="<?php echo $account_user->name; ?>">

<?php
include_once 'user__form.php';
?>   
	    
    </form>