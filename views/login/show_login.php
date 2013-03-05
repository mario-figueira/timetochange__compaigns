<?php
	$submit_action_url = $this->build_action_url('login','login');
?>

    <!--List fields-->
    <form id="login_form" method="post" action="<?php echo $submit_action_url;?>" class="form" enctype="multipart/form-data">
	
	
    <div class="listForm">
    	<ul>
        	<li class="label">Username</li>
            <li class="field">
            	<input name="username" type="email" class="formField fwLarge" >
            </li>
        </ul>
    	  
	  <ul>
        	<li class="label">Password</li>
            <li class="field">
			<input name="password" type="text" class="formField fwLarge">
            </li>
        </ul>
	    	 
	    <ul>
		<li class="label"></li>
            <li class="field">
			<input type="submit" value="Login" class="formButton">
            </li>
        </ul> 
    </div>
    </form>
    <!--End of List fields-->
    
    