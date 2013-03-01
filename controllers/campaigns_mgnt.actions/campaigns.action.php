<?php
require_once REALPATH .'/controllers/base.action.php';

class campaignsAction extends baseAction {
	
	public function execute($a_command){
		
		$campaigns_repo = $this->get_repository_by_business_entity_name("campaign");
		
		$all_campaigns= $campaigns_repo->all__get();
		
		$a_command->set_parameter("campaigns", $all_campaigns);
		

	}

}