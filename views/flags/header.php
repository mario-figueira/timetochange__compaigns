<!DOCTYPE html>
<!-- <?php if(SHOW_FILE_PATHS_IN_HTML===TRUE){ echo __FILE__;} ?> -->
<html lang="en">
	<head>
		<?php $charset = 'UTF-8'; ?> 	 
		
		<?php
			include REALPATH ."/views/html_head_metas.php";
		?>
		
		<?php
			include REALPATH ."/views/html_head_js_and_css_inclusion.php";
		?>

		
		<link href="<?php echo $active_site['domain']; ?>/css/stylesheet.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo $active_site['domain']; ?>/favicon.ico" rel="icon" type="image/x-icon" />

		<style type="text/css">
			.temaPaises {
				background-image: url('<?php echo $active_site['domain']; ?>/imgs/paises_inicio/fundo_paises.jpg');
				background-repeat: repeat-x;
				background-position: center top;
			}
			.center_main_paises {
				position: relative;
				width: 901px;
				height: 245px;
				margin-left: auto;
				margin-right: auto;
			}
			.header_paises {
				position: relative;
				margin-left: auto;
				margin-right: auto;
				margin-top: 0px;
				width: 901px;
				height: 260px;
			}
			.header_extra {
				margin-top: 120px;
			}

			.assinatura_paises {
				font-family: Arial, Helvetica, sans-serif;
				color: #FFFFFF;
				font-size: 16px;
				left: 10px;
				position: absolute;
				top: 200px;
			}
			.center_main_paises1 {
				float: left;
				height: 70px;
				width: 901px;
				position: relative;
				font-family: Arial, Helvetica, sans-serif;
				font-size: 20px;
				color: #14BFE5;
				padding-top: 50px;
			}
			.center_main_paises2 {
				float: left;
				height: auto;
				width: 901px;
				position: relative;
			}
			.center_main_paises2a {
				float: left;
				height: 32px;
				width: 190px;
				position: relative;
			}
			
			.link_home {
				height: 70px;
				left: 0;
				position: absolute;
				top: 1px;
				width: 603px;
			}
			
			.link_home a {
				color: #FFFFFF;
				display: block;
				font-family: 'ComfortaaBold',Arial,sans-serif;
				font-size: 65px;
				font-weight: normal;
				height: 70px;
				letter-spacing: 0;
				list-style-type: none;
				text-decoration: none;
				text-shadow: 1px 1px 1px #000000;
				width: 603px;
			}
		</style>
	</head>
	<!-- END OF HEADER GENERATOR-->
