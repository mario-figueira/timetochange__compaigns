<?php

require_once REALPATH .'util/DBCHelper.php';


/**
 * Description of menus_items_enum
 *
 * @author mario.figueira@gtinformatica.eu
 * @author andre.aguiar@gtinformatica.eu
 */
	class account_status_enum{
		public static $C_INACTIVO = 0;
		public static $C_ACTIVO = 1;
		
		public static function account_status_2_display_name($a_account_status) {
			DBCHelper2::require_that()->the_param($a_account_status)->is_an_integer_string();

			$ret_val = "";

			$status_name = "";
			switch ($a_account_status) {
				case account_status_enum::$C_INACTIVO:
					$status_name = "Inactivo";
					break;
				case account_status_enum::$C_ACTIVO:
					$status_name = "Activo";
					break;
				default:
					throw new Exception("Unsuported case:[{$a_account_status}].");		
			}

			$ret_val = $status_name;

			DBCHelper2::ensure_that()->the_return_value($ret_val)->is_a_string();
			return $ret_val;
		}
	}
	
	
?>
