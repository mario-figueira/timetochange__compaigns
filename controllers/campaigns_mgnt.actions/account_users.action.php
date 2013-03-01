<?php


class account_usersAction {
	
	public function execute($a_command){
		require_once REALPATH ."/repositories/repository.FACTORY.php";
		
		$selected = $_POST['selected'];
		
		$no_selected_accounts = !isset($selected);
		if($no_selected_accounts){
			return;
		}
		
		$account_id_to_show_users = $selected[0];

		
		
		$repo_factory = new repository__FACTORY();
		
		$accounts_repo = $repo_factory->get_repository_by_business_entity_name("account");
		
		$account = $accounts_repo->get_by_id($account_id_to_show_users);
		
		
		$account_users = $accounts_repo->users_of_account__get_by_account($account);
		
		$a_command->set_parameter("account_users", $account_users);
		
	}

}