<?php

require_once REALPATH .'util/DBCHelper.php';


/**
 * Description of menus_items_enum
 *
 * @author mario.figueira@gtinformatica.eu
 */
	class menus_items_enum{
		public static $C_DASHBOARD = 1;
		public static $C_CAMPAIGNS_MGNT = 2;
		public static $C_EXPLORER = 3;
		public static $C_SETTINGS = 4;
		public static $C_PROFILE = 5;
		public static $C_LOGOUT = 6;
		public static $C_LOGIN = 7;
		public static $C_SAMPLE_CODE = 8;
		
		public static function menu_item_2_name($a_menu_index) {
			DBCHelper2::require_that()->the_param($a_menu_index)->is_an_integer_string();

			$ret_val = "";

			//require_once REALPATH . "enums/menu_items_enum.php";

			$menu_name = "";
			switch ($a_menu_index) {
				case menus_items_enum::$C_DASHBOARD:
					$menu_name = "dashboard";
					break;
				case menus_items_enum::$C_CAMPAIGNS_MGNT:
					$menu_name = "campaigns_mgnt";
					break;
				case menus_items_enum::$C_EXPLORER:
					$menu_name = "explorer";
					break;
				case menus_items_enum::$C_SETTINGS:
					$menu_name = "settings";
					break;
				case menus_items_enum::$C_PROFILE:
					$menu_name = "profile";
					break;
				case menus_items_enum::$C_LOGOUT:
					$menu_name = "logout";
					break;
				case menus_items_enum::$C_LOGIN:
					$menu_name = "login";
					break;
				case menus_items_enum::$C_SAMPLE_CODE:
					$menu_name = "sample_code";
					break;
				default:
					throw new Exception("Unsuported case:[{$a_menu_index}].");		
			}

			$ret_val = $menu_name;

			DBCHelper2::ensure_that()->the_return_value($ret_val)->is_a_string();
			return $ret_val;
		}
	}
	
?>
