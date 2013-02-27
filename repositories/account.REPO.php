<?php

require_once __DIR__ ."/base.REPO.php";

require_once __DIR__ ."/IREPO.php";

class account__REPO extends base__REPO {	
	
	public function __construct($a_business_entity){
		parent::__construct($a_business_entity);		
	}
	
	public function get_by_id($a_business_entity_id){
		
		$ret_val = null;

		$record = parent::get_record_by_id($a_business_entity_id);
		
		require_once REALPATH ."/business_entities/account.BE.php";
		
		$instance =  account::create_from_record($record);
		
		$ret_val = $instance;
		
		return $ret_val;
		
	}
	
	public function all__get(){
		
		$records = array(
			array("id"=>"1", "name"=>"account1")
			,array("id"=>"2", "name"=>"account 2")
		);
		
		$account_dao = $this->get_default_dao_by_table_name("account");
		
		$records = $account_dao->get_all();
		
		require_once REALPATH ."/business_entities/account.BE.php";
		
		$ret_val = array();
		
		foreach($records as $record){			
			$account_instance = account__BE::create_from_record($record);
			$ret_val[] = $account_instance;
			
		}
		
		return $ret_val;
		
		
		
	}
	
	

}
