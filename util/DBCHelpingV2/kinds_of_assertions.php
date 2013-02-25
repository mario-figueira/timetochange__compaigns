<?php

require_once 'config/sysvars.php';

require_once 'util/DBCHelpingV2/kinds_of_assertions.php';

class kind_of_assertion {
	public $assertion_message_part = "";

	public static $C_ASSERT = 1;
	public static $C_REQUIRE = 2;
	public static $C_ENSURE = 3;
	
	public $kind = null;
	
	public function __construct(
		$a_kind
		, $a_assertion_message_part
	) {
		$this->kind = $a_kind;
		$this->assertion_message_part = $a_assertion_message_part;
	}


}



?>