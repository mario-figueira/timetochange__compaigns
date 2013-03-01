<?php
require_once REALPATH .'/controllers/base.action.php';

class delete_campaignAction extends baseAction {
	
	public function execute($a_command){
		
		
		$selected = $_POST['selected'];
		
		$no_selected_accounts = !isset($selected);
		if($no_selected_accounts){
			return;
		}
		
		$accounts_repo = $this->get_repository_by_business_entity_name("campaign");
		
		
		foreach($selected as $campaign_id){
			$accounts_repo->remove_by_id($campaign_id);
		}
		
		
	}

}