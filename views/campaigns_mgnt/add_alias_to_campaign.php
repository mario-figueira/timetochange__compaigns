<?php
	$transparent_img_url = $this->build_img_url("transparent.png");
?>
	
    <div class="actionButtons">
        <ul>
            <li><a href="<?php echo $this->build_action_url('campaigns_mgnt', 'campaigns'); ?>" title="Back"><img src="<?php echo $transparent_img_url; ?>" width="1" height="1" alt="" class="icoActionsBack"></a></li>
        </ul>        
    </div>


<?php
	$idCampaign = $vto->field__idCampaign;	
	$submit_action_url = $this->build_action_url('campaigns_mgnt','save_alias_to_campaign', "idCampaign/{$idCampaign}");
?>

    <!--List fields-->
    <form id="campaign_form" method="post" action="<?php echo $submit_action_url;?>" class="form">

	    <input name="field__idCampaign" type="hidden" value="<?php echo $idCampaign; ?>">

<?php
include_once 'add_alias_to_campaign__form.php';
?>   
	    
    </form>