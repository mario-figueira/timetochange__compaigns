<?php

require_once 'config/sysvars.php';



class DBCHelper_Exception extends Exception{
	public $kind_of_constraint = null;
	public function __construct(
		$a_kind_of_constraint
		, $a_code
		, $a_message
	){
		parent::__construct($a_message, $a_code, null);
		$this->kind_of_constraint = $a_kind_of_constraint;
	}
}

?>