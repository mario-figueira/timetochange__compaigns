<?php

require_once 'config/sysvars.php';

/**
 * Description of AssertionHelper
 *
 * @author mfigueira
 */
class DBCHelper {

	public $c_assertion_mode__development = 7;
	public $c_assertion_mode__initial_production = 3;
	public $c_assertion_mode__production = 1;
	public $c_assertion_mode__disabled = 0;

	//constructors - begin
	// default constructor
	private function __construct() {
		
	}

	//constructors - end

	public static function Assert__OBSOLET($a_Assertion, $a_ExplanationMsg) {
		if (!$a_Assertion) {
			$msg = "ASSERTION FAILED:" . $a_ExplanationMsg;
			throw new Exception($msg);
		}
	}

	public static function is_null(&$a_Variable) {
		$var_name = ""; //DBCHelper::print_var_name($a_Variable);
		$retVal = new DBCEvaluationTO();
		$retVal->assertion = !isset($a_Variable);
		$retVal->partial_failure_message = $var_name . ' must be null.';

		return $retVal;
	}

	public static function is_not_null(&$a_Variable) {
		$var_name = ""; //DBCHelper::print_var_name($a_Variable);
		$retVal = new DBCEvaluationTO();
		$retVal->assertion = isset($a_Variable);
		$retVal->partial_failure_message = $var_name . ' cannot be null.';

		return $retVal;
	}

	public static function is_an_object_of_the_class(&$a_Variable, $a_class_name) {
		DBCHelper::require_that(DBCHelper::the_param(DBCHelper::is_not_null($a_Variable)));
		DBCHelper::require_that(DBCHelper::the_param(DBCHelper::is_a_string($a_class_name)));
		$var_name = ""; //DBCHelper::print_var_name($a_Variable);
		$retVal = new DBCEvaluationTO();
		//$retVal->assertion = is_a($a_Variable, $a_class_name);
		$retVal->assertion = ($a_Variable instanceof $a_class_name);
		$retVal->partial_failure_message = $var_name . ' cannot be null.';

		return $retVal;
	}

	public static function is_a_string(&$a_Variable) {
		$var_name = ""; //DBCHelper::print_var_name($a_Variable);
		$retVal = new DBCEvaluationTO();
		$retVal->assertion = is_string($a_Variable);
		$retVal->partial_failure_message = $var_name . ' must be a string.';

		return $retVal;
	}

	public static function is_a_number(&$a_Variable) {
		DBCHelper::require_that(DBCHelper::the_param(DBCHelper::is_not_null($a_Variable)));
		$var_name = ""; //DBCHelper::print_var_name($a_Variable);
		$retVal = new DBCEvaluationTO();
		$retVal->assertion = is_numeric($a_Variable);
		$retVal->partial_failure_message = $var_name . ' must be a numeric value.';

		return $retVal;
	}

	public static function is_an_integer_string(&$a_Variable) {
		DBCHelper::require_that(DBCHelper::the_param(DBCHelper::is_a_number($a_Variable)));
		$var_name = ""; //DBCHelper::print_var_name($a_Variable);
		$retVal = new DBCEvaluationTO();
		$retVal->assertion = false;
		try {
			$aux = (int) $a_Variable;
			$retVal->assertion = true;
		} catch (Exception $ex) {
			//nothing to do, swollow it
		}
		$retVal->partial_failure_message = $var_name . ' must be an integer string.';

		return $retVal;
	}

	public static function is_a_boolean(&$a_Variable) {
		DBCHelper::require_that(DBCHelper::the_param(DBCHelper::is_not_null($a_Variable)));
		$var_name = ""; //DBCHelper::print_var_name($a_Variable);
		$retVal = new DBCEvaluationTO();
		$retVal->assertion = is_bool($a_Variable);
		$retVal->partial_failure_message = $var_name . ' must be a boolean.';

		return $retVal;
	}

	public static function is_an_integer(&$a_Variable) {
		DBCHelper::require_that(DBCHelper::the_param(DBCHelper::is_a_number($a_Variable)));
		$var_name = ""; //DBCHelper::print_var_name($a_Variable);
		$retVal = new DBCEvaluationTO();
		$retVal->assertion = is_int($a_Variable);
		$retVal->partial_failure_message = $var_name . ' must be an integer.';

		return $retVal;
	}

	public static function is_an_array(&$a_Variable) {
		$var_name = ""; //DBCHelper::print_var_name($a_Variable);
		$retVal = new DBCEvaluationTO();
		$retVal->assertion = is_array($a_Variable);
		$retVal->partial_failure_message = $var_name . ' must be an array.';

		return $retVal;
	}

	public static function is_a_date(&$a_Variable) {
		DBCHelper::require_that(DBCHelper::the_param(DBCHelper::is_not_null($a_Variable)));
		$var_name = ""; //DBCHelper::print_var_name($a_Variable);
		$retVal = new DBCEvaluationTO();
		$retVal->assertion = is_a($a_Variable, 'DateTime');
		$retVal->partial_failure_message = $var_name . ' must be a date.';

		return $retVal;
	}

	public static function is_a_date_interval(&$a_Variable) {
		DBCHelper::require_that(DBCHelper::the_param(DBCHelper::is_not_null($a_Variable)));
		$var_name = ""; //DBCHelper::print_var_name($a_Variable);
		$retVal = new DBCEvaluationTO();
		$retVal->assertion = is_a($a_Variable, 'DateInterval');
		$retVal->partial_failure_message = $var_name . ' must be a date interval.';

		return $retVal;
	}

