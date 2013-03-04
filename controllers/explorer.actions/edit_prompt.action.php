<?php


class edit_promptAction {
	
	public function execute($a_command){
		require_once REALPATH ."/repositories/repository.FACTORY.php";
		
		$selected = $_POST['selected'];
		
		$no_selected_alias = !isset($selected);
		if($no_selected_alias){
			return;
		}
		
		$prompt_id_to_edit = $selected[0];

		
		$repo_factory = new repository__FACTORY();
		
		$prompt_repo = $repo_factory->get_repository_by_business_entity_name("prompt");
		
		$prompt = $prompt_repo->get_by_id($prompt_id_to_edit);

		
		$a_command->set_parameter("prompt",$prompt);
		
		
		$accounts_repo = $repo_factory->get_repository_by_business_entity_name("account");
		
		$all_account = $accounts_repo->all__get();
		
		$a_command->set_parameter("accounts",$all_account);		
	}

}