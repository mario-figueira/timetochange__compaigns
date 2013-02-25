<?php

require_once 'config/sysvars.php';

require_once 'util/DBCHelpingV2/kinds_of_values.php';
require_once 'util/DBCHelpingV2/DBCHelper_Exception.php';


class kind_of_constraint {

	private $kind_of_value = null;

	public function __construct(
		kind_of_value $a_kind_of_value
	) {
		$this->kind_of_value = $a_kind_of_value;
	}

	public function is_a_boolean() {
		if(ASSERTION_LEVEL==0){return new kind_of_value(new kind_of_assertion(0,''));}
		
		DBCHelper2::require_that()->the_param($this->kind_of_value->value)->is_not_null();

		$value = $this->kind_of_value->value;
		$assertion_evaluation = is_bool($value);

		if (!$assertion_evaluation) {
			$var_name = ""; //TODO: do it
			$msg = $var_name . ' must be a boolean value.';
			$msg = $this->kind_of_value->kind_of_value_message_part . $msg;
			throw new Exception($msg, 1, null);
		}

		return $this->kind_of_value->clone_it();
	}
	
	public function is_true() {
		if(ASSERTION_LEVEL==0){return new kind_of_value(new kind_of_assertion(0,''));} 

		$assertion_evaluation = ($this->kind_of_value->value == true);

		if (!$assertion_evaluation) {
			$msg = 'the assertion must be true.';
			$msg = $this->kind_of_value->kind_of_value_message_part . $msg;
			throw new Exception($msg, 1, null);
		}

		return $this->kind_of_value->clone_it();
	}

	public function is_false() {
		if(ASSERTION_LEVEL==0){return new kind_of_value(new kind_of_assertion(0,''));} 

		$assertion_evaluation = ($this->kind_of_value->value == false);

		if (!$assertion_evaluation) {
			$msg = 'the assertion must be false.';
			$msg = $this->kind_of_value->kind_of_value_message_part . $msg;
			throw new Exception($msg, 1, null);
		}

		return $this->kind_of_value->clone_it();
	}

	public function is_not_null() {
		if(ASSERTION_LEVEL==0){return new kind_of_value(new kind_of_assertion(0,''));} 

		$assertion_evaluation = isset($this->kind_of_value->value);

		if (!$assertion_evaluation) {
			$var_name = ""; //TODO: do it
			$msg = $var_name . ' cannot be null.';
			$msg = $this->kind_of_value->kind_of_value_message_part . $msg;
			throw new Exception($msg, 1, null);
		}

		return $this->kind_of_value->clone_it();
	}

	public function is_a_number() {
		if(ASSERTION_LEVEL==0){return new kind_of_value(new kind_of_assertion(0,''));} 

		DBCHelper2::require_that()->the_param($this->kind_of_value->value)->is_not_null();

		$value = $this->kind_of_value->value;
		$assertion_evaluation = is_numeric($value);

		if (!$assertion_evaluation) {
			$var_name = ""; //TODO: do it
			$msg = $var_name . ' must be a numeric value.';
			$msg = $this->kind_of_value->kind_of_value_message_part . $msg;
			throw new Exception($msg, 1, null);
		}

		return $this->kind_of_value->clone_it();
	}
	
	/**
	 * @return kind_of_value 
	 */
	public function is_a_string() {
		if(ASSERTION_LEVEL==0){return new kind_of_value(new kind_of_assertion(0,''));} 

		DBCHelper2::require_that()->the_param($this->kind_of_value->value)->is_not_null();
		
		$value = $this->kind_of_value->value;
		$assertion_evaluation = is_string($value);

		if (!$assertion_evaluation) {
			$var_name = ""; //TODO: do it
			$msg = $var_name . ' must be a numeric value.';
			$msg = $this->kind_of_value->kind_of_value_message_part . $msg;
			throw new Exception($msg, 1, null);
		}

		return $this->kind_of_value->clone_it();
	}
	
