
	<input name="field__id" type="hidden" value="<?php echo $user->id; ?>">
	
	
    <div class="listForm">
    	<ul>
        	<li class="label">Nome*</li>
            <li class="field">
            	<input name="field__name" type="text" class="formField fwLarge" value="<?php echo $user->name; ?>">
            </li>
        </ul>
	    <ul>
        	<li class="label">Apelido*</li>
            <li class="field">
            	<input name="field__name" type="text" class="formField fwLarge" value="<?php echo $user->surname; ?>">
            </li>
        </ul>
        <ul>
       	 <li class="label">Foto</li>
            <li class="field">
			<input type="hidden" value="" name="field__photo">
			<input type="button" value="Upload" class="formButton">
            </li>
        </ul> 
    	  
	  <ul>
        	<li class="label">Email Address</li>
            <li class="field">
			<input name="field__email" type="email" class="formField fwLarge" value="<?php echo $user->email; ?>">
            </li>
        </ul>
	    
	  
	    <ul>
		<li class="label">Status*</li>
		<li class="field">
			<select name="field__status" class="formField fwLargeList">
				<?php 
				require_once REALPATH ."enums/account_status_enum.php";
				$status_activo = account_status_enum::$C_ACTIVO;
				$status_inactivo = account_status_enum::$C_INACTIVO;
				?>
				<option value="<?php echo $status_activo;?>"><?php echo account_status_enum::account_status_2_display_name($status_activo);?></option>
				<option value="<?php echo $status_inactivo;?>"><?php echo account_status_enum::account_status_2_display_name($status_inactivo);?></option>

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
    
    