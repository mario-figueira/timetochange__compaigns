<?php

require_once REALPATH .'util/DBCHelper.php';


/**
 * Description of menus_items_enum
 *
 * @author mario.figueira@gtinformatica.eu
 * @author andre.aguiar@gtinformatica.eu
 */
	class prompt_function_enum{
		public static $C_ENTRADA= 1;
		public static $C_SAIDA = 2;
		public static $C_VENCEDOR = 3;
		
		public static function prompt_function_2_display_name($a_prompt_function) {
			DBCHelper2::require_that()->the_param($a_prompt_function)->is_an_integer_string();

			$ret_val = "";

			$prompt_function_name = "";
			switch ($a_prompt_function) {
				case account_status_enum::C_ENTRADA:
					$prompt_function_name = "Entrada";
					break;
				case account_status_enum::$C_SAIDA:
					$prompt_function_name = "Saida";
					break;
				case account_status_enum::$C_VENCEDOR:
					$prompt_function_name = "Vencedor";
					break;
				default:
					throw new Exception("Unsuported case:[{$a_prompt_function}].");		
			}

			$ret_val = $prompt_function_name;

			DBCHelper2::ensure_that()->the_return_value($ret_val)->is_a_string();
			return $ret_val;
		}
	}
	
	
?>