	public static function is_greater_than(&$a_Variable, $lower_limit) {
		$var_name = ""; //DBCHelper::print_var_name($a_Variable);
		$retVal = new DBCEvaluationTO();
		$retVal->assertion = $a_Variable > $lower_limit;
		$retVal->partial_failure_message = $var_name . " must greater than [$lower_limit].";

		return $retVal;
	}

	public static function is_greater_than_or_equal_to(&$a_Variable, $lower_limit) {
		DBCHelper::require_that(DBCHelper::the_param(DBCHelper::is_a_number($a_Variable)));
		$var_name = ""; //DBCHelper::print_var_name($a_Variable);
		$retVal = new DBCEvaluationTO();
		$retVal->assertion = $a_Variable >= $lower_limit;
		$retVal->partial_failure_message = $var_name . " must greater or equal to [$lower_limit].";

		return $retVal;
	}

	public static function is_less_than(&$a_Variable, $upper_limit) {
		DBCHelper::require_that(DBCHelper::the_param(DBCHelper::is_a_number($a_Variable)));
		$var_name = ""; //DBCHelper::print_var_name($a_Variable);
		$retVal = new DBCEvaluationTO();
		$retVal->assertion = $a_Variable < $upper_limit;
		$retVal->partial_failure_message = $var_name . " must less than [$upper_limit].";

		return $retVal;
	}

	public static function is_less_than_or_equal_to(&$a_Variable, $upper_limit) {
		DBCHelper::require_that(DBCHelper::the_param(DBCHelper::is_a_number($a_Variable)));
		$var_name = ""; //DBCHelper::print_var_name($a_Variable);
		$retVal = new DBCEvaluationTO();
		$retVal->assertion = $a_Variable <= $upper_limit;
		$retVal->partial_failure_message = $var_name . " must less or equal to [$upper_limit].";

		return $retVal;
	}

	public static function the_assertion($a_Assertion_descriptor) {
		$a_Assertion_descriptor->partial_failure_message = 'Assertion ' . $a_Assertion_descriptor->partial_failure_message;
		return $a_Assertion_descriptor;
	}

	public static function the_variable($a_Assertion_descriptor) {
		$a_Assertion_descriptor->partial_failure_message = 'Variable ' . $a_Assertion_descriptor->partial_failure_message;
		return $a_Assertion_descriptor;
	}

	public static function the_param($a_Assertion_descriptor) {

		$a_Assertion_descriptor->partial_failure_message = 'Parameter ' . $a_Assertion_descriptor->partial_failure_message;
		return $a_Assertion_descriptor;
	}

	public static function the_return_value($a_Assertion_descriptor) {
		$a_Assertion_descriptor->partial_failure_message = 'Return value ' . $a_Assertion_descriptor->partial_failure_message;
		return $a_Assertion_descriptor;
	}

	public static function the_invariant($a_Assertion_descriptor) {
		$a_Assertion_descriptor->partial_failure_message = 'Invariant ' . $a_Assertion_descriptor->partial_failure_message;
		return $a_Assertion_descriptor;
	}

	private static function helper($a_Assertion_descriptor) {
		$ret_val = $a_Assertion_descriptor;

		if (is_object($a_Assertion_descriptor)) {
			$ret_val = $a_Assertion_descriptor;
		} else if (is_callable("self::" . $a_Assertion_descriptor)) {

			$kind_of_value_func = "self::" . $a_Assertion_descriptor;
			$kind_of_value_func_arg = func_get_arg(2);
			if (is_callable("self::" . $kind_of_value_func_arg)) {
				$kind_of_constraint_func = "self::" . $kind_of_value_func_arg;
				$kind_of_constraint_func_arg = func_get_arg(1);

				$a = call_user_func($kind_of_constraint_func, $kind_of_constraint_func_arg);
				$ret_val = call_user_func($kind_of_value_func, $a);
			}
		} else {
			throw new Exception("not know argument type", 1, null);
		}
		return $ret_val;
	}

	public static function assert_that($a_Assertion_descriptor) {
		$a_Assertion_descriptor = call_user_func_array('self::helper', func_get_args());

		if (!$a_Assertion_descriptor->assertion) {
			$msg = "ASSERT FAILED:" . $a_Assertion_descriptor->partial_failure_message;
			throw new Exception($msg);
		}
	}

	public static function require_that($a_Assertion_descriptor) {
		$a_Assertion_descriptor = call_user_func_array('self::helper', func_get_args());

		if (!$a_Assertion_descriptor->assertion) {
			$msg = "REQUIRE FAILED:" . $a_Assertion_descriptor->partial_failure_message;
			throw new Exception($msg);
		}
	}

	public static function ensure_that($a_Assertion_descriptor) {
		$a_Assertion_descriptor = call_user_func_array('self::helper', func_get_args());

		if (!$a_Assertion_descriptor->assertion) {
			$msg = "ENSURE FAILED:" . $a_Assertion_descriptor->partial_failure_message;
			throw new Exception($msg);
		}
	}

	function print_var_name($var) {
		foreach ($GLOBALS as $var_name => $value) {
			if ($value === $var) {
				return $var_name;
			}
		}

		return false;
	}

}

class DBCEvaluationTO {

	public $assertion = false;
	public $partial_failure_message = "";

	public function __construct() {
		
	}

//  public function __construct($a_assertion, $a_partial_failure_message){
//	  $this->assertion = $a_assertion;
//	  $this->partial_failure_message = $a_partial_failure_message;
//  }
}


?>