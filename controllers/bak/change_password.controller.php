<?php
require_once REALPATH . 'controllers/zzzzExceptions.php';

require_once REALPATH . 'controllers/default.controller.php';

class change_passwordController extends defaultController {

	public function _request_change_password() {
		$this->Template = new Template($this->Command);
		$this->Template->render();
	}
	
	public function _request_change_password_submit() {
		
		try{
			require_once REALPATH . 'to/ambassador.to.php';
			$ambassador = $this->Command->get_parameter('ambassador_to');

			$new_password = $_POST['password'];
			$new_password_confirmation = $_POST['password_confirmation'];
			$new_password_md5 = md5($new_password);

			$ambassador->password = $new_password_md5;

			require_once REALPATH.'model/ambassador.model.php';
			$ambassador_model = new ambassadorModel();
			$ambassador_id = $ambassador->id;
			$mabassador_data_array = $ambassador->get_as_array(); 
			$update_callres =  $ambassador_model->update_by_id($ambassador_id, $mabassador_data_array);
			$update_was_sucessfull = $update_callres['boolean'];
		
		if($update_was_sucessfull){
			$this->render_operation_ok( _("change_password::change_password::ok::title - OK"), _("change_password::change_password::ok::message - Password sucessfully changed."));			
		}
		else{
			$this->render_operation_failure( _("change_password::change_password::failure::title - OOPS"), _("change_password::change_password::failure::message - something went wrong."));
		}
		}catch(Exception $e){
			$this->render_operation_failure( _("change_password::change_password::failure::title - OOPS"), _("change_password::change_password::failure::message - something went wrong."));			
		}

	}

	
	private function render_operation_ok($a_title, $a_message) {

		$this->Command->set_parameter("notification_title", $a_title);
		$this->Command->set_parameter("notification_message", $a_message);
		
		$this->Command->setAction("operation_ok");
		
		$this->Template = new Template($this->Command);
		$this->Template->render();
	}

	private function render_operation_failure($a_title, $a_message) {

		$this->Command->set_parameter("notification_title", $a_title);
		$this->Command->set_parameter("notification_message", $a_message);

		$this->Command->setAction("operation_failure");
		
		$this->Template = new Template($this->Command);
		$this->Template->render();
	
	}
			
	
	//TODO duplicated in Te,plate
	public function build_action_url($a_controller_name, $a_action, $a_parameters_string = null) {
        if (DEBUG) {
            $controller_file = REALPATH . "controllers/{$a_controller_name}.controller.php";
            if (!file_exists($controller_file)) {
                Throw new Exception("file $controller_file não existe", 1, null);
            } else {
                //validar a action.
            }
        }

        $active_site = $this->Command->get_parameter('active_site');
        $active_domain = $active_site['domain'];
        
	  $community = $this->Command->get_parameter('community');
        $community_name = $community['name'];
	  
	  $action_is_set = isset($a_action);
	  if($action_is_set){
		$controller_action_url = "{$active_domain}/{$community_name}/{$a_controller_name}/{$a_action}/";
	  }else{
		$controller_action_url = "{$active_domain}/{$community_name}/{$a_controller_name}/default/";		  
	  }
        if (isset($a_parameters_string)) {
            $controller_action_url = "$controller_action_url{$a_parameters_string}/";
        }
        $controller_action_url = declare_url($controller_action_url);

        return $controller_action_url;
    }
}

