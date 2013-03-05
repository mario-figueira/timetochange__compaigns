<!--Start Nav and Subnav-->

<?php
	$transparent_img_url = $this->build_img_url("transparent.png");
?>

<div class="subnav">
    <div class="header">
    	<p class="title">Login</p>
        <p class="desc">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.</p>
    </div>

     {{content}}
    
    <!--End of Form Example-->

</div>

<!--End of Content-->
<div class="clock">
	<?php 
		$hourNow = date("G:i");
		$dateNow = date("j F Y");
	?>
    <p class="time"><?php echo $hourNow;?></p>
    <p class="date"><?php echo $dateNow;?></p>
</div>
