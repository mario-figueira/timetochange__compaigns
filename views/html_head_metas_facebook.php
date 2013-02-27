<!-- <?php if(SHOW_FILE_PATHS_IN_HTML===TRUE){ echo __FILE__;} ?> -->
                
<?php
	$domain = $active_site['domain'];
	$country_name = $country['name'];
	$country_code = strtolower($country['id']);
	//$printable_name = $community['printable_name'];
	$img_name = 'to_facebook_img.jpg';

	$og_url = empty($active_site['domain']) ? $_SERVER['HTTP_HOST'] : $active_site['domain'] ."/". $country['name'];
	$og_image_url = $this->build_img_url($img_name);
	$og_title = _("to_facebook_title");
	$og_description =  _("to_facebook_description");
	$og_site_name = _("to_facebook_site_name");
	
?>
 
                <!-- FACEBOOK -->
                <meta property="og:title" content="<?php echo $og_title; ?>">
                <meta property="og:type" content="website">
                <meta property="og:url" content="<?php echo $og_url; ?>">
                <meta property="og:image" content="<?php echo $og_image_url; ?>">
                <meta property="og:site_name" content="<?php echo $og_site_name; ?>">
                <meta property="fb:admins" content="722988375">
                <meta property="og:description" content="<?php echo $og_description; ?>">
                <!--  FACEBOOK -->