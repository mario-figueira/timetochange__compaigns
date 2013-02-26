<?php

require_once 'controllers/default.controller.php';

class main_menuController extends defaultController {

	public function _default() {
		parent::_default();
	}
	
/*	
	public function _dashboard(){
		
		require_once REALPATH ."enums/menu_items_enum.php";
		
		$this->Command->set_parameter('selected_menu', menus_items_enum::$C_DASHBOARD);
		
		parent::_defaultAction();
	}

	public function _campaigns_mgnt(){
		
		require_once REALPATH ."enums/menu_items_enum.php";
		
		$this->Command->set_parameter('selected_menu', menus_items_enum::$C_CAMPAIGNS_MGNT);
		
		parent::_defaultAction();
	}
*/	
}