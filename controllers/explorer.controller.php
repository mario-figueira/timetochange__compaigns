<?php

require_once 'controllers/default.controller.php';

class explorerController extends defaultController {

	public function _default() {
		parent::_default();
	}
	
	public function _home(){
		parent::_defaultAction();
	}

	public function _prompts(){
		
		$this->execute_action_class();
	
		
		parent::_defaultAction();
	}
	
	public function _add_prompt(){
		
		$this->execute_action_class();
	
		
		parent::_defaultAction();
	}
	
	public function _save_prompt(){
		
		$this->execute_action_class();
			
		$this->redirect_to_controller_action("explorer", "prompts");		
	}
	
	public function _delete_prompt(){
		
		$this->execute_action_class();	
		
		$this->redirect_to_controller_action("explorer", "prompts");		
	}
	
	public function _edit_prompt(){
		
		$this->execute_action_class();
			
		parent::_defaultAction();		
	}
}