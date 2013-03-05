<?php

require_once 'controllers/default.controller.php';

class campaigns_mgntController extends defaultController {

	public function _default() {
		$this->redirect_to_controller_action("campaigns_mgnt", "campaigns");
	}
	
	public function _home(){
		
		$this->enforce_user_is_loggedin();

		$this->redirect_to_controller_action("campaigns_mgnt", "campaigns");
	}

	public function _accounts(){
		
		$this->enforce_user_is_loggedin();
		
		$this->execute_action_class();
		
		parent::_defaultAction();
	}
	
	public function _add_account(){
		
		$this->execute_action_class();	
		
		parent::_defaultAction();
	}
	
	public function _save_account(){
		
		$this->execute_action_class();
			
		$this->redirect_to_controller_action("campaigns_mgnt", "accounts");		
	}
	
	
	
	
	public function _edit_account(){
		
		$this->execute_action_class();
			
		parent::_defaultAction();		
	}
	
	
	//timetochange__compaigns.com:8888/campaigns_mgnt/account_users/account_id/14/selected_menu/2/?XDEBUG_SESSION_START=netbeans-xdebug
	
	public function _account_users(){
		
		$this->execute_action_class();
			
		parent::_defaultAction();
	}

	
	public function _delete_account(){
		
		$this->execute_action_class();	
		
		$this->redirect_to_controller_action("campaigns_mgnt", "accounts");		
	}
	
	public function _add_user_to_account(){
		
		$this->execute_action_class();
			
		parent::_defaultAction();
	}
	
	public function _edit_account_user(){
		
		$this->execute_action_class();
			
		parent::_defaultAction();
	}

	public function _save_user_to_account(){
		
		$this->execute_action_class();
	
		$idAccount = $this->Command->get_parameter("idAccount");
		$this->redirect_to_controller_action("campaigns_mgnt", "account_users", "idAccount/{$idAccount}");
	}
	
	
	
	public function _account_aliases(){
		
		$this->execute_action_class();
			
		parent::_defaultAction();
	}

	
	
	
	
	public function _campaigns(){
		
		$this->execute_action_class();
				
		parent::_defaultAction();
	}
	
	public function _delete_campaign(){
		
		$this->execute_action_class();
			
		$this->redirect_to_controller_action("campaigns_mgnt", "campaigns");		
	}
	
	public function _add_campaign(){
		
		$this->execute_action_class();
			
		parent::_defaultAction();
	}
	
	public function _save_campaign(){
		
		$this->execute_action_class();
		
		$this->redirect_to_controller_action("campaigns_mgnt", "campaigns");		
	}
	
	public function _edit_campaign(){
		
		$this->execute_action_class();
		
		parent::_defaultAction();		
	}
	
	public function _campaign_aliases(){
		
		$this->execute_action_class();
			
		parent::_defaultAction();
	}

	
	public function _add_alias_to_campaign(){
		
		$this->execute_action_class();
			
		parent::_defaultAction();
	}

	public function _save_alias_to_campaign(){
		
		$this->execute_action_class();
	
		$idCampaign = $this->Command->get_parameter("idCampaign");
		$this->redirect_to_controller_action("campaigns_mgnt", "campaign_aliases", "idCampaign/{$idCampaign}");
	}	
	
	
}