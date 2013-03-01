
<?php
	$submit_action_url = $this->build_action_url('campaigns_mgnt','save_campaign');
?>

    <!--List fields-->
    <form id="campaign_form" method="post" action="<?php echo $submit_action_url;?>" class="form">
	<input name="field__id" type="hidden" value="<?php echo $campaign->id; ?>">
	
	
    <div class="listForm">
	    <ul>
		<li class="label">Type*</li>
		<li class="field">
			<select name="field__idCampaignType" class="formField fwLargeList">
			
			<?php 
			foreach ($campaigntypes as $campaigntype){
			?>	
				<option value="<?php echo $campaigntype->id; ?>"><?php echo $campaigntype->name; ?></option>
			<?php
			}
			?>
			</select>
		</li>
	    </ul>
    	<ul>
        	<li class="label">Campaign Name*</li>
            <li class="field">
            	<input name="field__name" type="text" class="formField fwLarge" value="<?php echo $campaign->name; ?>">
            </li>
        </ul>
	   
	    <ul>
		<li class="label"></li>
            <li class="field">
			<input type="submit" value="Save" class="formButton">
            </li>
        </ul> 
    </div>
    </form>
    <!--End of List fields-->
    
    