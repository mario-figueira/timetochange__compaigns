<?php
require_once REALPATH .'/controllers/base.action.php';

class save_accountAction extends baseAction {
	
	public function execute($a_command){
		
		require_once REALPATH .'/business_entities/account.BE.php';
		
		$account = account__BE::create_from_POST_array($_POST);
		
		$validation_result = $account->is_valid();
		$is_valid=$validation_result['is_valid'];
		
		if (!$is_valid){
			throw new Exception ('tás maluco');
		}
		
		
		$accounts_repo = $this->get_repository_by_business_entity_name("account");
		
		$accounts_repo->_store($account);
	}

}