<?php


class edit_aliasAction {
	
	public function execute($a_command){
		require_once REALPATH ."/repositories/repository.FACTORY.php";
		
		$selected = $_POST['selected'];
		
		$no_selected_alias = !isset($selected);
		if($no_selected_alias){
			return;
		}
		
		$alias_id_to_edit = $selected[0];

		
		$repo_factory = new repository__FACTORY();
		
		$alias_repo = $repo_factory->get_repository_by_business_entity_name("alias");
		
		$alias = $alias_repo->get_by_id($alias_id_to_edit);

		
		$a_command->set_parameter("alias",$alias);
		
		
				
	}

}