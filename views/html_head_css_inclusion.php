<?php 
	require_once 'util/DBCHelper.php'; 
	
	$site_domain = "http://" .$_SERVER['HTTP_HOST'];
	if(isset($active_site['domain'])){
		$site_domain = $active_site['domain'];
	}

?>
     
<?php DBCHelper2::assert_that()->the_variable($css)->is_an_array(); ?>            
<?php 
	foreach ($css as $cssName) { 
		$is_a_less_file = strpos($cssName, ".less")!=FALSE;
		$text_type = "css";
		if($is_a_less_file){
			$rel_text = "stylesheet/less";
		}else{
			$rel_text = "stylesheet";
		}
?>
	<link 
		href="<?php echo $site_domain . '/' . $cssName ?>" 
		rel="<?php echo $rel_text; ?>"
		type="text/css">
<?php
	}
?>


