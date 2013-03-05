
<?php
	$submit_action_url = $this->build_action_url('explorer','save_prompt');
?>

    <!--List fields-->
    <form id="prompt_form" method="post" action="<?php echo $submit_action_url;?>" class="form">
	<input name="field__id" type="hidden" value="<?php echo $prompt->id; ?>">
	
	
    <div class="listForm">
	    
	    <ul>
       	  <li class="label">Accounts</li>
            <li class="field">
			<?php 
			foreach ($accounts as $account){
			?>
			<label class="checkbox">
				<input name="" type="checkbox" value="$account->id" class="formCheckbox">
				<?php echo $account->name;?>
			</label>
			<?php } ?>
            </li>
        </ul> 
	    
	    <ul>
       	  <li class="label">Name</li>
            <li class="field">
			<input name="field__name" type="text" class="formField fwLarge" value="<?php echo $prompt->name; ?>">
            </li>
        </ul> 
	    <ul>
       	  <li class="label">Prompt</li>
            <li class="field">
			<input type="hidden" value="" name="field__prompt">
			<input type="button" value="Upload" class="formButton">
            </li>
        </ul> 
    	<ul>
        	<li class="label">Description</li>
            <li class="field">
            	<input name="field__description" type="text" class="formField fwLarge" value="<?php echo $prompt->description; ?>">
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
    
    