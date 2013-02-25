<?php

require_once 'config/sysvars.php';

require_once 'util/DBCHelpingV2/kinds_of_assertions.php';
require_once 'util/DBCHelpingV2/kinds_of_constraints.php';


class kind_of_value {

	private $kind_of_assertion;
	public $value;
	public $kind_of_value_message_part = "";
	public $type;

	public function __construct(
		kind_of_assertion $a_kind_of_assertion
	) {
		if(ASSERTION_LEVEL==0){return;}

		$this->kind_of_assertion = $a_kind_of_assertion;
	}

	/**
	 * @return kind_of_constraint 
	 */
	public function the_assertion($a_value) {
		if(ASSERTION_LEVEL==0){return new kind_of_constraint(new kind_of_value( new kind_of_assertion(0,'')));}
		
		$this->type = "ASSERTION";
		$this->value = $a_value;
		$this->kind_of_value_message_part = $this->kind_of_assertion->assertion_message_part . 'Assertion  ';
		$kind_of_constraint = new kind_of_constraint($this);

		$ret_val = $kind_of_constraint;

		return $ret_val;
	}

	/**
	 * @return kind_of_constraint 
	 */
	public function the_variable($a_value) {
		if(ASSERTION_LEVEL==0){return new kind_of_constraint(new kind_of_value(new kind_of_assertion(0,'')));}
		
		$this->type = "VARIABLE";
		$this->value = $a_value;
		$this->kind_of_value_message_part = $this->kind_of_assertion->assertion_message_part . 'Variable ';
		$kind_of_constraint = new kind_of_constraint($this);

		$ret_val = $kind_of_constraint;

		return $ret_val;
	}

	/**
	 * @return kind_of_constraint 
	 */
	public function the_param($a_value) {
		if(ASSERTION_LEVEL==0){return new kind_of_constraint(new kind_of_value( new kind_of_assertion(0,'')));}
		
		$this->type = "PARAMETER";
		$this->value = $a_value;
		$this->kind_of_value_message_part = $this->kind_of_assertion->assertion_message_part . 'Parameter ';
		$kind_of_constraint = new kind_of_constraint($this);

		$ret_val = $kind_of_constraint;

		return $ret_val;
	}

	/**
	 * @return kind_of_constraint 
	 */
	public function the_return_value($a_value) {
		if(ASSERTION_LEVEL==0){return new kind_of_constraint(new kind_of_value( new kind_of_assertion(0,'')));}
		
		$this->type = "RETURN_VALUE";
		$this->value = $a_value;
		$this->kind_of_value_message_part = $this->kind_of_assertion->assertion_message_part . 'Return value ';
		$kind_of_constraint = new kind_of_constraint($this);

		$ret_val = $kind_of_constraint;

		return $ret_val;
	}

	/**
	 * @return kind_of_constraint 
	 */
	public function the_invariant($a_value) {
		if(ASSERTION_LEVEL==0){return new kind_of_constraint(new kind_of_value( new kind_of_assertion(0,'')));}
		
		$this->type = "INVARIANT";
		$this->value = $a_value;
		$this->kind_of_value_message_part = $this->kind_of_assertion->assertion_message_part . 'Invariant ';
		$kind_of_constraint = new kind_of_constraint($this);

		$ret_val = $kind_of_constraint;

		return $ret_val;
	}
	
	/**
	 * @return kind_of_constraint 
	 */
	public function the_class($a_value) {
		if(ASSERTION_LEVEL==0){return new kind_of_constraint(new kind_of_value( new kind_of_assertion(0,'')));}

		$this->type = "PHP_CLASS";
		$this->value = $a_value;
		$this->kind_of_value_message_part = $this->kind_of_assertion->assertion_message_part . 'Class ';
		$kind_of_constraint = new kind_of_constraint($this);

		$ret_val = $kind_of_constraint;

		return $ret_val;
	}

	/**
	 * @return kind_of_constraint 
	 */
	public function the_class_field($a_value) {
		if(ASSERTION_LEVEL==0){return new kind_of_constraint(new kind_of_value( new kind_of_assertion(0,'')));}

		$this->type = "PHP_CLASS_FIELD";
		$this->value = $a_value;
		$this->kind_of_value_message_part = $this->kind_of_assertion->assertion_message_part . 'Class field ';
		$kind_of_constraint = new kind_of_constraint($this);

		$ret_val = $kind_of_constraint;

		return $ret_val;
	}
	
	
	/**
	 * @return kind_of_constraint 
	 */
	public function the_file($a_value) {
		if(ASSERTION_LEVEL==0){return new kind_of_constraint(new kind_of_value( new kind_of_assertion(0,'')));}

		$this->type = "FILE";
		$this->value = $a_value;
		$this->kind_of_value_message_part = $this->kind_of_assertion->assertion_message_part . 'File ';
		$kind_of_constraint = new kind_of_constraint($this);

		$ret_val = $kind_of_constraint;

		return $ret_val;
	}
	
	/**
	 * @return kind_of_constraint 
	 */
	public function the_file_folder($a_value) {
		if(ASSERTION_LEVEL==0){return new kind_of_constraint(new kind_of_value( new kind_of_assertion(0,'')));}

		$this->type = "FILE_FOLDER";
		$this->value = $a_value;
		$this->kind_of_value_message_part = $this->kind_of_assertion->assertion_message_part . 'File folder ';
		$kind_of_constraint = new kind_of_constraint($this);

		$ret_val = $kind_of_constraint;

		return $ret_val;
	}

	/**
	 * @return kind_of_value 
	 */
	public function clone_it() {
		$ret_val = new kind_of_value($this->kind_of_assertion);
		$ret_val->value = $this->value;
		return $ret_val;
	}

}



?>