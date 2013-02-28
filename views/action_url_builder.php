<?php

class action_url_builder {
	/*
	  public function __construct() {
	  }
	 */

	public function build_url(
		$a_controller_name
		, $a_action_name
		, $a_selected_menu_index
		, $a_parameters_string = null
	) {
		$ret_val = "";

		$action_is_set = isset($a_action_name);
		if ($action_is_set) {
			$action_name = $a_action_name;
		} else {
			$action_name = "default";
		}
		
		
		$controller_action_url = BASEPATH . "{$a_controller_name}/{$action_name}/selected_menu/{$a_selected_menu_index}/";
		
		
		
		if (isset($a_parameters_string)) {
			$controller_action_url = "$controller_action_url{$a_parameters_string}/";
		}
		$controller_action_url = declare_url($controller_action_url);

		$ret_val = $controller_action_url;

		return $ret_val;
	}

}

?>