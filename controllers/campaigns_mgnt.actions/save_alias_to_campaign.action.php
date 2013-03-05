<?php
require_once REALPATH .'/controllers/base.action.php';



class save_alias_to_campaignAction extends baseAction {
	
	public function execute($a_command){
		
		//$a_command->get_variable_from_context();
		
		require_once REALPATH .'/data_transfer_objects/add_alias_to_campaign.VTO.php';
		$add_alias_to_campaign__VTO = add_alias_to_campaign__VTO::create_from_POST_array($_POST);

		
		require_once REALPATH .'/enums/prompt_function_enum.php';


		$idCampaign = $add_alias_to_campaign__VTO->field__idCampaign;
		//$alias = $add_alias_to_campaign__VTO->field__alias;
		$alias_repo = $this->get_repository_by_business_entity_name("alias");		
		$alias_object = $alias_repo->get_by_id($add_alias_to_campaign__VTO->field__idAlias);
		$alias = $alias_object->alias;
		$idPromptIn = $add_alias_to_campaign__VTO->field__idPromptIn;
		$idPromptOut = $add_alias_to_campaign__VTO->field__idPromptOut;
		
		$prompt_repo = $this->get_repository_by_business_entity_name("prompt");

		$promptIn = $prompt_repo->get_by_id($idPromptIn);
		$promptInPrompt = $promptIn->prompt;
		$promptOut = $prompt_repo->get_by_id($idPromptOut);
		$promptOutPrompt = $promptOut->prompt;
		// grab the campaign from the database	
		$campaign_repo = $this->get_repository_by_business_entity_name("campaign");
		//$campaign = $campaign_repo->get_by_id($campaign_id);

		//grab the alias entity				
		//$alias_repo = $this->get_repository_by_business_entity_name("alias");		
		//$alias_id = $alias_repo->_store($alias);
		
		
		// grab the prompt function from the database
		//$prompt_function_repo = $this->get_repository_by_business_entity_name("prompttype");		
		//$prompt_function_in = $prompt_function_repo->get_by_id(prompt_function_enum::$C_ENTRADA);
		//$prompt_function_out = $prompt_function_repo->get_by_id(prompt_function_enum::$C_SAIDA);

		
		$idCampaignAlias = $campaign_repo->add_alias_to_campaign($alias, $idCampaign);
		
		$idPromptAlias = $campaign_repo->add_prompt_function_to_campaign_alias($idCampaignAlias, $promptInPrompt, prompt_function_enum::$C_ENTRADA);

		//$call_ret = $campaign_repo->add_alias_to_campaign($alias, $idCampaign);
		//$idCampaignAlias = $call_ret['id'];
		$idPromptAlias = $campaign_repo->add_prompt_function_to_campaign_alias($idCampaignAlias, $promptOutPrompt, prompt_function_enum::$C_SAIDA);


		

		

		
	}

}