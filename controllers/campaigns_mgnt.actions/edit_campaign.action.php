<?php


class edit_campaignAction {
	
	public function execute($a_command){
		require_once REALPATH ."/repositories/repository.FACTORY.php";
		
		$selected = $_POST['selected'];
		
		$no_selected_accounts = !isset($selected);
		if($no_selected_accounts){
			return;
		}
		
		$campaign_id_to_edit = $selected[0];

		
		$repo_factory = new repository__FACTORY();
		
		$campaigns_repo = $repo_factory->get_repository_by_business_entity_name("campaign");
		
		$campaign = $campaigns_repo->get_by_id($campaign_id_to_edit);

		
		$a_command->set_parameter("campaign",$campaign);
		
		
		$repo_factory = new repository__FACTORY();
		
		$type_campaign_repo = $repo_factory->get_repository_by_business_entity_name("campaigntype");
		
		$all_type_campaign = $type_campaign_repo->all__get();
		
		$a_command->set_parameter("campaigntypes",$all_type_campaign);
				
	}

}