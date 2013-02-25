<!-- <?php if(SHOW_FILE_PATHS_IN_HTML===TRUE){ echo __FILE__;} ?> -->
<?php 	
	$send_url =  $this->build_action_url("mail_demo", "usage_sample", null);
	$mail_show_url =  $this->build_action_url("mail_demo", "mail_show", null);
	
	
	
?>

mail demo usage:
<ul>
	<li>
		<a href="<?php echo $send_url; ?>"> send </a>
	</li>
	<li>
		<a href="<?php echo $mail_show_url; ?>"> show </a>
	</li>
</ul>
	
	
	