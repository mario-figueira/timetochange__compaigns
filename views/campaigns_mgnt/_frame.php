<!--Start Nav and Subnav-->

<?php
	$transparent_img_url = $this->build_img_url("transparent.png");
?>

<div class="subnav">
    <div class="header">
    	<p class="title">Campaign Management</p>
        <p class="desc">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.</p>
    </div>
    <div class="buttons">
        <ul>
            <li><a class="" href="#"><img src="<?php echo $transparent_img_url; ?>" width="1" height="1" alt="" class="icoCirclex"><span>Button A</span></a></li>
            <li><a class="selected" href="#"><img src="<?php echo $transparent_img_url; ?>" width="1" height="1" alt="" class="icoCirclex"><span>Button B</span></a></li>
            <li><a class="" href="<?php echo $this->build_action_url('sample', 'show'); ?>"><img src="<?php echo $transparent_img_url; ?>" width="1" height="1" alt="" class="icoCirclex"><span>Sample/Show</span></a></li>
            <li><a class="" href="<?php echo $this->build_action_url('campaigns_mgnt', 'accounts'); ?>"><img src="<?php echo $transparent_img_url; ?>" width="1" height="1" alt="" class="icoCirclex"><span>Accounts</span></a></li>
            <li><a class="" href="<?php echo $this->build_action_url('campaigns_mgnt', 'campaigns'); ?>"><img src="<?php echo $transparent_img_url; ?>" width="1" height="1" alt="" class="icoCirclex"><span>Campaigns</span></a></li>
        </ul>                       
    </div>    
</div>      

<!--End of Nav and Subnav-->

<!--Start Content-->

<div class="content">

	<div class="breadcrumbs"><a href="#">Breadcrumbs</a> / Page</div>

     {{content}}
    
    <!--End of Form Example-->

</div>

<!--End of Content-->