	/**
	 * @return kind_of_value 
	 */
	public function is_callable__NOT_WORKING() {
		if(ASSERTION_LEVEL==0){return new kind_of_value(new kind_of_assertion(0,''));} 

		DBCHelper2::require_that()->the_param($this->kind_of_value->value)->is_an_array_with_n_elements(2);
		
		$value = $this->kind_of_value->value;
		$assertion_evaluation = is_callable($value);

		if (!$assertion_evaluation) {
			$var_name = ""; //TODO: do it
			$msg = $var_name . ' must be a callable function.';
			$msg = $this->kind_of_value->kind_of_value_message_part . $msg;
			throw new Exception($msg, 1, null);
		}

		return $this->kind_of_value->clone_it();
	}


//	public function is_a_number_between($a_lower_limit, $a_upper_limit, $a_closed_lower_limit=true, $a_closed_upper_limit=true) {
//		DBCHelper2::require_that()->the_param($this->kind_of_value->value)->is_a_number();
//
//		$value = $this->kind_of_value->value;
//		//$assertion_evaluation = $value > ;	
//
//		if (!$assertion_evaluation) {
//			$msg = $var_name . ' must be a numeric value.';
//			$msg = $this->kind_of_value->kind_of_value_message_part . $msg;
//			throw new Exception($msg, 1, null);
//		}
//
//		return $this->kind_of_value->clone_it();		
//	}	

	public function is_an_integer_string() {
		if(ASSERTION_LEVEL==0){return new kind_of_value(new kind_of_assertion(0,''));} 

		DBCHelper2::require_that()->the_class_field($this->kind_of_value->value)->is_a_number();

		//$var_name = DBCHelper::print_var_name($this->$a_kind_of_value);

		$assertion_evaluation = false;
		try {
			$aux = (int) $this->kind_of_value->value;
			$assertion_evaluation = true;
		} catch (Exception $ex) {
			//nothing to do, swollow it
		}

		if (!$assertion_evaluation) {
			$var_name = ""; //TODO: do it
			$msg = $this->kind_of_value->kind_of_value_message_part . $var_name . ' must be an integer string.';
			throw new Exception($msg, 1, null);
		}

		return $this->kind_of_value->clone_it();
	}

	public function is_an_array() {
		if(ASSERTION_LEVEL==0){return new kind_of_constraint(new kind_of_value(new kind_of_assertion(0,'')));}
		
		DBCHelper2::require_that()->the_param($this->kind_of_value->value)->is_not_null();

		$value = $this->kind_of_value->value;
		$assertion_evaluation = is_array($value);

		if (!$assertion_evaluation) {
			$var_name = ""; //TODO: do it
			$msg = $var_name . ' must be an array.';
			$msg = $this->kind_of_value->kind_of_value_message_part . $msg;
			throw new Exception($msg, 1, null);
		}

		return $this->kind_of_value->clone_it();
	}

	public function is_an_empty_array() {
		if(ASSERTION_LEVEL==0){return new kind_of_value(new kind_of_assertion(0,''));} 

		DBCHelper2::require_that()->the_param($this->kind_of_value->value)->is_an_array();

		$value = $this->kind_of_value->value;
		$assertion_evaluation = (count($value) == 0);

		if (!$assertion_evaluation) {
			$var_name = ""; //TODO: do it
			$msg = $var_name . ' must be an empty array.';
			$msg = $this->kind_of_value->kind_of_value_message_part . $msg;
			throw new Exception($msg, 1, null);
		}

		return $this->kind_of_value->clone_it();
	}

	public function is_an_array_with_at_least_one_element() {
		if(ASSERTION_LEVEL==0){return new kind_of_value(new kind_of_assertion(0,''));} 

		DBCHelper2::require_that()->the_param($this->kind_of_value->value)->is_an_array();

		$value = $this->kind_of_value->value;
		$assertion_evaluation = (count($value) != 0);

		if (!$assertion_evaluation) {
			$var_name = ""; //TODO: do it
			$msg = $var_name . ' must be an array with at least one element.';
			$msg = $this->kind_of_value->kind_of_value_message_part . $msg;
			throw new Exception($msg, 1, null);
		}

		return $this->kind_of_value->clone_it();
	}
	
