<!--Start Nav and Subnav-->

<?php
	$transparent_img_url = $this->build_img_url("transparent.png");
?>

<div class="subnav">
    <div class="header">
    	<p class="title">Explorer</p>
        <p class="desc">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.</p>
    </div>
    <div class="buttons">
        <ul>
            <li><a class="" href="<?php echo $this->build_action_url('explorer', 'prompts'); ?>"><img src="<?php echo $transparent_img_url; ?>" width="1" height="1" alt="" class="icoSubSound"><span>Prompts</span></a></li>
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
