<?php

require_once 'controllers/default.controller.php';

class settingsController extends defaultController {

	public function _default() {
		parent::_default();
	}
	
	public function _home(){
		parent::_defaultAction();
	}
	
	public function _alias(){
		
		$this->execute_action_class();
	
		
		parent::_defaultAction();
	}
	
	public function _add_alias(){
		
		$this->execute_action_class();
	
		
		parent::_defaultAction();
	}
	
	public function _save_alias(){
		
		$this->execute_action_class();
			
		$this->redirect_to_controller_action("settings", "alias");		
	}
	
	public function _delete_alias(){
		
		$this->execute_action_class();	
		
		$this->redirect_to_controller_action("settings", "alias");		
	}
	
	public function _edit_alias(){
		
		$this->execute_action_class();
			
		parent::_defaultAction();		
	}
/*
	public function _button1(){
		parent::_defaultAction();
	}
	
	public function _button2(){
		parent::_defaultAction();
	}
 * 
 */
}