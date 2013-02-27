<?php

require_once __DIR__ ."/base.REPO.php";

require_once __DIR__ ."/IREPO.php";

class country__REPO extends base__REPO {	
	
	public function __construct($a_business_entity){
		parent::__construct($a_business_entity);		
	}
	
	public function get_by_id($a_business_entity_id){
		
		$ret_val = null;

		$record = parent::get_record_by_id($a_business_entity_id);
		
		require_once REALPATH ."/business_entities/country.BE.php";
		
		$instance =  account::create_from_record($record);
		
		$ret_val = $instance;
		
		return $ret_val;
		
	}
	
	public function all__get(){
		
		$account_dao = $this->get_default_dao_by_table_name("country");
		
		$records = $account_dao->get_all();
		
		require_once REALPATH ."/business_entities/country.BE.php";
		
		$ret_val = array();
		
		foreach($records as $record){
			$ret_val[] = country__BE::create_from_record($record);
		}
		
		return $ret_val;
		
		
		
	}
	
	

}
