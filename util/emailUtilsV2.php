<?php
require_once 'email_utils_config.php';
Class emailUtilsV2 {

	public static function validateEmail($a_email) {
		$result = false;
		if (eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $a_email)) {
			$result = true;
		}
		return $result;
	}

	protected function mime_add_images($a_mime_obj, $a_images_descriptor_array) {
		foreach ($a_images_descriptor_array as $image_descriptor) {
			$a_mime_obj->addHTMLImage($image_descriptor["image_file_name"], $image_descriptor["mime_type"]);
		}
	}

	protected function build_header_definition($a_from, $a_subject) {
		$ret_val = null;

		$header = array(
		    'From' => $a_from,
		    'Subject' => $a_subject
		);

		$ret_val = $header;

		return $ret_val;
	}

	protected function build_mime_obj() {
		require_once 'Mail/mime.php';
		$ret_val = null;
		$mime_obj = new Mail_mime(array(
				/* 'eol' => null, */
				'head_charset' => 'UTF-8',
				'text_charset' => 'UTF-8',
				'html_charset' => 'UTF-8'));

		$ret_val = $mime_obj;

		return $ret_val;
	}

	protected function build_mime_header($a_header_definition) {
		$ret_val = null;

		$mime_obj = $this->build_mime();
		$mime_header = $mime_obj->headers($a_header_definition);

		$ret_val = $mime_header;

		return $ret_val;
	}

	protected function gmail_smtp_connection_build() {
		$ret_val = null;
		
		$auth_enabled = defined("SMTP_USER");

		$smtp_connection = array('host' => SMTP_SERVER, 'port' => SMTP_PORT, 'auth' => $auth_enabled, 'username' => SMTP_USER, 'password' => SMTP_PASSWORD, 'debug' => (SMTP_DEBUG === true));

		$ret_val = $smtp_connection;

		return $ret_val;
	}

	protected function mail_send_mime_obj($a_smtp_connection, $a_headers_definition, $a_mime_obj, $a_to_address) {
		$ret_val = null;

		$mime_body = $a_mime_obj->get(array('text_charset' => 'utf-8'));
		$mime_header = $a_mime_obj->headers($a_headers_definition);


		require_once 'Mail.php';

		$mail = & Mail::factory('smtp', $a_smtp_connection);
		$to_addresses = explode(";", $a_to_address);

		$send_result = false;

		foreach($to_addresses as $to_address){

			try {
			    $send_call_res = $mail->send($to_address, $mime_header, $mime_body);
			    $send_result = !($send_call_res instanceof PEAR_Error) && $send_call_res;
			} catch (Exception $e) {		 
			    $send_result &= false;
			}

		}

		$ret_val = $send_result;

		return $ret_val;
	}

	protected function mail_build_mime_obj_from_text_string($a_body_string) {
		$ret_val = null;

		$mime_obj = $this->build_mime_obj();
		$mime_obj->setTXTBody($a_body_string);

		$ret_val = $mime_obj;

		return $ret_val;
	}

	protected function mail_build_mime_obj_from_HTML_string($a_body_HTML_string) {
		$ret_val = null;

		$mime_obj = $this->build_mime_obj();
		$mime_obj->setHTMLBody($a_body_HTML_string);

		$ret_val = $mime_obj;

		return $ret_val;
	}

	public function html_mail_send_internal($a_from_address, $a_to_address, $a_subject, $a_html_body, $a_images_array) {
		$send_call_res = false;
		$header_definition = $this->build_header_definition($a_from_address, $a_subject);
		require_once 'Mail/mime.php';
		//$mime_obj = $this->mail_build_mime_obj_from_HTML_string($a_html_body);
		$a_to_address = $this->override_to_mail_if_necessary($a_to_address);
		$mime = $this->build_mime_obj();

		if ($mime instanceof Mail_mime) {
			$mime->setHTMLBody($a_html_body);
			
			foreach ($a_images_array as $image) {
				$real_path = $image["real_path"];
				$mime_type = 'image/' . $image["mime_type"];
				$res = $mime->addHTMLImage($real_path, $mime_type);
			}
			
			//$mime->addHTMLImage("/home/pmcosta/public_html/teste/image.png", "image/gif");
			$body = $mime->get();
			
			$smtp_connection = $this->gmail_smtp_connection_build();
			
			$mime_headers = $mime->headers($header_definition);
			
			require_once 'Mail.php';
			$mail = & Mail::factory('smtp', $smtp_connection); 
			$send_call_res = $mail->send($a_to_address,$mime_headers,$body);
		}
		
		return $send_call_res;
	}

    public function text_mail_send_internal($a_from_address, $a_to_address, $a_subject, $a_text_body) {
	    $header_definition = $this->build_header_definition($a_from_address, $a_subject);
	    $mime_obj = $this->mail_build_mime_obj_from_text_string($a_text_body);
	    $smtp_connection = $this->gmail_smtp_connection_build();
	    $a_to_address = $this->override_to_mail_if_necessary($a_to_address);
	    $send_call_res = $this->mail_send_mime_obj($smtp_connection, $header_definition, $mime_obj, $a_to_address);
	    return $send_call_res;
    }

	public static function html_mail_send($a_from_address, $a_to_address, $a_subject, $a_html_body, $a_images_array) {
		$mail_util = new emailUtilsV2();
		$send_call_res = $mail_util->html_mail_send_internal($a_from_address, $a_to_address, $a_subject, $a_html_body, $a_images_array);
		return $send_call_res;
	}

	public static function text_mail_send($a_from_address, $a_to_address, $a_subject, $a_text_body) {
		$mail_util = new emailUtilsV2();

		$send_call_res = $mail_util->text_mail_send_internal($a_from_address, $a_to_address, $a_subject, $a_text_body);

		return $send_call_res;
	}

	private function override_to_mail_if_necessary($a_to_email_address) {
		$ret_val = $a_to_email_address;
		$is_production = (ENVIRONMENT === 'CUSTOMER_PRODUCTION');
		$is_a_catch_all_email_defined = defined("CATCH_ALL_EMAIL"); // (!(CATCH_ALL_EMAIL==='CATCH_ALL_EMAIL')) && (CATCH_ALL_EMAIL==='') && strlen($string);
//		if (!$is_production && !$is_a_catch_all_email_defined) {
//			throw new Exception('Developer, you must set a CATCH ALL email when not in production enviroment');;
//		}
		if (!$is_production && $is_a_catch_all_email_defined) {
			$ret_val = CATCH_ALL_EMAIL;
		} else {
			$ret_val = $a_to_email_address;
		}

		return $ret_val;
	}

	public static function build_named_from_address($a_address, $a_name) {
		DBCHelper2::assert_that()->the_param($a_address)->is_a_string();
		DBCHelper2::assert_that()->the_param($a_name)->is_a_string();

		$ret_val = $a_address;

		$ret_val = "{$a_name} <{$a_address}>";

		return $ret_val;
	}

}
