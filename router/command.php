<?php
	require_once REALPATH .'util/DBCHelper.php';
	require_once REALPATH .'util/TextUtil.php';
/*
 * Created on Feb 8, 2012
 */

class Command {

	private $url_interpreter;
	public $Name = 'default';
	public $Action = 'default';
	public $Parameters = array();

	public function Command(
		$a_url_interpreter
	) {	
		Logger::debug($this, "CREATING Command[{$a_controller_name}, {$a_action_name}]");
		
		DBCHelper2::require_that()->the_param($a_url_interpreter)->is_not_null();

		$this->url_interpreter = $a_url_interpreter;
		$this->Name = $a_url_interpreter->controller_name;
		$this->Action = $a_url_interpreter->action_name;
		$this->Parameters = $a_url_interpreter->command_parameters;
	}

	public function getControllerName() {
		$ret_val = $this->Name;
		DBCHelper2::ensure_that()->the_return_value($ret_val)->is_a_string();
		return $ret_val;
	}

	public function setControllerName(
		$a_controller_name
	) {
		DBCHelper2::require_that()->the_param($a_controller_name)->is_a_string();
		$this->Name = $a_controller_name;
	}

	public function getAction() {
		$ret_val = $this->Action;
		DBCHelper2::ensure_that()->the_return_value($ret_val)->is_a_string();
		return $ret_val;
	}

	public function setAction(
		$a_action_name
	) {
		DBCHelper2::require_that()->the_param($a_action_name)->is_a_string();
		$this->Action = $a_action_name;
	}

	public function getParameters() {
		$ret_val = $this->Parameters;
		DBCHelper2::ensure_that()->the_return_value($ret_val)->is_an_array();
		return $ret_val;
	}

	public function setParameters(
		$a_controller_parameters
	) {
		DBCHelper2::require_that()->the_param($a_controller_parameters)->is_an_array();
		$this->Parameters = $a_controller_parameters;
	}

	public function __toString() {
		$str = 'Command [ Name[';
		$str .= $this->Name;
		$str .= '], Function [';
		$str .= $this->Action;
		$str .= '], Parameters[';
		if ((isset($this->Parameters) && sizeof($this->Parameters) > 0 && sizeof($this->Parameters) < 5)){
			$str .= TextUtil::toString($this->Parameters);
		}
		$str .= '] ]';
		
		$ret_val = $str;
		DBCHelper2::ensure_that()->the_return_value($ret_val)->is_a_string();

		return $str;
	}
	
	
	

	public function get_variable_from_context(
		$a_variable_name
		, $a_default_value_if_not_exists = "__NO_DEFAULT_VALUE_WAS_PASSED___"
	){
		$ret_val = $a_default_value_if_not_exists;
		$variable_exists_in_POST = key_exists($a_variable_name, $_POST);
		$variable_exists_in_parameters = key_exists($a_variable_name, $this->Parameters);
		$variable_exists_in_SESSION = key_exists($a_variable_name, $_SESSION);
		if($variable_exists_in_POST){
			$ret_val = $_POST[$a_variable_name];
		}else if($variable_exists_in_parameters){
			$ret_val = $this->Parameters[$a_variable_name]; 
		}else if($variable_exists_in_SESSION ){
			$ret_val = $_SESSION[$a_variable_name]; 
		}
		
		if($ret_val == '__NO_DEFAULT_VALUE_WAS_PASSED___'){
			throw new Exception("Parameter [{$a_variable_name}] doesn't exists. And no default value was passed.");
		}
		return $ret_val;
		
	}
	
	
	public function set_parameter(
		$a_parameter_name
		, $a_parameter_value
		, $a_throw_error_if_already_exists=true
	){
		$parameter_exists = key_exists($a_parameter_name, $this->Parameters);
		if($parameter_exists){
			if($a_throw_error_if_already_exists){
				throw new Exception("Parameter [{$a_parameter_name}] already exists");			
			}
		}
		
		$this->Parameters[$a_parameter_name] = $a_parameter_value; 
		
	}
	
	
	public function get_parameter(
		$a_parameter_name
		, $a_default_value_if_not_exists = null
		, $a_throw_error_if_not_exists=true
	){
		$ret_val = null;
		
		$parameter_exists = key_exists($a_parameter_name, $this->Parameters);
		if(!$parameter_exists ){
			if($a_throw_error_if_not_exists){
				throw new Exception("Parameter [{$a_parameter_name}] doesn't exists");
			}
			else{
				$ret_val = $a_default_value_if_not_exists;
			}
		}
		else{
			$ret_val = $this->Parameters[$a_parameter_name]; 
		}
		
		return $ret_val;		
	}
	
	
	public function set_active_site(
		$a_active_site
	){
		$active_site = $a_active_site;
				
		$this->set_parameter('active_site', $active_site, false); 			
	}

	
	public function get_active_site(){
		$ret_val = $this->get_parameter('active_site'); 
		return $ret_val;		
	}
	
	

	public function set_is_logged_in_and_update_site_mode(){
		$this->set_parameter("is_logged_in", true, false);
	}
	
	public function reset_is_logged_in_and_update_site_mode(){
		$this->set_parameter("is_logged_in", false, false);
	}

	public function is_logged_in(){
		$ret_val = null;
		
		$ret_val  = $this->get_parameter("is_logged_in", false, false);
		
		return $ret_val;
	}

	
	
	
	
	
	public function add_message($a_message){
		$this->Parameters['messages'][] = $a_message;
	}

	public function get_messages(){
		$ret_val = $this->get_parameter('messages'); 
		return $ret_val;		
	}
	
	public function add_js(
		$a_js_relative_file_path
	){
		$this->Parameters['js'][] = $a_js_relative_file_path;		
	}
	
	public function add_css(
		$a_css_relative_file_path
	){
		$this->Parameters['css'][] = $a_css_relative_file_path;		
	}
	

}

?>
