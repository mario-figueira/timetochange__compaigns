<?php

require_once __DIR__ ."/base.REPO.php";

require_once __DIR__ ."/IREPO.php";

class ztest__REPO extends base__REPO {	
	
	public function __construct($a_business_entity){
		parent::__construct($a_business_entity);		
	}
	
	public function get_by_id($a_business_entity_id){
		
		$ret_val = null;

		$zrepo_record = parent::get_record_by_id($a_business_entity_id);
		
		require_once REALPATH ."/business_entities/ztest.BE.php";
		
		$zrepo_instance =  ztest__BE::create_from_record($zrepo_record);
		
		$ret_val = $zrepo_instance;
		
		return $ret_val;
		
	}

}
