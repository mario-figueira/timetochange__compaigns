<?php

require_once __DIR__ ."/base.REPO.php";

require_once __DIR__ ."/IREPO.php";

class campaign__REPO extends base__REPO {	
	
	public function __construct($a_business_entity){
		parent::__construct($a_business_entity);		
	}
	
	public function get_by_id($a_business_entity_id){
		
		$ret_val = null;

		$record = parent::get_record_by_id($a_business_entity_id);
		
		require_once REALPATH ."/business_entities/campaign.BE.php";
		
		$instance =  campaign__BE::create_from_record($record);
		
		$ret_val = $instance;
		
		return $ret_val;
		
	}
	
	public function all__get(){
				
		$campaign_dao = $this->get_default_dao_by_table_name("campaign");
		
		$records = $campaign_dao->get_all();
		
		require_once REALPATH ."/business_entities/campaign.BE.php";
		
		$ret_val = array();
		
		foreach($records as $record){
			$ret_val[] = campaign__BE::create_from_record($record);
		}
		
		return $ret_val;
		
		
		
	}
	
	
	public function alias_of_campaign__get_by_campaign($a_campaign){
		$ret_val = array();
		
		$campaignalias_dao = $this->get_default_dao_by_table_name("campaignaliases");
		
		$campaign_id = $a_campaign->id;
		$campaign_aliases_records = $campaignalias_dao->get_records_by_filter(array("idCampaign"=>$campaign_id));

		require_once REALPATH ."/repositories/repository.FACTORY.php";
		$repo_factory = new repository__FACTORY();
		
		$alias_repo = $repo_factory->get_repository_by_business_entity_name("alias");
		//$prompt_function_repo = $repo_factory->get_repository_by_business_entity_name("prompt_function");

		require_once REALPATH ."/value_objects/campaign_alias.VO.php";
		$campaign_aliases = array();
		foreach ($campaign_aliases_records as $campaign_alias_record){
			$alias = $campaign_alias_record['alias'];
			//$alias = $alias_repo->get_by_id($alias_id);

			
			$campaign_alias = campaign_alias__VO::create($campaign_alias_record, $a_campaign, $alias);
			
			$campaign_aliases[] = $campaign_alias;
		}
		
		$ret_val = $campaign_aliases;
		
		return $ret_val;
	}	
	

}
