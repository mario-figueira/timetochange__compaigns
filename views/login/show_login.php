<?php
	$submit_action_url = $this->build_action_url('login','login');
?>
<fieldset class="login">
    <!--List fields-->
    <form id="login_form" method="post" action="<?php echo $submit_action_url;?>" class="form" enctype="multipart/form-data">
	
	    
		<input name="username" type="email" value="Email" class="formField fwLogin formField_clear">
            <input name="password" type="password" value="Password" class="formField fwLogin formField_clear">
            <p>&nbsp;</p>
            <input type="submit" value="Login" class="formButton fbLogin">
    </form>
</fieldset>

    <!--End of List fields-->
    
    