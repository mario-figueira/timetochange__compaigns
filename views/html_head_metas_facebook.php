<!-- <?php if(SHOW_FILE_PATHS_IN_HTML===TRUE){ echo __FILE__;} ?> -->
                
<?php
	$domain = $active_site['domain'];
	$country_name = $country['name'];
	$country_code = strtolower($country['id']);
	//$printable_name = $community['printable_name'];
	$img_name = empty($country_code)?'og_ambassadors_white_default.jpg':"og_ambassadors_white_{$country_code}.jpg";

	$og_url = empty($active_site['domain']) ? $_SERVER['HTTP_HOST'] : $active_site['domain'] ."/". $country['name'];
	$og_image_url = $this->build_img_url($img_name);
	$og_title = empty($country_code)? '' : _("Estamos à procura de 20.000 experimentadores de produtos no Brasil.");
	$og_description =  empty($country_code)?'': _("Queres ajudar a renovar tendências? Como embaixador podes transformar-te num autêntico trend setter. Vais poder experimentar produtos das tuas marcas ou produtos preferidos e dar-lhes feedback sobre os mesmos. É tudo muito simples, sem custos e com muita diversão. ");
	$og_site_name = empty($printable_name)?$_SERVER['HTTP_HOST'] :$community['printable_name'];
	
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