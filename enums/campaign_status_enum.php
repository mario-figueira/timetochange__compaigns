<?php

require_once REALPATH .'util/DBCHelper.php';


/**
 * Description of menus_items_enum
 *
 * @author mario.figueira@gtinformatica.eu
 * @author andre.aguiar@gtinformatica.eu
 */
	class campaign_status_enum{
		public static $C_INACTIVO = 0;
		public static $C_ACTIVO = 1;
		public static $C_CONFIGURADA = 2;
		
		public static function campaign_status_2_display_name($a_campaign_status) {
			DBCHelper2::require_that()->the_param($a_campaign_status)->is_an_integer_string();

			$ret_val = "";

			$status_name = "";
			switch ($a_campaign_status) {
				case campaign_status_enum::$C_INACTIVO:
					$status_name = "Inactivo";
					break;
				case campaign_status_enum::$C_ACTIVO:
					$status_name = "Activo";
					break;
				case campaign_status_enum::$C_CONFIGURADA:
					$status_name = "Configurada";
					break;
				default:
					throw new Exception("Unsuported case:[{$a_campaign_status}].");		
			}

			$ret_val = $status_name;

			DBCHelper2::ensure_that()->the_return_value($ret_val)->is_a_string();
			return $ret_val;
		}
	}
	
	
?>
