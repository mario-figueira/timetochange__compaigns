<?php


class save_accountAction {
	
	public function execute($a_command){
		
		require_once REALPATH .'/business_entities/account.BE.php';
		
		$account = account__BE::create_from_POST_array($_POST);
		
		$validation_result = $account->is_valid();
		$is_valid=$validation_result['is_valid'];
		
		if (!$is_valid){
			throw new Exception ('tás maluco');
		}
		
		require_once REALPATH ."/repositories/repository.FACTORY.php";
		
		$repo_factory = new repository__FACTORY();
		
		$accounts_repo = $repo_factory->get_repository_by_business_entity_name("account");
		
		$accounts_repo->_store($account);
	}

}