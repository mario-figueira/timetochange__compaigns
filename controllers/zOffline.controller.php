<?php

require_once 'controllers/default.controller.php';

/**
 * Description of companies
 *
 * @author pmcosta
 */
class zOfflineController extends defaultController {

	public function _default() {
		//require_once REALPATH .'enums/page_type.php';
		$this->_show_offline_message();
	}
	
	public function _show_offline_message(){
		$this->Command->setAction("show_offline_message");
		parent::_defaultAction();		
	}
	
	
	public function _special_login(){
		$this->Command->setAction("special_login");
		parent::_defaultAction();		
	}

	public function _special_login_submit(){
		//$this->Command->setAction("special_login_submit");
		
		
		$login = $_POST['login'];
		$a_login_was_provided = isset($login);		
		$password = $_POST['password'];
		
		require_once REALPATH ."model/default.model.php";
		$offline_clearance_users_model = new defaultModel("offline_clearance_users");
		
		$filter = array("login"=>$login, "password"=>$password);
		
		$user_records =  $offline_clearance_users_model->getFilteredBy($filter, true);
		
		$user_clearance_level = $user_records[0]['offline_clearance_level'];
		
		$this->set_offline_cookie($user_clearance_level);
		
		
		
		parent::_defaultAction();		
	}
	
	
	function set_offline_cookie($a_cookie_data){
		
		$offline_cookie_name = "wom-offline";
	
		$offline_cookie_duration = 4 * 60 * 60;
		$now = time();
		$offline_cookie_expiration_time = $now + $offline_cookie_duration;

		setcookie($offline_cookie_name, $a_cookie_data, $offline_cookie_expiration_time, '/');		
	}
}

?>
