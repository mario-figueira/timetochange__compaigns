
<?php
	$submit_action_url = $this->build_action_url('campaigns_mgnt','save_account');
?>

    <!--List fields-->
    <form id="account_form" method="post" action="<?php echo $submit_action_url;?>" class="form">
    <div class="listForm">
    	<ul>
        	<li class="label">Account Name*</li>
            <li class="field">
            	<input name="field__name" type="text" class="formField fwLarge">
            </li>
        </ul>
        <ul>
       	  <li class="label">Logo</li>
            <li class="field">
			<input type="hidden" value="" name="field__logo">
			<input type="button" value="Upload" class="formButton">
            </li>
        </ul> 
    	  
	  <ul>
        	<li class="label">Email Address</li>
            <li class="field">
			<input name="field__email" type="email" class="formField fwLarge">
            </li>
        </ul>
	    
	  <ul>
        	<li class="label">Phone Number</li>
            <li class="field">
			<input name="field__phone" type="number" class="formField fwLarge">
            </li>
        </ul>
	  <ul>
        	<li class="label">Fax Number</li>
            <li class="field">
            	<input name="field__fax" type="number" class="formField fwLarge">
            </li>
        </ul>
	  <ul>
        	<li class="label">Address</li>
            <li class="field">
			<input name="field__address" type="text" class="formField fwLarge">
            </li>
        </ul>
	  <ul>
            <li class="label">Postal Code</li>
            <li class="field">
            	<input name="field__zip1" type="text" class="formField fwSmall"> - <input name="field__zip2" type="text" class="formField fwSmall">
            </li>
        </ul>
	  <ul>
        	<li class="label">City</li>
            <li class="field">
			<input name="field__city" type="text" class="formField fwLarge">
            </li>
        </ul>
	  <ul>
		<li class="label">Country</li>
		<li class="field">
			<select name="field__idCountry" class="formField fwLargeList">
			
			<?php 
			foreach ($countries as $country){
			?>	
				<option value="<?php echo $country->idCountry; ?>"><?php echo $country->country; ?></option>
			<?php
			}
			?>
			</select>
		</li>
	    </ul>
	    <ul>
        	<li class="label">Notes</li>
            <li class="field">
			<input name="field__notes" type="text" class="formField fwLarge">
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
    </form>
    <!--End of List fields-->
    
    