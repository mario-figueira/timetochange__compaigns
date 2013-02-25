<?php

require_once "base.REPO.php";

class default__REPO extends base__REPO{
	
	public $business_entity;
	
	public function __construct($a_business_entity){
		$this->business_entity	 = $a_business_entity;
	}
	
	public function get_by_id($a_business_entity_id){
		
		$ret_val = null;

		$zrepo_record = parent::get_record_by_id($a_business_entity_id);
		
		require_once REALPATH ."/business_entities/base.BE.php";
		
		$zrepo_instance = base__BE::create_from_record($zrepo_record);
		
		$ret_val = $zrepo_instance;
		
		return $ret_val;
		
	}
	
	
	
	
}
