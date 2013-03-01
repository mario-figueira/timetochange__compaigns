<?php
require_once REALPATH .'/controllers/base.action.php';

class add_accountAction extends baseAction {
	
	public function execute($a_command){
		
		
		$countries_repo = $this->get_repository_by_business_entity_name("country");
		
		$all_countries = $countries_repo->all__get();
		
		$a_command->set_parameter("countries",$all_countries);
		
	}

}