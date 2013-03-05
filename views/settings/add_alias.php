<?php
	$transparent_img_url = $this->build_img_url("transparent.png");
?>

    <div class="actionButtons">
        <ul>
            <li><a href="<?php echo $this->build_action_url('settings', 'alias'); ?>" title="Back"><img src="<?php echo $transparent_img_url; ?>" width="1" height="1" alt="" class="icoActionsBack"></a></li>
        </ul>        
    </div>


<?php
	$submit_action_url = $this->build_action_url('settings','save_alias');
?>

    <!--List fields-->
    <form id="alias_form" method="post" action="<?php echo $submit_action_url;?>" class="form">
<?php
include_once 'alias__form.php';
?>   
	       </form>
