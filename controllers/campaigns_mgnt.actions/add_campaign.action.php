<?php
require_once REALPATH .'/controllers/base.action.php';

class add_campaignAction extends baseAction {
	
	public function execute($a_command){
		
		
		$type_campaign_repo = $this->get_repository_by_business_entity_name("campaigntype");
		
		$all_type_campaign = $type_campaign_repo->all__get();
		
		$a_command->set_parameter("campaigntypes",$all_type_campaign);
		
	}

}