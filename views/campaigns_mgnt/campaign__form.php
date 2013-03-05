
<?php
	$submit_action_url = $this->build_action_url('campaigns_mgnt','save_campaign');
?>

    <!--List fields-->
    <form id="campaign_form" method="post" action="<?php echo $submit_action_url;?>" class="form" enctype="multipart/form-data">
	<input name="field__id" type="hidden" value="<?php echo $campaign->id; ?>">
	
	
    <div class="listForm">
	    <ul>
		<li class="label">Account*</li>
		<li class="field">
			<select name="field__idAccount" class="formField fwLargeList">
			
			<?php 
			foreach ($accounts as $account){
			?>	
				<option value="<?php echo $account->id; ?>"><?php echo $account->name; ?></option>
			<?php
			}
			?>
			</select>
		</li>
	    </ul>
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
        	<li class="label">Start Date</li>
            <li class="field">
            	<input name="field__startDate" type="text" class="formField fwLarge" value="<?php echo $campaign->startDate; ?>">
			<br>
			<span>ex:yyyy-mm-dd hh:mm:ss</span>
            </li>
        </ul>
	    <ul>
        	<li class="label">End Date</li>
            <li class="field">
            	<input name="field__endDate" type="text" class="formField fwLarge" value="<?php echo $campaign->endDate; ?>">
			<br>
			<span>ex:yyyy-mm-dd hh:mm:ss</span>
            </li>
        </ul>
	    <ul>
       	  <li class="label">Logo</li>
            <li class="field" >
			<div style="position:relative">
				<input name="field__logo" type="file" class="formField fwLarge" >					
			</div>
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
    
    