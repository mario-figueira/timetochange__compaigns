<?php

require_once REALPATH .'/controllers/base.action.php';


class save_promptAction extends baseAction{
	
	public function execute($a_command){

		require_once REALPATH ."/data_transfer_objects/prompt_to_accounts.VTO.php";

		$posted_values =  $a_command->get_posted_values();
		
		$prompt_to_accounts__VTO = prompt_to_accounts__VTO::create_from_POST_array($posted_values);
		
		$prompt_file_descriptor =  $prompt_to_accounts__VTO->field__prompt_file_descriptor;
		$prompt_filename = $prompt_file_descriptor["name"];

		
		
		
		
		$idAccounts = $prompt_to_accounts__VTO->field__idAccounts;
		
		$prompts_repo = $this->get_repository_by_business_entity_name("prompt");
		
		require_once REALPATH ."/business_entities/prompt.BE.php";

		foreach($idAccounts as $idAccount){
			$name = $prompt_to_accounts__VTO->field__name;
			$description = $prompt_to_accounts__VTO->field__description;			
			$prompt = prompt__BE::create_from_record(array("name"=>$name, "description"=>$description, "prompt"=>$prompt_filename, "idAccount"=>$idAccount));
			$prompts_repo->_store($prompt);
		}
		
		
		
		
		
	}

}