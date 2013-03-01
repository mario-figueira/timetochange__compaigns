<?php


class save_user_to_accountAction {
	
	public function execute($a_command){
		require_once REALPATH ."/repositories/repository.FACTORY.php";		
		$repo_factory = new repository__FACTORY();
				
		//grab the account_user_VO data
		require_once REALPATH .'/value_objects/account_user.VO.php';		
		$account_user = account_user__VO::create_from_POST_array($_POST);
		$role_id = $account_user->idAccountRole;
		DBCHelper2::require_that()->the_param($role_id)->is_an_integer_string();		
		$account_id = $account_user->idAccount;
		DBCHelper2::require_that()->the_param($account_id)->is_an_integer_string();
		
		// grab the user data
		require_once REALPATH .'/business_entities/user.BE.php';		
		$user = user__BE::create_from_record($account_user->_get_fields_array());

		// grab the role from the database
		$role_repo = $repo_factory->get_repository_by_business_entity_name("role");		
		$role = $role_repo->get_by_id($role_id);
		
		// grab the account from the database	
		$account_repo = $repo_factory->get_repository_by_business_entity_name("account");
		$account = $account_repo->get_by_id($account_id);
		
		
		//save the user entity		
		require_once REALPATH ."/repositories/repository.FACTORY.php";		
		$repo_factory = new repository__FACTORY();
		
		$user_repo = $repo_factory->get_repository_by_business_entity_name("user");
		
		$user_id = $user_repo->_store($user);

		//save the relation between user and account
		$account_repo->add_user_to_account($user_id, $account_id, $role_id);

		
	}

}