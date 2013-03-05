<?php

require_once 'controllers/default.controller.php';

class loginController extends defaultController {

	public function _default() {
		//$this->redirect_to_controller_action("campaigns_mgnt", "accounts");
		
		parent::_defaultAction();
		
	}
		
	public function _show_login(){
		
		//$this->execute_action_class();
			
		parent::_defaultAction();
	}

	public function _login(){
		
		//$this->execute_action_class();
		
		$this->redirect_to_controller_action("campaigns_mgnt", "accounts");
			
		parent::_defaultAction();
	}
	
	public function _logout(){
		
		//$this->execute_action_class();
		
		$this->enforce_user_is_loggedin();
		//$this->enforce_has_permissions("login", "logout");
		
		$this->logout();
		
		$this->redirect_to_controller_action("login", "show_login");
			
		parent::_defaultAction();
	}

	
}