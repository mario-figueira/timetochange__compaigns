
<!--List fields-->

	<input name="field__id" type="hidden" value="<?php echo $vto->field__idPrompt; ?>">
	
	
    <div class="listForm">
	    
	    <ul>
       	  <li class="label">Accounts</li>
            <li class="field">
			<?php 
			$available_accounts = $vto->available_accounts;
			foreach ($available_accounts as $available_account){
			?>
			<label class="checkbox">
				<input name="field__idAccounts[]" type="checkbox" value="<?php echo $available_account->id;?>" class="formCheckbox">
				<?php echo $available_account->name;?>
			</label>
			<?php } ?>
            </li>
        </ul> 
	    
	    <ul>
       	  <li class="label">Name</li>
            <li class="field">
			<input name="field__name" type="text" class="formField fwLarge" value="<?php echo $vto->field__name; ?>">
            </li>
        </ul> 
	    <ul>
       	  <li class="label">Prompt</li>
            <li class="field">
			<input name="field__prompt_file_descriptor" type="file"  class="formField fwLarge" >							
            </li>
        </ul> 
    	<ul>
        	<li class="label">Description</li>
            <li class="field">
            	<input name="field__description" type="text" class="formField fwLarge" value="<?php echo $vto->field__description; ?>">
            </li>
        </ul>
        
	    

	    <ul>
		<li class="label"></li>
            <li class="field">
			<input type="submit" value="Save" class="formButton">
            </li>
        </ul> 
    </div>

    <!--End of List fields-->
    
    