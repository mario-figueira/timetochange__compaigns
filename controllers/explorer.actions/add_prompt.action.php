<?php

require_once REALPATH .'/controllers/base.action.php';


class add_promptAction extends baseAction{
	
	public function execute($a_command){
		require_once REALPATH ."/repositories/repository.FACTORY.php";
		
		$repo_factory = new repository__FACTORY();
		
		$accounts_repo = $repo_factory->get_repository_by_business_entity_name("account");
		
		$all_account = $accounts_repo->all__get();
		
		
		
		require_once REALPATH ."/data_transfer_objects/prompt_to_accounts.VTO.php";

		$prompt_to_accounts__VTO = new prompt_to_accounts__VTO();
		$prompt_to_accounts__VTO->available_accounts = $all_account;
		$prompt_to_accounts__VTO->field__idAccounts = array();
		$prompt_to_accounts__VTO->field__idPrompt = null;
		$prompt_to_accounts__VTO->field__name = null;
		$prompt_to_accounts__VTO->field__description = null;
		$prompt_to_accounts__VTO->field__prompt_file_name = null;
		$prompt_to_accounts__VTO->field__prompt_file_descriptor = null;
		$prompt_to_accounts__VTO->freeze();
		
		$a_command->set_parameter("vto", $prompt_to_accounts__VTO);
		
	}

}