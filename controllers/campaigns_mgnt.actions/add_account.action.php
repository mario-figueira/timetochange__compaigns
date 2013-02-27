<?php


class add_accountAction {
	
	public function execute($a_command){
		require_once REALPATH ."/repositories/repository.FACTORY.php";
		
		$repo_factory = new repository__FACTORY();
		
		$countries_repo = $repo_factory->get_repository_by_business_entity_name("country");
		
		$all_countries = $countries_repo->all__get();
		
		$a_command->set_parameter("countries",$all_countries);
		
	}

}