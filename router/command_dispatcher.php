<?php
require_once 'util/DBCHelper.php';

/**
 * 
 * @author pmcosta
 *
 * commandDispatcher dispatches command to controller
 */
class command_dispatcher {

	private $command;

	public function command_dispatcher(& $a_command) {
		Logger::debug($this, 'CREATING CommandDispatcher[' . $a_command . ']');
		DBCHelper2::require_that()->the_param($a_command)->is_an_object_instance_of_the_class("Command");
		
		Logger::debug($this, ' creating (' . $a_command . ')');
		
		$this->command = $a_command;
		
		DBCHelper2::ensure_that()->the_variable($this->command)->is_an_object_instance_of_the_class("Command");
	}

	public function dispatch() {
		DBCHelper2::require_that()->the_variable($this->command)->is_not_null();
		
		Logger::debug($this, 'Dispatch()' . $this->command);
		try {
			//$cookie_setted = $this->bootstrap();
			$controllerName = $this->command->getControllerName();

			DBCHelper2::assert_that()->the_variable($controllerName)->is_a_string();
			
			if ($this->is_a_controller($controllerName) == false) {

				if (DEBUG) {
					$include_path = 'controllers/' . $controllerName . '.controller.php';
					$this->command->Parameters['messages'] = array('commanddispatcher: cannot find file ' . $include_path);
				} else {
					//$this->Command->Parameters['messages'] = array('Cannot find the controller component ' . $controllerName); ////TODO: the text should reviewed
				}
				$controllerName = 'default';
				$this->command->set_action('error');
				////TODO: it should be a 404 page
			}
			
			
			/*
			if(IS_OFFLINE){
				$this->Command->setControllerName("zOffline");
				$this->Command->setAction("default");
				$controllerName = "zOffline";
			}
			*/

			$is_public_access = (OFFLINE_CLEARANCE_LEVEL==0);
			$is_special_offline_access_mode = !$is_public_access;
			$is_going_to_flags = ($controllerName == "flags");
			
			if(!$is_going_to_flags && $is_special_offline_access_mode){

				$go_to_special_login = true;

				$is_offline_controller = ($this->command->getControllerName() == "zOffline");
				$is_special_login_submit_action = ($this->command->getAction() == "special_login_submit");
				$is_offline_special_login_submit = $is_offline_controller && $is_special_login_submit_action;

				if($is_offline_special_login_submit){
					$go_to_special_login = false;
				}
				else{
				
					$offline_cookie = $this->offline_cookie__get();
					$there_is_a_wom_offline_cookie = isset($offline_cookie);
					if($there_is_a_wom_offline_cookie){

						$offline_cookie_data = null;								

						$offline_cookie_data = $offline_cookie;
						$offline_cookie_clearance_level = $offline_cookie_data;

						if($offline_cookie_clearance_level >= OFFLINE_CLEARANCE_LEVEL){
							$go_to_special_login = false;
						}
						else{
							$go_to_special_login = true;
						}

						//$this->set_offline_cookie($offline_cookie_data);

					}
				}
				
				if($go_to_special_login)
				{
					$this->command->setControllerName("zOffline");
					$this->command->setAction("special_login");
					$controllerName = "zOffline";					
				}
				
			}
			
			$controller = $this->controller__get($controllerName);
			
			$controller->execute();
		} catch (Exception $e) {
			Logger::exception($this, $e);
			Logger::debug($this, 'Error Dispatching ' . $controllerName . 'file controllers/' . $controllerName . '.controller.php -> HERE HERE' . $e->getMessage());
			throw $e;
		}
	}
	
	private  function is_a_controller($a_controller_name) {
		DBCHelper2::require_that()->the_param($a_controller_name)->is_a_string();

		$ret_val = false;
		if (file_exists('controllers/' . $a_controller_name . '.controller.php')) {
			Logger::debug($this, 'IS CONTROLLER');
			$ret_val = true;
		} else {
			Logger::debug($this, 'controllers/' . $a_controller_name . '.controller.php' . ' ->IS NOT CONTROLLER');
			$ret_val = false;
		}
		
		DBCHelper2::ensure_that()->the_return_value($ret_val)->is_a_boolean();

		return $ret_val;
	}

	private function controller__get($a_controller_name){
		$ret_val = null;
		
		$include_path = REALPATH .'controllers/' . $a_controller_name . '.controller.php';			
		DBCHelper2::assert_that()->the_file($include_path)->exists();

		require_once $include_path;

		$controllerClass = $a_controller_name . "Controller";
		DBCHelper2::assert_that()->the_class($controllerClass)->exists();

		$controller = new $controllerClass($this->command);			
		DBCHelper2::assert_that()->the_variable($controller)->is_not_null();
		
		$ret_val = $controller;
		
		return $ret_val;
		
	}
	
	
	function offline_cookie__get(){
		$ret_val = null;
		
		$offline_cookie_name = "wom-offline";
		
		$ret_val = $_COOKIE[$offline_cookie_name];
		
		return $ret_val;
	}



}

?>