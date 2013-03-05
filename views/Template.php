<?php

class Template { 

    protected $variables = array();
    protected $_controller;
    protected $_action;

    function __construct($a_controller, $a_command) {
        require_once 'router/command.php';
	    
		$this->_controller = $a_command->get_controller_name();
		$this->_action = $a_command->get_action();
		$this->set_parameters($a_command->get_parameters());
		$this->set_parameter('original_action', $a_command->get_action());
		$this->set_parameter('original_controller', $a_command->get_controller_name());
		
		require_once REALPATH ."enums/menu_items_enum.php";

		$selected_menu_value_to_check = $this->variables['selected_menu'];
		$selected_menu_is_set = isset($selected_menu_value_to_check);
		$selected_menu = $selected_menu_is_set?$selected_menu_value_to_check:menus_items_enum::$C_DASHBOARD;
		$this->set_parameter("selected_menu", $selected_menu);

    }

    /** Set Variables * */
    function set_parameters($parameters) {
        if (is_array($parameters)) {
            foreach ($parameters as $key => $value) {
                $this->set_parameter($key, $value);
            }
        }
    }

    function set_parameter($name, $value) {
        $this->variables[$name] = $value;
    }

    /** Display Template * */
    function render() {
        Logger::debug($this, 'RENDERING template' . $this);

        try {
            ob_start();

            if (isset($this->variables['ajax']) && $this->variables['ajax'] == 1) {
                $this->render_ajax();
            } else {			
		    $this->variables['ajax']=false;
                $this->render_default();
            }

            $html = ob_get_clean();
            echo $html;
        } catch (Exception $e) {
            // this error handler intercepts all renderization errors and redirects to 
            // to the view error with an suitable message where as the application is in debug mode or normal using mode
            ob_end_clean();
            $messages = array();
            if (DEBUG) {
                ob_start();

                var_dump($e);
                var_dump($this);
                $html = ob_get_clean();
                $messages[] = $html;
            } else {
                unset($messages); // to allow error view to display de default message
            }
            include "views/error/default.php";
        }
    }

    public function build_img_url($a_image_filename) {

        if (!isset($a_image_filename) or $a_image_filename == "") {
            return "";
        }

        $image_url = BASEPATH ."/img/{$a_image_filename}";

        return $image_url;
    }
    



    

    private function build_css_url($a_css_filename) {
    
    	if (!isset($a_css_filename) or $a_css_filename == "") {
    		return "";
    	}
    	 
    	$css_url = BASEPATH ."/css/{$a_css_filename}";
    	 
    	return $css_url;
    }

    
    private function build_video_url($a_video_filename) {

        if (!isset($a_video_filename) or $a_video_filename == "") {
            return "";
        }

        $video_url = BASEPATH ."/media/{$a_video_filename}";

        return $video_url;
    }

    
  

    
 
    //DUPLICATE IN RECOVER PASSWORD CONTROLLER DEAL WITH IT LATER
    public function build_action_url($a_controller_name, $a_action, $a_parameters_string = null) {
        if (DEBUG) {
            $controller_file = REALPATH . "controllers/{$a_controller_name}.controller.php";
            if (!file_exists($controller_file)) {
                Throw new Exception("file $controller_file não existe", 1, null);
            } else {
                //validar a action.
            }
        }

	  
	  $selected_menu_index = $this->variables['selected_menu'];
	  
	  require_once __DIR__ ."/action_url_builder.php";

	  $action_url_builder = new action_url_builder();
	  $controller_action_url = $action_url_builder->build_url($a_controller_name, $a_action, $selected_menu_index, $a_parameters_string);
	  

        return $controller_action_url;
    }
    
     
        
