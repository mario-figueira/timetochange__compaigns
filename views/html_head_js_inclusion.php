<?php 
	require_once 'util/DBCHelper.php'; 
	
?>

	
	
<?php DBCHelper2::assert_that()->the_variable($js)->is_an_array(); ?>            
<?php 
	foreach ($js as $jsName) { 
?>
		<script 
			type="text/javascript" 
			src="<?php echo BASEPATH . '/' . $jsName ?>"
		></script>
<?php 
	} 
?>

