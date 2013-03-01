<?php
require_once REALPATH .'/controllers/base.action.php';

class save_campaignAction extends baseAction {
	
	public function execute($a_command){
		
		require_once REALPATH .'/business_entities/campaign.BE.php';
		
		$campaign = campaign__BE::create_from_POST_array($_POST);
		
		$validation_result = $campaign->is_valid();
		$is_valid=$validation_result['is_valid'];
		
		if (!$is_valid){
			throw new Exception ('tás maluco');
		}
		
		
		$campaigns_repo = $this->get_repository_by_business_entity_name("campaign");
		
		$campaigns_repo->_store($campaign);
	}

}