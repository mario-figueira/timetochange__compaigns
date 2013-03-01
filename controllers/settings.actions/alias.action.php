<?php


class aliasAction {
	
	public function execute($a_command){
		require_once REALPATH ."/repositories/repository.FACTORY.php";
		
		$repo_factory = new repository__FACTORY();
		
		$alias_repo = $repo_factory->get_repository_by_business_entity_name("alias");
		
		$all_alias = $alias_repo->all__get();
		
		$a_command->set_parameter("alias", $all_alias);
	}

}