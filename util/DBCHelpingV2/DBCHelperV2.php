<?php

require_once 'config/sysvars.php';
//require_once 'dbchelperV1.php';

require_once 'util/DBCHelpingV2/kinds_of_assertions.php';
require_once 'util/DBCHelpingV2/kinds_of_values.php';

abstract class DBCHelper2 {

	/**
	 * @return kind_of_value 
	 */
	public static function assert_that() {
		if(ASSERTION_LEVEL<=0){return new kind_of_value(new kind_of_assertion(0, ''));}

		$msg = "ASSERT FAILED:";
		$kind_of_assertion = new kind_of_assertion(kind_of_assertion::$C_ASSERT, $msg);
		$ret_val = new kind_of_value($kind_of_assertion);

		return $ret_val;
	}

	/**
	 * @return kind_of_value 
	 */
	public static function require_that() {
		if(ASSERTION_LEVEL<=1){return new kind_of_value(new kind_of_assertion(0, ''));}

		$msg = "REQUIRE FAILED:";
		$kind_of_assertion = new kind_of_assertion(kind_of_assertion::$C_REQUIRE, $msg);
		$ret_val = new kind_of_value($kind_of_assertion);

		return $ret_val;
	}

	/**
	 * @return kind_of_value 
	 */
	public static function ensure_that() {
		if(ASSERTION_LEVEL<=2){return new kind_of_value(new kind_of_assertion(0, ''));}

		$msg = "ENSURE FAILED:";
		$kind_of_assertion = new kind_of_assertion(kind_of_assertion::$C_ENSURE, $msg);
		$ret_val = new kind_of_value($kind_of_assertion);

		return $ret_val;
	}

}

?>