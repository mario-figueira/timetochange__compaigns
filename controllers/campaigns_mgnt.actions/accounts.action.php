<?php

require_once REALPATH .'/controllers/base.action.php';

class accountsAction extends baseAction {
	
	public function execute($a_command){
		
		$accounts_repo = $this->get_repository_by_business_entity_name("account");
		
		$all_accounts = $accounts_repo->all__get();
		
		$a_command->set_parameter("accounts", $all_accounts);
		

	}

}