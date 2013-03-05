<?php
	require_once REALPATH .'util/DBCHelper.php';
	require_once REALPATH .'util/TextUtil.php';
/*
 * Created on Feb 8, 2012
 */

class Command {

	private $url_interpreter;
	private $name = 'default';
	private $action = 'default';
	private $parameters = array();

	public function Command(
		$a_url_interpreter
	) {	
		Logger::debug($this, "CREATING Command[{$a_controller_name}, {$a_action_name}]");
		
		DBCHelper2::require_that()->the_param($a_url_interpreter)->is_not_null();

		$this->url_interpreter = $a_url_interpreter;
		$this->name = $a_url_interpreter->controller_name;
		$this->action = $a_url_interpreter->action_name;
		$this->parameters = $a_url_interpreter->command_parameters;
	}

	public function get_controller_name() {
		$ret_val = $this->name;
		
		DBCHelper2::ensure_that()->the_return_value($ret_val)->is_a_string();
		return $ret_val;
	}

	public function set_controller_name(
		$a_controller_name
	) {
		DBCHelper2::require_that()->the_param($a_controller_name)->is_a_string();
		$this->name = $a_controller_name;
	}

	public function get_action() {
		$ret_val = $this->action;
		DBCHelper2::ensure_that()->the_return_value($ret_val)->is_a_string();
		return $ret_val;
	}

	
	public function set_action(
		$a_action_name
	) {
		DBCHelper2::require_that()->the_param($a_action_name)->is_a_string();
		$this->action = $a_action_name;
	}


	public function get_parameters() {
		$ret_val = $this->parameters;
		DBCHelper2::ensure_that()->the_return_value($ret_val)->is_an_array();
		return $ret_val;
	}

	public function set_parameters(
		$a_controller_parameters
	) {
		DBCHelper2::require_that()->the_param($a_controller_parameters)->is_an_array();
		$this->parameters = $a_controller_parameters;
	}

	public function __toString() {
		$str = 'Command [ Name[';
		$str .= $this->name;
		$str .= '], Function [';
		$str .= $this->action;
		$str .= '], Parameters[';
		if ((isset($this->parameters) && sizeof($this->parameters) > 0 && sizeof($this->parameters) < 5)){
			$str .= TextUtil::toString($this->parameters);
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
		$variable_exists_in_parameters = key_exists($a_variable_name, $this->parameters);
		$variable_exists_in_SESSION = key_exists($a_variable_name, $_SESSION);
		if($variable_exists_in_POST){
			$ret_val = $_POST[$a_variable_name];
		}else if($variable_exists_in_parameters){
			$ret_val = $this->parameters[$a_variable_name]; 
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
		$parameter_exists = key_exists($a_parameter_name, $this->parameters);
		if($parameter_exists){
			if($a_throw_error_if_already_exists){
				throw new Exception("Parameter [{$a_parameter_name}] already exists");			
			}
		}
		
		$this->parameters[$a_parameter_name] = $a_parameter_value; 
		
	}
	
	
	public function get_parameter(
		$a_parameter_name
		, $a_default_value_if_not_exists = null
		, $a_throw_error_if_not_exists=true
	){
		$ret_val = null;
		
		$parameter_exists = key_exists($a_parameter_name, $this->parameters);
		if(!$parameter_exists ){
			if($a_throw_error_if_not_exists){
				throw new Exception("Parameter [{$a_parameter_name}] doesn't exists");
			}
			else{
				$ret_val = $a_default_value_if_not_exists;
			}
		}
		else{
			$ret_val = $this->parameters[$a_parameter_name]; 
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
	
	

	public function set_is_logged_in(){
		$this->set_parameter("is_logged_in", true, false);
	}
	
	public function reset_is_logged(){
		$this->set_parameter("is_logged_in", false, false);
	}

	public function is_logged_in(){
		$ret_val = null;
		
		$ret_val  = $this->get_parameter("is_logged_in", false, false);
		
		return $ret_val;
	}

	
	
	
	
	
	public function add_message($a_message){
		$this->parameters['messages'][] = $a_message;
	}

	public function add_messages($a_messages_array){
		foreach($a_messages_array as $message){
			$this->add_message($message);
		}
	}

	public function get_messages(){
		$ret_val = $this->get_parameter('messages'); 
		return $ret_val;		
	}
	
	public function add_js(
		$a_js_relative_file_path
	){
		$this->parameters['js'][] = $a_js_relative_file_path;		
	}
	
	public function add_css(
		$a_css_relative_file_path
	){
		$this->parameters['css'][] = $a_css_relative_file_path;		
	}
	
	public function set_current_user($a_user){
		$this->set_parameter("current_user", $a_user, false);
	}
	
	public function get_current_user(){
		$ret_val = $this->get_parameter("current_user", null, false);
		return $ret_val;
	}

	
	public function get_posted_values(){
		$ret_val = array();
		
		$posted_values = array_merge($_POST, $_FILES);		
		
		$ret_val = $posted_values;
		
		return $posted_values;
	}
}

?>
