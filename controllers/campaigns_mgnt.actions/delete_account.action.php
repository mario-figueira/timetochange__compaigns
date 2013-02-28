<?php


class delete_accountAction {
	
	public function execute($a_command){
		require_once REALPATH ."/repositories/repository.FACTORY.php";
		
		
		$selected = $_POST['selected'];
		
		$no_selected_accounts = !isset($selected);
		if($no_selected_accounts){
			return;
		}
		
		$repo_factory = new repository__FACTORY();
		$accounts_repo = $repo_factory->get_repository_by_business_entity_name("account");
		
		
		foreach($selected as $account_id){
			$accounts_repo->remove_by_id($account_id);
		}
		
		
	}

}