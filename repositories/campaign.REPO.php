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
		
		$instance =  campaign::create_from_record($record);
		
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
	
	

}
