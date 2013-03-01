<?php

require_once __DIR__ ."/base.REPO.php";

require_once __DIR__ ."/IREPO.php";

class role__REPO extends base__REPO {	
	
	public function __construct($a_business_entity){
		parent::__construct($a_business_entity);		
		$this->business_entity = "accountrole";
	}
	
	public function get_by_id($a_business_entity_id){
		
		$ret_val = null;

		$record = parent::get_record_by_id($a_business_entity_id);
		
		require_once REALPATH ."/business_entities/role.BE.php";
		
		$instance =  role__BE::create_from_record($record);
		
		$ret_val = $instance;
		
		return $ret_val;
		
	}
	
	public function all__get(){
		
		$records = array(
			array("id"=>"1", "name"=>"account1")
			,array("id"=>"2", "name"=>"account 2")
		);
		
		$role_dao = $this->get_default_dao_by_table_name($this->business_entity);
		
		$records = $role_dao->get_all();
		
		require_once REALPATH ."/business_entities/role.BE.php";
		
		$ret_val = array();
		
		foreach($records as $record){			
			$role_instance = role__BE::create_from_record($record);
			$ret_val[] = $role_instance;
			
		}
		
		return $ret_val;
		
		
		
	}
	
	
	
	
	

}