     public function build_select_menu_action_url($a_selected_menu) {
		DBCHelper2::require_that()->the_param($a_selected_menu)->is_an_integer_string();

		$ret_val = "";

		$menu_name = menus_items_enum::menu_item_2_name($a_selected_menu);
		$controller_name = $menu_name;
		$action_name = "home";

		$controller_action_url = BASEPATH . "{$controller_name}/{$action_name}/selected_menu/{$a_selected_menu}";

		$controller_action_url = declare_url($controller_action_url);

		$ret_val = $controller_action_url;

		DBCHelper2::ensure_that()->the_return_value($ret_val)->is_a_string();

		return $ret_val;
	}
    
    

	private function render_js_declarations(){
		$js = $this->variables['js'];
		
		foreach ($js as $jsName) { 
?>
			<script 
				type="text/javascript" 
				src="<?php echo BASEPATH . '/' . $jsName ?>"
			></script>
<?php 
		} 	    
	}
    
	private function render_ajax() {
		//$this->render_js_declarations();
		$this->render_common();
	}
    
    private function render_common() {
        Logger::debug($this, 'RENDERING template' . $this);
        extract($this->variables);


        if (file_exists(REALPATH . 'views/' . $this->_controller . '/' . $this->_action . '.php')) {		  
		$view_folder = REALPATH . 'views/' . $this->_controller; 
            $view_file = $view_folder . '/' . $this->_action . '.php';		
        } else if (file_exists(REALPATH . 'views/' . $this->_controller . '/' . 'default.php')) {
		$view_folder = REALPATH . 'views/' . $this->_controller; 
            $view_file = $view_folder . '/' . 'default.php';
        } else if (file_exists(REALPATH . 'views/default/' . $this->_action . '.php')) {
		$view_folder = REALPATH . 'views/default'; 
            $view_file = $view_folder .'/' . $this->_action . '.php';
        } else {
            if (DEBUG) {
                $messages[] = "Template: Cannot find in the views folder a suitable view component for the controller [$this->_controller] and the action [$this->_action].";
                $messages[] = "Template: Cannot find in the views folder a suitable view component for the controller [$this->_controller] and the action [default].";
                $messages[] = "Template: Cannot find in the views folder a suitable view component for the controller [default] and the action [$this->_action].";
            } else {
                $messages = array("Cannot find a suitable view component for the controller [$this->_controller] and the action [$this->_action].");
            }
            $view_file = (REALPATH . 'views/error/default' . '.php');
        }

	  
	  
	  $content_render_result = $this->render_to_string($view_file);
	  
	  $frame_file_to_check =  $view_folder .'/_frame.php';
	  $frame_exists = file_exists($frame_file_to_check);
	  if($frame_exists){
		  $frame_render_result = $this->render_to_string($frame_file_to_check);
	  }
	  else{
		  $frame_render_result = "{{content}}";
	  }
	  
	  $output = str_replace("{{content}}", $content_render_result , $frame_render_result);

	  
	  echo $output;
	  
	  
	  if(DEVELOP_VIEW_INFO===TRUE){
?>
<div id="zzzDEVELOP_VIEW_INFO">
	zzzDEVELOP_VIEW_INFO:<br/>
		requested controller: <?php echo $this->_controller; ?>
		<br/>
		requested action: <?php echo $this->_Action; ?>
		<br/>
		view file: <?php echo $include_path; ?>
</div>
<?php	  
	  }
    }
    
    private function render_to_string($a_file){
	$ret_val = "";
	
      extract($this->variables);

	ob_start();
	include $a_file;
	$rendering_result = ob_get_contents(); 
	ob_end_clean();
	
	$ret_val = $rendering_result;
	
	return $ret_val;
    }

