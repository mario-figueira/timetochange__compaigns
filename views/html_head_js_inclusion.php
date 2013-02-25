<?php 
	require_once 'util/DBCHelper.php'; 
	
	$site_domain = "http://" .$_SERVER['HTTP_HOST'];
	if(isset($active_site['domain'])){
		$site_domain = $active_site['domain'];
	}

?>

	
	
<?php DBCHelper2::assert_that()->the_variable($js)->is_an_array(); ?>            
<?php 
	foreach ($js as $jsName) { 
?>
		<script 
			type="text/javascript" 
			src="<?php echo $site_domain . '/' . $jsName ?>"
		></script>
<?php 
	} 
?>

