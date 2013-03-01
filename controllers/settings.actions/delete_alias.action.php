<?php


class delete_aliasAction {
	
	public function execute($a_command){
		require_once REALPATH ."/repositories/repository.FACTORY.php";
		
		
		$selected = $_POST['selected'];
		
		$no_selected_alias = !isset($selected);
		if($no_selected_alias){
			return;
		}
		
		$repo_factory = new repository__FACTORY();
		$alias_repo = $repo_factory->get_repository_by_business_entity_name("alias");
		
		
		foreach($selected as $alias_id){
			$alias_repo->remove_by_id($alias_id);
		}
		
		
	}

}