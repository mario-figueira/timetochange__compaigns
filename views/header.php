<!DOCTYPE html> 
<html lang="<?php echo substr($language['short'], 0, 2); ?>">
	<head>
		<!-- <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8" /> -->
<?php
		$charset = 'utf-8';
?> 	 

<?php
		include REALPATH . "/views/html_head_metas.php";
		include REALPATH . "/views/html_head_metas_facebook.php";
?>

		<!-- meta name="viewport" content="width=device-width, initial-scale=1" -->


		<style type="text/css">
			.error{
				color: #FF0000;
				float: left;
				font-family: Arial,Helvetica,sans-serif;
				font-size: 11px;
				font-style: normal;
				height: auto;
				padding-top: 5px;
			}
		</style>
		<!-- <meta http-equiv="Expires" content="<?php echo $timestamp; ?>"> --> <!-- Proxies -->


<?php
		include REALPATH . "/views/html_head_js_and_css_inclusion.php";
?>


		<link href="<?php echo $active_site['domain']; ?>favicon.ico" rel="icon" type="image/x-icon">

	</head>


	<body id="all_container" class="browser_center">
		
		<div class="clear"></div>
			

		<div id="app_header" class="">
			«HEADER»
		</div>
		
		<div id="app_body" class="">
<!-- file header.php - END -->




			
	

<?php
	//the next code nevers renders it just serves to satisfy the netbeans
	if (FALSE) {
?>		
		</div>
	</body>
</html>
<?php
	}
?>

<!-- do not remove this, its used to force saving in utf8 with no BOM áéíóú àèìòù âêîôû ãõñ ç ºª ÁÉÍÓÚÀÈÌÒÙ -->