
<?php
	$submit_action_url = $this->build_action_url('settings','save_alias');
?>

    <!--List fields-->
    <form id="alias_form" method="post" action="<?php echo $submit_action_url;?>" class="form">
	<input name="field__id" type="hidden" value="<?php echo $alias->id; ?>">
	
	
    <div class="listForm">
    	<ul>
        	<li class="label">Number*</li>
            <li class="field">
            	<input name="field__alias" type="text" class="formField fwLarge" value="<?php echo $alias->alias; ?>">
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
    
    