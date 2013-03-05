
	<input name="field__id" type="hidden" value="<?php echo $vto->field__idAlias; ?>">
	
	
    <div class="listForm">
	    


	    	  <ul>
		<li class="label">Alias*</li>
		<li class="field">
			<select name="field__idAlias" class="formField fwLargeList">
			
			<?php 
			foreach ($vto->available_aliases as $available_alias){
				$alias = $available_alias->alias;
			?>	
				<option value="<?php echo $alias->id; ?>"><?php echo $alias->alias; ?></option>
			<?php
			}
			?>
			</select>
		</li>
	    </ul>
	    
	    
	    
	    	  <ul>
		<li class="label">Prompt in</li>
		<li class="field">
			<select name="field__idPromptIn" class="formField fwLargeList">
			
			<?php 
			foreach ($vto->available_prompts as $available_prompt){
			?>	
				<option value="<?php echo $available_prompt->id; ?>"><?php echo $available_prompt->name; ?></option>
			<?php
			}
			?>
			</select>
		</li>
	    </ul>
	    
	    <ul>
	<li class="label">Prompt out</li>
		<li class="field">
			<select name="field__idPromptOut" class="formField fwLargeList">
			
			<?php 
			foreach ($vto->available_prompts as $available_prompt){
			?>	
				<option value="<?php echo $available_prompt->id; ?>"><?php echo $available_prompt->name; ?></option>
			<?php
			}
			?>
			</select>
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
    
    