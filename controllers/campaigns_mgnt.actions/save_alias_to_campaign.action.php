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

		
		$campaign_repo->add_alias_to_campaign($alias, $idCampaign, $idPromptIn, prompt_function_enum::$C_ENTRADA);
		$campaign_repo->add_alias_to_campaign($alias, $idCampaign, $idPromptOut, prompt_function_enum::$C_SAIDA);

		

		

		
	}

}