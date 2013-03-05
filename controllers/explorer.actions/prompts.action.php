<?php


class promptsAction {
	
	public function execute($a_command){
		require_once REALPATH ."/repositories/repository.FACTORY.php";
		
		$repo_factory = new repository__FACTORY();
		
		$prompt_repo = $repo_factory->get_repository_by_business_entity_name("prompt");
		
		$all_prompts = $prompt_repo->all__get();
		
		$a_command->set_parameter("prompts", $all_prompts);
	}

}