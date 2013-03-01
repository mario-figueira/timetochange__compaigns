<?php
require_once REALPATH .'/controllers/base.action.php';

class delete_accountAction extends baseAction {
	
	public function execute($a_command){
		
		
		$selected = $_POST['selected'];
		
		$no_selected_accounts = !isset($selected);
		if($no_selected_accounts){
			return;
		}
		
		$repo_factory = new repository__FACTORY();
		$accounts_repo = $this->get_repository_by_business_entity_name("account");
		
		
		foreach($selected as $account_id){
			$accounts_repo->remove_by_id($account_id);
		}
		
		
	}

}