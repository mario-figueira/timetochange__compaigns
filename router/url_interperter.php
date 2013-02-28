<?php
require_once REALPATH .'/util/DBCHelper.php';


/**
 * 
 * @author pmcosta
 * 
 * URLInterpreter get url from request, builds Comand (router command)
 * 
 * 
 */
class url_interpreter {

	private $url;
	private $request_str;
	private $request;
	public $controller_name;
	private $requested_controller_name;
	public $action_name;
	private $requested_action_name;
	public $command_parameters;

	
	public function url_interpreter($a_url) {
		$this->url = $a_url;
					
		$this->url__parse();
		
		$this->missing_arguments__policy__apply();
		
	}

	private function url__parse() {
		//$parameters = null;
		//$action = null;

		
		Logger::debug($this, ' creating for PATHINFO [ ' . $_SERVER['PATH_INFO'] . ']');
		

		$request_str = preg_replace("|/*(.+?)/*$|", "\\1", $this->url);

		$request = explode('/', $request_str);
		Logger::debug($this, ' COMMANDARRAY ' . print_r($request, true));


		$parameter_index = 0;
		$controller_name = $this->argument__extract($request, $parameter_index);
		
		$parameter_index ++;
		$action_name = $this->argument__extract($request, $parameter_index);

		$parameter_index ++;
		$command_parameters = $this->command_parameters__extract_as_array($request, $parameter_index);

		
		$this->request_str = $request_str;
		$this->request = $request;
		$this->requested_controller_name = $controller_name;
		$this->requested_action_name = $action_name;
		$this->controller_name = $controller_name;
		$this->action_name = $action_name;
		$this->command_parameters = $command_parameters;
	}

	private function missing_arguments__policy__apply(){
			
	
		// Check if the url is the root.
		// if it is then set the command to the root controller.
		if (!isset($this->controller_name) or empty($this->controller_name)) {
			$this->controller_name = 'default';
		}

		if (!isset($this->action_name) or empty($this->action_name)) {
			$this->action_name = 'default';
		}


		//$this->bootstrapV2();
	}

	private function argument__extract($a_request_parameters_array, $a_parameter_index){
		$ret_val = "";
		
		$tmp_value = $a_request_parameters_array[$a_parameter_index];
		$value_is_set = isset($tmp_value);
		$value_is_not_empty = !empty($tmp_value);
		$value_is_good = $value_is_set && $value_is_not_empty;
		
		if ( $value_is_good) {
			$ret_val  = $tmp_value;
		}
		else{
			$ret_val = "";
		}
		
		return $ret_val;
	}
	
	private function command_parameters__extract_as_array($a_request_parameters_array, $a_parameter_index){
		
		$ret_val = array();
		
		$tmp_value = $a_request_parameters_array[$a_parameter_index];
		$value_is_set = isset($tmp_value);
		
		$parameters = array();
		if ($value_is_set) {
			$parameters = array();
			$parametersPair = array_slice($a_request_parameters_array, $a_parameter_index);
			for ($i = 0; $i < sizeof($parametersPair); $i = $i + 2) {
				$parameters[$parametersPair[$i]] = $parametersPair[$i + 1];
			}
		}
		
		$ret_val = $parameters;
		
		return $parameters;
		
	}


		
		



	public function command__get() {
		//Logger::debug($this,' getCommand() returning '.$this->Command->toString());
		
		$ret_val = null;
		
		
		$command = new Command($this);

		
		$ret_val = $command;
		
		DBCHelper2::ensure_that()->the_return_value($ret_val)->is_not_null();

		return $ret_val;
	}

}

?>
