<?php

require_once __DIR__ . "/base.BE.php";

class campaign__BE extends base__BE {

	protected $idCampaign;
	protected $name;
	protected $startDate;
	protected $endDate;
	protected $status;

	protected function __construct($a_fields_array) {
		parent::__construct($a_fields_array);
	}

	public static function create_from_record($a_business_entity_record) {
		$ret_val = null;

		$instance = new campaign__BE($a_business_entity_record);
		//$instance = parent::create_from_record($a_business_entity_record);

		foreach ($a_business_entity_record as $field_name => $field_value) {
			$instance->$field_name = $field_value;
		}

		//$instance->fields = $a_business_entity_record;

		$ret_val = $instance;

		return $ret_val;
	}

	public static function create_from_POST_array($a_post_array){
		
		$data = parent::POST_array__prepare($a_post_array);
		
		$instance = new campaign__BE($data);

		foreach($data as $field_name=>$field_value){
			//$instance->$field_name = $field_value;
			$instance->_set($field_name, $field_value);
		}
		
		//$instance->fields = $a_business_entity_record;
		
		$ret_val = $instance;
		
		return $ret_val;
	}
	
	/*
	  protected function name__get(){
	  return  "name=" .$this->name;
	  }

	 */
	/*
	  protected function name__set($a_value){
	  $this->name = $a_value;
	  }
	 */
	
	protected function startDate__get(){
		return $this->startDate;
	}
	
	protected function startDate__set($a_value){
		if(is_string($a_value)){
			$this->startDate = new DateTime($a_value);
		}else if(is_a($a_value, "DateTime")){
			$this->startDate= $a_value;
		}else if(is_integer($a_value)){
			$dt = new DateTime(); 
			$dt->setTimestamp($a_value);
			$this->startDate = $dt;
		}
		
		$status= $this->compute_status($this->startDate, $this->endDate);
		$this->status = $status; 
	}
	
	protected function endDate__get(){
		return $this->endDate;
	}
	protected function endDate__set($a_value){
		if(is_string($a_value)){
			$this->endDate = new DateTime($a_value);
		}else if(is_a($a_value, "DateTime")){
			$this->endDate= $a_value;
		}else if(is_integer($a_value)){
			$dt = new DateTime(); 
			$dt->setTimestamp($a_value);
			$this->endDate = $dt;
		}

		$status= $this->compute_status($this->startDate, $this->endDate);
		$this->status = $status; 		
	}
	
	private function compute_status($a_startDate, $a_endDate){
		$ret_val = null;
		
		$dataToday_String = date("Y-m-d G:i:s");
		$dataToday = new DateTime($dataToday_String);
		

		
		if ($dataToday > $a_endDate){
			$ret_val=0;
		}elseif ($dataToday < $a_startDate){
			$ret_val=2;
		}  else {
			$ret_val=1;
		}
		
		return $ret_val; 
	}
}
