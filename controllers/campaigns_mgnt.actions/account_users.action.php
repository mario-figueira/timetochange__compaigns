<?php
require_once REALPATH .'/controllers/base.action.php';

class account_usersAction extends baseAction {
	
	public function execute($a_command){
		
		$idAccount = $a_command->get_variable_from_context("idAccount", null);
		
		$idAccount_was_passed = isset($idAccount);
		
		$account_id_to_show_users = null;
		if($idAccount_was_passed){
			$account_id_to_show_users = $idAccount;
		}
		else{
			$selected = $_POST['selected'];

			$no_selected_accounts = !isset($selected);
			if($no_selected_accounts){
				return;
			}
			
			$account_id_to_show_users = $selected[0];
		}
		

		
		
		
		$accounts_repo = $this->get_repository_by_business_entity_name("account");
		
		$account = $accounts_repo->get_by_id($account_id_to_show_users);
		
		
		$account_users = $accounts_repo->users_of_account__get_by_account($account);
		
		$a_command->set_parameter("account", $account);
		$a_command->set_parameter("account_users", $account_users);
		
	}

}