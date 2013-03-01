<?php

require_once 'controllers/default.controller.php';

class campaigns_mgntController extends defaultController {

	public function _default() {
		$this->redirect_to_controller_action("campaigns_mgnt", "accounts");
	}
	
	public function _home(){
		$this->redirect_to_controller_action("campaigns_mgnt", "accounts");
	}

	public function _accounts(){
		
		require_once REALPATH ."/controllers/campaigns_mgnt.actions/accounts.action.php";
		
		$action = new accountsAction();
		$action->execute($this->Command);
	
		
		parent::_defaultAction();
	}
	
	public function _add_account(){
		
		require_once REALPATH ."/controllers/campaigns_mgnt.actions/add_account.action.php";
		
		$action = new add_accountAction();
		$action->execute($this->Command);
	
		
		parent::_defaultAction();
	}
	
	public function _save_account(){
		
		require_once REALPATH ."/controllers/campaigns_mgnt.actions/save_account.action.php";
		
		$action = new save_accountAction();
		$action->execute($this->Command);
	
		
		$this->redirect_to_controller_action("campaigns_mgnt", "accounts");
		
	}
	
	
	
	
	public function _edit_account(){
		
		require_once REALPATH ."/controllers/campaigns_mgnt.actions/edit_account.action.php";
		
		$action = new edit_accountAction();
		$action->execute($this->Command);
	
		
		parent::_defaultAction();
		
	}
	
	
	//timetochange__compaigns.com:8888/campaigns_mgnt/account_users/account_id/14/selected_menu/2/?XDEBUG_SESSION_START=netbeans-xdebug
	
	public function _account_users(){
		
		require_once REALPATH ."/controllers/campaigns_mgnt.actions/account_users.action.php";
		
		$action = new account_usersAction();
		$action->execute($this->Command);	
	
		
		parent::_defaultAction();
	}

	
	public function _add_user_to_account(){
		
		require_once REALPATH ."/controllers/campaigns_mgnt.actions/add_user_to_account.action.php";
		
		$action = new add_user_to_accountAction();
		$action->execute($this->Command);	
	
		
		parent::_defaultAction();
	}
	
	public function _save_user_to_account(){
		
		require_once REALPATH ."/controllers/campaigns_mgnt.actions/save_user_to_account.action.php";
		
		$action = new save_user_to_accountAction();
		$action->execute($this->Command);	
	
		
		parent::_defaultAction();
	}

	
	public function _delete_account(){
		
		require_once REALPATH ."/controllers/campaigns_mgnt.actions/delete_account.action.php";
		
		$action = new delete_accountAction();
		$action->execute($this->Command);
	
		
		$this->redirect_to_controller_action("campaigns_mgnt", "accounts");
		
	}
	
	
	
	
	public function _campaigns(){
		
		require_once REALPATH ."/controllers/campaigns_mgnt.actions/campaigns.action.php";
		
		$action = new campaignsAction();
		$action->execute($this->Command);
	
		
		parent::_defaultAction();
	}
	
	public function _delete_campaign(){
		
		require_once REALPATH ."/controllers/campaigns_mgnt.actions/delete_campaign.action.php";
		
		$action = new delete_campaignAction();
		$action->execute($this->Command);
	
		
		$this->redirect_to_controller_action("campaigns_mgnt", "campaigns");
		
	}
	
	public function _add_campaign(){
		
		require_once REALPATH ."/controllers/campaigns_mgnt.actions/add_campaign.action.php";
		
		$action = new add_campaignAction();
		$action->execute($this->Command);
	
		
		parent::_defaultAction();
	}
	
	public function _save_campaign(){
		
		require_once REALPATH ."/controllers/campaigns_mgnt.actions/save_campaign.action.php";
		
		$action = new save_campaignAction();
		$action->execute($this->Command);
	
		
		$this->redirect_to_controller_action("campaigns_mgnt", "campaigns");
		
	}
	
	public function _edit_campaign(){
		
		require_once REALPATH ."/controllers/campaigns_mgnt.actions/edit_campaign.action.php";
		
		$action = new edit_campaignAction();
		$action->execute($this->Command);
	
		
		parent::_defaultAction();
		
	}
}