    private function render_default() {
        extract($this->variables);
        $template_variables = $this->variables;

        $header_file = $this->compute_header_file_to_use();

        Logger::debug($this, "including header[$header_file]");
        DBCHelper2::assert_that()->the_file($header_file)->exists();
        include $header_file;

        try {
            ob_start();
            $this->render_common();
            $html = ob_get_clean();
            echo $html;
        } catch (Exception $e) {
            // this error handler intercepts all renderization errors and redirects to 
            // to the view error with an suitable message where as the application is in debug mode or normal using mode
            ob_end_clean();
            $messages = array();
            if (DEBUG) {
                ob_start();
                var_dump($e);
                var_dump($this);
                $html = ob_get_clean();
                $messages[] = $html;
            } else {
                unset($messages); // to allow error view to display de default message
            }
            include "views/error/default.php";
        }

        if (file_exists(REALPATH . 'views/' . $this->_controller . '/' . 'footer.php')) {
            include (REALPATH . 'views/' . $this->_controller . '/' . 'footer.php');
        } else if (file_exists(REALPATH . 'views/footer.php')) {
            include (REALPATH . 'views/footer.php');
        }
    }

    public function override_action($action) {
        $this->_action = $action;
        $this->set_parameter('action', $action);
    }

    public function override_controller($controller) {
        $this->_controller = $controller;
        $this->set_parameter('controller', $controller);
    }

    function __toString() {
        return 'controller[' . $this->_controller . '] action[' . $this->_action . ']';
    }

    function DisplayServerErrorIfNecessary($a_fieldName) {
        $variablename = $a_fieldName . '_error';
        ?>
        <label class="error" generated="true"><?php echo $this->variables[$variablename]; ?></label>
        <?php
    }

    private function compute_header_file_to_use() {
        $default_header_file = REALPATH . 'views/header.php';
        $ret_val = $default_header_file; //by default use the default header
        //if exists a specific controller header use it instead of the default
        $specific_controller_header_file = REALPATH . 'views/' . $this->_controller . '/header.php';
        if (file_exists($specific_controller_header_file)) {
            $ret_val = $specific_controller_header_file;
        }

        //if exists a specific controller action header use it instead of the default or the controller specific
        $specific_controller_action_header_file = REALPATH . 'views/' . $this->_controller . '/' . $this->_action . '.header.php';
        if (file_exists($specific_controller_action_header_file)) {
            $ret_val = $specific_controller_action_header_file;
        }

        DBCHelper2::ensure_that()->the_return_value($ret_val)->is_a_string();
        return $ret_val;
    }

    private function compute_footer_file_to_use() {
        $ret_val = "";



        DBCHelper2::ensure_that()->the_return_value($ret_val)->is_a_string();
        return $ret_val;
    }
	
    private function specific_css_behaviour() {
        $specific_css_path = null;
        //if exists a specific controller css use it instead of the default
        $specific_controller_css_path = REALPATH . 'views/' . $this->_controller . '/styles.css';
        if (file_exists($specific_controller_css_path)) {
            $specific_css_path = $specific_controller_css_path;
        }

        //if exists a specific controller action header use it instead of the default or the controller specific
        $specific_controller_action_css_path = REALPATH . 'views/' . $this->_controller . '/' . $this->_action . '.styles.css';
        if (file_exists($specific_controller_action_css_path)) {
            $specific_css_path = $specific_controller_action_css_path;
        }

        if (isset($specific_css_path)) {
            ?>  		  
            <link 
                href="<?php echo $specific_css_path; ?>" 
                rel="stylesheet"
                type="text/css" />					
            <?php
        }
    }
    
    
   
	
	static function build_video_file_physical_path($a_video_file_file_name){

		  if (!isset($a_video_file_file_name) or $a_video_file_file_name == "") {
			return "";
		  }

		  $video_file_physical_path = REALPATH ."/media/{$a_video_file_file_name}";

		  return $video_file_physical_path;		
	}


	static function empty2nbsp($a_value){
		$ret_val = "";
		$value= $a_value;
		$value_is_empty = !isset($value) || empty($value) || trim($value)==="";
		if($value_is_empty){
			$value = "&nbsp";
		}
		$ret_val = $value;
		return $ret_val;
	}
}
?>