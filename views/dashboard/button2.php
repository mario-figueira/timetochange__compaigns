<?php
	$transparent_img_url = $this->build_img_url("transparent.png");
?>

    <div class="actionButtons">
        <ul>
            <li><a href="#" title="Tooltip"><img src="<?php echo $transparent_img_url; ?>" width="1" height="1" alt="" class="icoDashboard"></a></li>
            <li><a href="#" title="Tooltip"><img src="<?php echo $transparent_img_url; ?>" width="1" height="1" alt="" class="icoDatabase"></a></li>   
        </ul>        
    </div>
    
	dashboard/button2
    <!--List Table Example-->
    
    <div class="listTable">
    	<ul class="header">
        	<li class="w4">&nbsp;</li>
        	<li class="w24">Column 1</li>
            <li class="w24">Column 2</li>
            <li class="w24">Column 3</li>
            <li class="w24">Column 4</li>
        </ul>
		<ul class="row">
        	<label>
                <li class="w4"><input name="" type="checkbox" value="" class="formCheckbox"></li>
                <li class="w24">Row</li>
                <li class="w24">Row</li>
                <li class="w24">Row</li>
                <li class="w24"><img src="<?php echo $transparent_img_url; ?>" width="1" height="1" alt="" class="icoDatabase"></li>
            </label>
            <p>
            	<img src="<?php echo $transparent_img_url; ?>" width="1" height="1" alt="" class="icoDatabase"> 
                <input type="text" class="formField fwWideRow" value="Write Here...">
            </p>
        </ul>        
    	<ul class="row">
        	<label>
                <li class="w4"><input name="" type="checkbox" value="" class="formCheckbox"></li>
                <li class="w24">Row</li>
                <li class="w24">Row</li>
                <li class="w24">Row</li>
                <li class="w24">Text<img src="<?php echo $transparent_img_url; ?>" width="1" height="1" alt="" class="icoDatabase"></li>
            </label>
        </ul>
    	<ul class="row">
        	<label>
                <li class="w4"><input name="" type="checkbox" value="" class="formCheckbox"></li>
                <li class="w24">Row</li>
                <li class="w24">Row</li>
                <li class="w24">Row</li>
                <li class="w24">
                    <input name="" type="text" class="formField fwSmallRow">
                    <img src="<?php echo $transparent_img_url; ?>" width="1" height="1" alt="" class="icoDatabase">
                </li>
            </label>
        </ul>               
    </div>
    
    <!--End of List Table Example-->
    
    <!--Form Example-->
    
    <div class="listForm">
    	<ul>
        	<li class="label">Text Field</li>
            <li class="field">
            	<input name="" type="text" class="formField fwLarge">
            </li>
            <li class="label">Text Field Small</li>
            <li class="field">
            	<input name="" type="text" class="formField fwSmall"> - <input name="" type="text" class="formField fwSmall">
            </li>
        </ul>
    	<ul>
       	  <li class="label">List Menu</li>
          <li class="field">
               <select name="" class="formField fwLargeList">
                 <option>List A</option>
                 <option>List B</option>
               </select>
          </li>
       	  <li class="label">List Menu Small</li>
          <li class="field">
               <select name="" class="formField fwSmallList">
                 <option>List A</option>
                 <option>List B</option>
               </select>
          </li>          
        </ul>
        <ul>
       	  <li class="label">Button</li>
            <li class="field">
				<input type="button" value="Button" class="formButton">
            </li>
        </ul> 
    	<ul>
        	<li class="label">Text Field + Action Button</li>
            <li class="field">
            	<a href="#" title="Tooltip"><img src="<?php echo $transparent_img_url; ?>" width="1" height="1" alt="" class="icoDatabase"></a>
                <a href="#" title="Tooltip"><img src="<?php echo $transparent_img_url; ?>" width="1" height="1" alt="" class="icoDatabase"></a>
                <input name="" type="text" class="formField fwLarge">
            </li>
            <li class="label">Action Button</li>
            <li class="field">
            	<a href="#" title="Tooltip"><img src="<?php echo $transparent_img_url; ?>" width="1" height="1" alt="" class="icoDatabase"></a>
            </li>
        </ul>
    	<ul>
        	<li class="label">Checkbox</li>
            <li class="field">
				<label class="checkbox">
                	<input name="" type="checkbox" value="" class="formCheckbox">
                    760201853
                </label>
				<label class="checkbox">
                	<input name="" type="checkbox" value="" class="formCheckbox">
                    760201853
                </label>                
            </li>
        </ul>                                   
    </div>
    
    <!--End of Form Example-->