	public function is_an_array_with_n_elements($a_qty_of_elements) {
		if(ASSERTION_LEVEL==0){return new kind_of_value(new kind_of_assertion(0,''));} 

		DBCHelper2::require_that()->the_param($this->kind_of_value->value)->is_an_array();

		$value = $this->kind_of_value->value;
		$assertion_evaluation = (count($value) == $a_qty_of_elements);

		if (!$assertion_evaluation) {
			$var_name = ""; //TODO: do it
			$msg = $var_name . ' must be an array with at least one element.';
			$msg = $this->kind_of_value->kind_of_value_message_part . $msg;
			throw new Exception($msg, 1, null);
		}

		return $this->kind_of_value->clone_it();
	}

	public function is_an_array_with_just_one_element() {
		if(ASSERTION_LEVEL==0){return new kind_of_value(new kind_of_assertion(0,''));} 

		DBCHelper2::require_that()->the_param($this->kind_of_value->value)->is_an_array();

		$value = $this->kind_of_value->value;
		$assertion_evaluation = (count($value) == 1);

		if (!$assertion_evaluation) {
			$var_name = ""; //TODO: do it
			$msg = $var_name . ' must be an array with just one element.';
			$msg = $this->kind_of_value->kind_of_value_message_part . $msg;
			throw new Exception($msg, 1, null);
		}

		return $this->kind_of_value->clone_it();
	}

	public function is_an_array_with_at_most_n_elements($a_maximum) {
		if(ASSERTION_LEVEL==0){return new kind_of_value(new kind_of_assertion(0,''));} 

		DBCHelper2::require_that()->the_param($this->kind_of_value->value)->is_an_array();

		$value = $this->kind_of_value->value;
		$assertion_evaluation = (count($value) <= $a_maximum);

		if (!$assertion_evaluation) {
			$var_name = ""; //TODO: do it
			$msg = $var_name . " must be an array with at most $a_maximum elements.";
			$msg = $this->kind_of_value->kind_of_value_message_part . $msg;
			throw new DBCHelper_Exception($msg, 1, null);
		}

		return $this->kind_of_value->clone_it();
	}
	
	public function is_an_object_instance_of_the_class($a_class_name) {
		if(ASSERTION_LEVEL==0){return new kind_of_value(new kind_of_assertion(0,''));} 

		DBCHelper2::require_that()->the_param($a_class_name)->is_a_string();
		DBCHelper2::require_that()->the_param($this->kind_of_value->value)->is_not_null();

		$value = $this->kind_of_value->value;
		$assertion_evaluation = ($value instanceof $a_class_name);

		if (!$assertion_evaluation) {
			$var_name = ""; //TODO: do it
			$msg = $var_name . " must be an instance of the class '$a_class_name'.";
			$msg = $this->kind_of_value->kind_of_value_message_part . $msg;
			throw new DBCHelper_Exception($msg, 1, null);
		}

		return $this->kind_of_value->clone_it();
	}
	
	public function exists() {
		if(ASSERTION_LEVEL==0){return new kind_of_value(new kind_of_assertion(0,''));} 

		DBCHelper2::require_that()->the_param($this->kind_of_value->value)->is_a_string();
		DBCHelper2::require_that()->the_assertion	(
								$this->kind_of_value->type=="FILE" 
								|| $this->kind_of_value->type=="FILE_FOLDER" 
								|| $this->kind_of_value->type=="PHP_CLASS" 
									)->is_true();
		$value_type = $this->kind_of_value->type;
		$value = $this->kind_of_value->value;
		
		$assertion_evaluation  = false;
		switch ($value_type) {
			case "PHP_CLASS":
				$assertion_evaluation = class_exists($value);
				break;
			case "FILE":
				$assertion_evaluation = file_exists($value);
				break;
			case "FILE_FOLDER":
				$assertion_evaluation = file_exists($value);
				break;
			default:
				throw new DBCHelper_Exception($this, 2, $msg);
				break;
		}

		if (!$assertion_evaluation) {
			$var_name = ""; //TODO: do it
			$msg = $var_name . ' must exists.';
			$kind_of_value = $this->kind_of_value;
			$msg = $this->kind_of_value->kind_of_value_message_part . $msg;
			throw new DBCHelper_Exception($this, 1, $msg);
		}

		return $this->kind_of_value->clone_it();
	}
}


?>