<?php


class account_usersAction {
	
	public function execute($a_command){
		require_once REALPATH ."/repositories/repository.FACTORY.php";
		
		$repo_factory = new repository__FACTORY();
		
		$accounts_repo = $repo_factory->get_repository_by_business_entity_name("account");
		
		$a_account_id = $a_command->get_parameter("account_id");
		
		
		$account_users = $accounts_repo->users_of_account__get_by_account_id($a_account_id);
		
		$a_command->set_parameter("account_users", $account_users);
		
	}

}