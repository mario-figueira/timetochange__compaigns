<!-- <?php if(SHOW_FILE_PATHS_IN_HTML===TRUE){ echo __FILE__;} ?> -->
<?php
$base_url = $active_site['domain'] .'/'. $country['name'] .'/zSystem/';
$set_language_to_portuguese_action_url = declare_url($base_url .'set_language_to_portuguese/');
$set_language_to_english_action_url = declare_url($base_url .'set_language_to_english/');
$set_language_to_greek_action_url = declare_url($base_url .'set_language_to_greek/');
$set_language_to_spanish_action_url = declare_url($base_url .'set_language_to_spanish/');
$set_language_to_brazilien_action_url = declare_url($base_url .'set_language_to_brazilien/');
$set_site_mode_to_teaser_action_url = declare_url($base_url .'set_site_mode_to_teaser/');
$set_site_mode_to_normal_action_url = declare_url($base_url .'set_site_mode_to_normal/');
$reload_facebook_metatags_url = "https://developers.facebook.com/tools/debug/og/object?q={$base_url}&format=json";

$base_url = $active_site['domain'] .'/'. $country['name'] .'/';
$logout_url = declare_url($base_url .'/default/logout/')
?>
<div class="center_main">
<!-- 	
	<h2>
		Language
	</h2>
	<h3>
		Set language to:
	</h3>
	<ul>
		<li><a href="<?php echo $set_language_to_portuguese_action_url; ?>" >portuguese</a></li>
		<li><a href="<?php echo $set_language_to_english_action_url; ?>" >english</a></li>
		<li><a href="<?php echo $set_language_to_greek_action_url; ?>" >greek</a></li>
		<li><a href="<?php echo $set_language_to_spanish_action_url; ?>" >spanish</a></li>
		<li><a href="<?php echo $set_language_to_brazilien_action_url; ?>" >brazilien</a></li>
	</ul>
	<br />
	<br />
	<br />
	<br />
-->
	<h2>
		Site mode
	</h2>
	<h3>
		Set site mode to:
	</h3>
	<ul>
		<li><a href="<?php echo $set_site_mode_to_teaser_action_url; ?>" >landing</a></li>
		<li><a href="<?php echo $set_site_mode_to_normal_action_url; ?>" >normal</a></li>
	</ul>
	<br />
	<br />
	<br />
	<br />
	
	<h2>
		Social Networks
	</h2>
		<ul>
			<li><a href="<?php echo $reload_facebook_metatags_url?>" target="_blank">Reload Facebook metatags</a></li>
		</ul>
		<br />
	<br />
	<br />
	<br />
	<h2>
		Login\Logout
	</h2>
	<ul>
		<li><a href="<?php echo $logout_url; ?>" >logout</a></li>
	</ul>
	<br />
	<br />
	<br />
	<br />
	
</div>