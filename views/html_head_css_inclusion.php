<?php 
	require_once 'util/DBCHelper.php'; 
	
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
		href="<?php echo BASEPATH . '/' . $cssName ?>" 
		rel="<?php echo $rel_text; ?>"
		type="text/css">
<?php
	}
?>


