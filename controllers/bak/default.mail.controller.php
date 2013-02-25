<?php
//require_once ('Auth.php');

require_once 'controllers/default.controller.php';

/*
 * Created on Feb 8, 2012 by Pedro Marques da Costa
 *
 */
class default_mailController extends defaultController {
	
	protected function render_to_string($a_template){
		ob_start();
		
		$a_template->render();
		
		$html = ob_get_contents();
		
		ob_clean();
		return $html;
		
	}
	
	protected function mime_add_images($a_mime_obj, $a_images_descriptor_array){
		foreach($a_images_descriptor_array as $image_descriptor){
			$a_mime_obj->addHTMLImage($image_descriptor["image_file_name"], $image_descriptor["mime_type"]);
		}
	}

	
	protected function build_header_definition($a_from, $a_subject){
		$ret_val = null;
		
		$header = array(
				'From'    => $a_from,
				'Subject' => $a_subject
		);
		
		$ret_val = $header;
		
		return $ret_val;
	}
	
	protected function build_mime_obj(){
		require_once 'Mail/mime.php' ;

		$ret_val = null;
		
		$mime_obj = new Mail_mime(array('eol' => $crlf,'head_charset'=>'UTF-8','text_charset'=>'UTF-8','html_charset'=>'UTF-8'));		
		
		$ret_val = $mime_obj;
		
		return $ret_val;
	}
	
	protected function build_mime_header($a_header_definition){
		$ret_val = null;
		
		$mime_obj = $this->build_mime();
		$mime_header = $mime_obj->headers($a_header_definition);
		
		$ret_val = $mime_header;
		
		return $ret_val;
	}
	
	
	protected function gmail_smtp_connection_build($a_gmail_username, $a_gmail_password){
		$ret_val = null;
		
		$smtp_connection = array('host'=>"smtp.gmail.com", 'port'=>"587", 'auth'=>true, 'username'=>$a_gmail_username, 'password'=>$a_gmail_password, 'debug'=>true);
		
		$ret_val = $smtp_connection;
		
		return $ret_val;
		
	}
	
	protected function default_gmail_smtp_connection_build($a_gmail_username, $a_gmail_password){
		$ret_val = null;
		
		$smtp_connection = $this->gmail_smtp_connection_build("<POE_O_TEU_ENDEREÇO_GMAIL_AQUI>", "<POE_A_TUA_PASSWORD_GMAIL_AQUI>");
		
		$ret_val = $smtp_connection;
		
		return $ret_val;
		
	}

	
	protected function mail_send_mime_obj($a_smtp_connection, $a_headers_definition, $a_mime_obj, $a_to_address){
		$ret_val = null;
		
		
		$mime_body = $a_mime_obj->get(array('text_charset' => 'UTF-8'));
		$mime_header = $a_mime_obj->headers($a_headers_definition);
		
		
		require_once 'Mail.php';
		//$mail =& Mail::factory('mail');
		$mail =& Mail::factory('smtp', $a_smtp_connection);
		
		try{

			$send_call_res = $mail->send($a_to_address, $mime_header, $mime_body);
		}catch(Exception $e){
			var_dump($e);
		}
		
		$ret_val = $send_call_res;
		
		return $ret_val;
	}
	
	
	protected function mail_build_mime_obj_from_text_string($a_body_string){
		$ret_val = null;
		
		$mime_obj = $this->build_mime_obj();
		$mime_obj->setTXTBody($a_body_string);

		$ret_val = $mime_obj;

		return $ret_val;

	}
	
	
	
	
	
	
	
}
?>
