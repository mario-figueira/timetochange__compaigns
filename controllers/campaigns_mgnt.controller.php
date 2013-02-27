<?php

require_once 'controllers/default.controller.php';

class campaigns_mgntController extends defaultController {

	public function _default() {
		parent::_default();
	}
	
	public function _home(){
		parent::_defaultAction();
	}

	public function _accounts(){
		
		require_once REALPATH ."/controllers/campaigns_mgnt.actions/accounts.action.php";
		
		$action = new accountsAction();
		$action->execute($this->Command);
	
		
		parent::_defaultAction();
	}
	
	public function _campaigns(){
		
		require_once REALPATH ."/controllers/campaigns_mgnt.actions/campaigns.action.php";
		
		$action = new campaignsAction();
		$action->execute($this->Command);
	
		
		parent::_defaultAction();
	}
}