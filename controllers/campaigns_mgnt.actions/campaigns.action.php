<?php


class campaignsAction {
	
	public function execute($a_command){
		require_once REALPATH ."/repositories/repository.FACTORY.php";
		
		$repo_factory = new repository__FACTORY();
		
		$campaigns_repo = $repo_factory->get_repository_by_business_entity_name("campaign");
		
		$all_campaigns= $campaigns_repo->all__get();
		
		$a_command->set_parameter("campaigns", $all_campaigns);
		

	}

}