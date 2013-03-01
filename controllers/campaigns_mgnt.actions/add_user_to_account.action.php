<?php
require_once REALPATH .'/controllers/base.action.php';

class add_user_to_accountAction extends baseAction {
	
	public function execute($a_command){
		
		$idAccount = $a_command->get_variable_from_context("idAccount");
		
		DBCHelper2::require_that()->the_param($idAccount)->is_an_integer_string();
		

		$account_repo = $this->get_repository_by_business_entity_name('account');
		$account = $account_repo->get_by_id($idAccount);
		
		$role_repo = $this->get_repository_by_business_entity_name('role');
		$default_role = $role_repo->get_by_id(3);
				
		require_once REALPATH .'/value_objects/account_user.VO.php';
		
		$account_user = account_user__VO::create(array("id"=>null), $account, null, $default_role);
		
		$a_command->set_parameter("account_user", $account_user);

		
	}

}