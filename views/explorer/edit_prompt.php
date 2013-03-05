<?php
	$transparent_img_url = $this->build_img_url("transparent.png");
?>

    <div class="actionButtons">
        <ul>
            <li><a href="<?php echo $this->build_action_url('explorer', 'prompts'); ?>" title="Back"><img src="<?php echo $transparent_img_url; ?>" width="1" height="1" alt="" class="icoActionsBack"></a></li>
        </ul>        
    </div>

<?php
include_once 'prompt__form.php';
?>   