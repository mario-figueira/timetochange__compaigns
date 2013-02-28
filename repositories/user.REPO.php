<?php

require_once __DIR__ ."/base.REPO.php";

require_once __DIR__ ."/IREPO.php";

class user__REPO extends base__REPO {	
	
	public function __construct($a_business_entity){
		parent::__construct($a_business_entity);		
	}
	
	public function get_by_id($a_business_entity_id){
		
		$ret_val = null;

		$record = parent::get_record_by_id($a_business_entity_id);
		
		require_once REALPATH ."/business_entities/user.BE.php";
		
		$instance =  user__BE::create_from_record($record);
		
		$ret_val = $instance;
		
		return $ret_val;
		
	}
	
	public function all__get(){
		
		$records = array(
			array("id"=>"1", "name"=>"account1")
			,array("id"=>"2", "name"=>"account 2")
		);
		
		$user_dao = $this->get_default_dao_by_table_name("user");
		
		$records = $user_dao->get_all();
		
		require_once REALPATH ."/business_entities/user.BE.php";
		
		$ret_val = array();
		
		foreach($records as $record){			
			$user_instance = user__BE::create_from_record($record);
			$ret_val[] = $user_instance;
			
		}
		
		return $ret_val;
		
		
		
	}
	
	
	
	
	

}
