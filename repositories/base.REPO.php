<?php



abstract class base__REPO {
	
	public $business_entity;
	
	public function __construct($a_business_entity_name){
		$this->business_entity	 = $a_business_entity_name;
	}

	
	protected function get_default_dao_by_table_name($a_table_name){
		$ret_val = null;
		
		$default_dao = null;
		
		require_once REALPATH . 'model/default.model.php';
		
		$default_model = new defaultModel($a_table_name);
		
		$default_dao = $default_model;
		
		$ret_val = $default_dao;
		
		return $default_dao;
		

	}

	protected function get_record_by_id($a_business_entity_id){
		
		$ret_val = null;
		
		$business_entity_table_record = null;
		
		$dao = $this->get_default_dao_by_table_name($this->business_entity);
		
		$business_entity_table_record = $dao->getById($a_business_entity_id);
		
		$ret_val = $business_entity_table_record;
		
		return $ret_val;
		
	}
	
	protected function get_records_by_filter($a_filter){
		
		$ret_val = null;
		
		$business_entity_table_record = null;
		
		$dao = $this->get_default_dao_by_table_name($this->business_entity);
		
		$business_entity_table_record = $dao->getFilteredBy($a_filter, true);
		
		$ret_val = $business_entity_table_record;
		
		return $ret_val;
	}
	
	
	public abstract function get_by_id($a_business_entity_id);

	public function _store($a_business_entity_instance){
		$dao = $this->get_default_dao_by_table_name($this->business_entity);
		
		$business_entity_id = $a_business_entity_instance->id;
		
		$business_entity_table_record = $dao->getById($business_entity_id);
		
		$business_entity_record_exists = isset($business_entity_table_record);
		
		$business_entity_field_array = $a_business_entity_instance->_get_fields_array();
		
		$store_call_res = null;
		if($business_entity_record_exists){
			$dao->update_by_id($business_entity_id, $business_entity_field_array);
		}
		else{
			$new_id = $dao->persist($business_entity_field_array);
		}
	}

	public function remove($a_business_entity_instance){
		$dao = $this->get_default_dao_by_business_entity($this->business_entity);
		
		$business_entity_id = $a_business_entity_instance->id;
		
		$dao->deleteById($business_entity_id);
		
	}
	
	public function remove_by_id($a_business_entity_id){
		$dao = $this->get_default_dao_by_table_name($this->business_entity);
		
		$dao->deleteById($a_business_entity_id);
		
	}
	
	
}
