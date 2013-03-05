<?php
require_once REALPATH .'/controllers/base.action.php';

class edit_campaignAction extends baseAction {
	
	public function execute($a_command){
		
		$selected = $_POST['selected'];
		
		$no_selected_accounts = !isset($selected);
		if($no_selected_accounts){
			return;
		}
		
		$campaign_id_to_edit = $selected[0];

		
		
		$campaigns_repo = $this->get_repository_by_business_entity_name("campaign");
		
		$campaign = $campaigns_repo->get_by_id($campaign_id_to_edit);

		
		$a_command->set_parameter("campaign",$campaign);
		
		
		
		$type_campaign_repo = $this->get_repository_by_business_entity_name("campaigntype");
		
		$all_type_campaign = $type_campaign_repo->all__get();
		
		$a_command->set_parameter("campaigntypes",$all_type_campaign);
		
		require_once REALPATH ."/repositories/repository.FACTORY.php";
		
		$repo_factory = new repository__FACTORY();
		
		$accounts_repo = $repo_factory->get_repository_by_business_entity_name("account");
		
		$all_account = $accounts_repo->all__get();
		
		$a_command->set_parameter("accounts",$all_account);
	}

}