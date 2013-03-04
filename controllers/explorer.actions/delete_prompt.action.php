<?php


class delete_promptAction {
	
	public function execute($a_command){
		require_once REALPATH ."/repositories/repository.FACTORY.php";
		
		
		$selected = $_POST['selected'];
		
		$no_selected_alias = !isset($selected);
		if($no_selected_alias){
			return;
		}
		
		$repo_factory = new repository__FACTORY();
		$prompt_repo = $repo_factory->get_repository_by_business_entity_name("prompt");
		
		
		foreach($selected as $prompt_id){
			$prompt_repo->remove_by_id($prompt_id);
		}
		
		
	}

}