<?php
require_once REALPATH .'/controllers/base.action.php';

class campaign_aliasesAction extends baseAction {
	
	public function execute($a_command){
		
		$idCampaign = $a_command->get_variable_from_context("idCampaign", null);
		
		$idCampaign_was_passed = isset($idCampaign);
		
		$campaign_id_to_show_users = null;
		if($idCampaign_was_passed){
			$campaign_id_to_show_users = $idCampaign;
		}
		else{
			$selected = $_POST['selected'];

			$no_selected_campaigns = !isset($selected);
			if($no_selected_campaigns){
				return;
			}
			
			$campaign_id_to_show_users = $selected[0];
		}
		

		
		
		
		$campaigns_repo = $this->get_repository_by_business_entity_name("campaign");
		
		$campaign = $campaigns_repo->get_by_id($campaign_id_to_show_users);
		
		
		$campaign_aliases = $campaigns_repo->alias_of_campaign__get_by_campaign($campaign);
		
		$a_command->set_parameter("campaign", $campaign);
		$a_command->set_parameter("campaign_aliases", $campaign_aliases);
		
	}

}