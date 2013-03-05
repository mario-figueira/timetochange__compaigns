<?php
require_once REALPATH .'/controllers/base.action.php';

class add_alias_to_campaignAction extends baseAction {
	
	public function execute($a_command){
		
		$idCampaign = $a_command->get_variable_from_context("idCampaign");
		
		DBCHelper2::require_that()->the_param($idCampaign)->is_an_integer_string();
		

		$campaign_repo = $this->get_repository_by_business_entity_name('campaign');
		$campaign = $campaign_repo->get_by_id($idCampaign);
		
		
		
		$prompt_repo = $this->get_repository_by_business_entity_name("prompt");
		
		$available_prompts = $prompt_repo->all__get();
		
		//$a_command->set_parameter("campaign_prompts",$campaign_prompts);
		

		$idAccount = $campaign->idAccount;
		$account_repo = $this->get_repository_by_business_entity_name('account');
		$account = $account_repo->get_by_id($idAccount);
				
		

		$available_alias = $account_repo->alias_of_account__get_by_account($account);

		
		//$a_command->set_parameter("campaign_alias", $campaign_alias);
		
		/*
		$prompt_function_repo = $this->get_repository_by_business_entity_name("prompt_function");
		
		$prompt_functions = $prompt_function_repo->all__get();
		
		$a_command->set_parameter("prompt_functions",$prompt_functions);
		*/
		
		require_once REALPATH .'/data_transfer_objects/add_alias_to_campaign.VTO.php';
		$vto = new add_alias_to_campaign__VTO();
		$vto->campaign = $campaign;
		$vto->available_aliases = $available_alias;
		$vto->available_prompts = $available_prompts;
		$vto->field__idCampaign = $campaign->id;
		$vto->field__idAlias = null;
		$vto->field__alias = null;
		$vto->field__idPromptIn = null;
		$vto->field__idPromptOut = null;
		$vto->freeze();		
		
		$a_command->set_parameter("vto", $vto);
	}

}