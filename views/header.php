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


	<body>
		
		<!-- <div class="clear"></div> -->
		
		<div id="container" class="container">
<!-- file header.php - END -->

<?php
	$transparent_img_url = $this->build_img_url("transparent.png");
	
	
	require_once REALPATH ."enums/menu_items_enum.php";
	
	$dashboard_classes = "";
	$campaigns_mgnt_classes = "";
	$explorer_classes = "";
	$settings_classes = "";
	$profile_classes = "";
	$logout_classes = "";
	$sample_code_classes = "";
	
	
	//$selected_menu = menus_items_enum::$C_CAMPAIGNS; //hardcoded;
	
	switch($selected_menu){
		case menus_items_enum::$C_DASHBOARD;
			$dashboard_classes = "selected";
			break;
		case menus_items_enum::$C_CAMPAIGNS_MGNT;
			$campaigns_mgnt_classes = "selected";
			break;
		case menus_items_enum::$C_EXPLORER;
			$explorer_classes = "selected";
			break;
		case menus_items_enum::$C_SETTINGS;
			$settings_classes = "selected";
			break;
		case menus_items_enum::$C_PROFILE;
			$profile_classes = "selected";
			break;
		case menus_items_enum::$C_LOGOUT;
			$logout_classes = "selected";
			break;
		case menus_items_enum::$C_SAMPLE_CODE;
			$sample_code_classes = "selected";
			break;
		default:
				throw new Exception("Unsuported case:[{$selected_menu}].");		
			break;
	}
	
	
	//$menu_item_campaigns_mgnt_action_url = BASEPATH ."main_menu/{$
?>
			<div class="nav">
				<ul>
					<li><a class="<?php echo $dashboard_classes;?>" href="<?php echo $this->build_select_menu_action_url(menus_items_enum::$C_DASHBOARD); ?>" title="Dashboard"><img src="<?php echo $transparent_img_url; ?>" width="1" height="1" alt="Dashboard" class="icoNavDashboard"></a></li>
					<li><a class="<?php echo $campaigns_mgnt_classes;?>" href="<?php echo $this->build_select_menu_action_url(menus_items_enum::$C_CAMPAIGNS_MGNT); ?>" title="Campaign Management"><img src="<?php echo $transparent_img_url; ?>" width="1" height="1" alt="Campaign Management" class="icoNavGear"></a></li>   
					<li><a class="<?php echo $explorer_classes;?>" href="<?php echo $this->build_select_menu_action_url(menus_items_enum::$C_EXPLORER); ?>" title="File Explorer"><img src="<?php echo $transparent_img_url; ?>" width="1" height="1" alt="File Explorer" class="icoNavShoebox"></a></li>    
					<li><a class="<?php echo $settings_classes;?>" href="<?php echo $this->build_select_menu_action_url(menus_items_enum::$C_SETTINGS); ?>" title="Settings"><img src="<?php echo $transparent_img_url; ?>" width="1" height="1" alt="Settings" class="icoNavWrench"></a></li>
					<li><a class="<?php echo $profile_classes;?>" href="<?php echo $this->build_select_menu_action_url(menus_items_enum::$C_PROFILE); ?>" title="Profile"><img src="<?php echo $transparent_img_url; ?>" width="1" height="1" alt="Profile" class="icoNavUser"></a></li>
					<li><a class="<?php echo $logout_classes;?>" href="<?php echo $this->build_select_menu_action_url(menus_items_enum::$C_LOGOUT); ?>" title="Logout"><img src="<?php echo $transparent_img_url; ?>" width="1" height="1" alt="Logout" class="icoNavCirclex"></a></li>
					<li><a class="<?php echo $sample_code_classes;?>" href="<?php echo $this->build_select_menu_action_url(menus_items_enum::$C_SAMPLE_CODE); ?>" title="Sample code"><img src="<?php echo $transparent_img_url; ?>" width="1" height="1" alt="Sample code" class=""></a></li>
				</ul>
				<div class="logoT2C"><img src="<?php echo $transparent_img_url; ?>" width="1" height="1" alt="Time 2 Change" class="icoT2C"></div>
			</div>



			
	

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