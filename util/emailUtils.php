<?php

Class emailUtils {

	public static function   validateEmail($a_email) {
		$result = false;
		if (eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $a_email)) {
			$result = true;
		}
		return $result;
	}

	public static function build_named_from_address($a_address, $a_name){
		DBCHelper2::assert_that()->the_param($a_address)->is_a_string();
		DBCHelper2::assert_that()->the_param($a_name)->is_a_string();
		
		$ret_val = $a_address;
		
		$ret_val = "From: {$a_name} <{$a_address}>";
		
		return $ret_val;
	}
	
	public static function  send_mail($a_from, $a_to, $a_subject, $a_message) {
		Logger::debug($this, 'send_mail(' . $a_from . ',' . $a_to . ',' . $a_subject .')');
		
		// To send HTML mail, the Content-type header must be set
		$headers = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
		// Additional headers
		$headers .= $a_from . "\r\n";
		// Mail it
		$mail_ret_call = mail($a_to, $a_subject, $a_message, $headers);
		
		return $mail_ret_call;
	}
	


}
