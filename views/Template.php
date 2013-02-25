<?php

class Template { 

    protected $variables = array();
    protected $_controller;
    protected $_action;

    function __construct($command) {
        require_once 'router/command.php';
        if ($command instanceof Command) {
            $this->_controller = $command->Name;
            $this->_action = $command->Action;
            $this->setParameters($command->Parameters);
            $this->set('original_action', $command->Action);
            $this->set('original_controller', $command->Name);
        }
    }

    /** Set Variables * */
    function setParameters($parameters) {
        if (is_array($parameters)) {
            foreach ($parameters as $key => $value) {
                $this->set($key, $value);
            }
        }
    }

    function set($name, $value) {
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

        $active_site = $this->variables['active_site'];
        $active_domain = $active_site['domain'];
        $image_url = "{$active_domain}/imgs/{$a_image_filename}";

        return $image_url;
    }
    
    public function build_flag_site_img_url($a_image_filename) {

        if (!isset($a_image_filename) or $a_image_filename == "") {
            return "";
        }

        $active_site = $this->variables['active_site'];
        $active_domain = $active_site['domain'];
        $image_url = "{$active_domain}/imgs/site_flags/{$a_image_filename}";

        return $image_url;
    }
    
    private function build_img_url_when_name_already_has_img_on_the_path($a_image_filename) {
	    
	    //todo: temporary function to be dropped in the future. it now required to handle imgs from the content_img table

        if (!isset($a_image_filename) or $a_image_filename == "") {
            return "";
        }

        $active_site = $this->variables['active_site'];
        $active_domain = $active_site['domain'];
        $image_url = "{$active_domain}/{$a_image_filename}";

        return $image_url;
    }

    private function build_uploaded_img_url($a_image_filename) {

        if (!isset($a_image_filename) or $a_image_filename == "") {
            return "";
        }

        $active_site = $this->variables['active_site'];
        $active_domain = $active_site['domain'];
        $image_url = "{$active_domain}/uploads/{$a_image_filename}";

        return $image_url;
    }

    private function build_uploaded_img_physical_path($a_image_filename) {

        if (!isset($a_image_filename) or $a_image_filename == "") {
            return "";
        }

        $active_site = $this->variables['active_site'];
        $active_domain = 
        $image_url = REALPATH ."/uploads/{$a_image_filename}";

        return $image_url;
    }

    private function build_img_url_OtherLocation($a_image_filename) {

        if (!isset($a_image_filename) or $a_image_filename == "") {
            return "";
        }

        $active_site = $this->variables['active_site'];
        $active_domain = $active_site['domain'];
        $image_url = "{$active_domain}/img/{$a_image_filename}";

        return $image_url;
    }

    private function build_pdf_download_url($a_basepath_relative_physical_location, $a_pdf_filename) {

        if (!isset($a_pdf_filename) or $a_pdf_filename == "") {
            return "";
        }

        $active_site = $this->variables['active_site'];
        $active_domain = $active_site['domain'];
        $physical_location = $active_domain . $a_basepath_relative_physical_location;
        //$pdf_download_url = "{$active_domain}/downloader/location/{$physical_location}/file/{$a_pdf_filename}/";
        //$pdf_url= declare_url($pdf_url);

        $pdf_download_url = "{$physical_location}{$a_pdf_filename}";

        return $pdf_download_url;
    }

    private function build_current_site_base_url() {
        $active_site = $this->variables['active_site'];
        $active_domain = $active_site['domain'];
        $community = $this->variables['community'];
        $community_name = $community['name'];
        $controller_action_url = "{$active_domain}/{$community_name}/";
        return $controller_action_url;
        
    }

    private function build_css_url($a_css_filename) {
    
    	if (!isset($a_css_filename) or $a_css_filename == "") {
    		return "";
    	}
    	 
    	$active_site = $this->variables['active_site'];
    	$active_domain = $active_site['domain'];
    	$image_url = "{$active_domain}/css/{$a_css_filename}";
    	 
    	return $image_url;
    }

    private function build_video_url($a_video_filename) {

        if (!isset($a_video_filename) or $a_video_filename == "") {
            return "";
        }

        $active_site = $this->variables['active_site'];
        $active_domain = $active_site['domain'];
        $video_url = "{$active_domain}/media/{$a_video_filename}";

        return $video_url;
    }

    
    
     private function  build_img_url_dashboard($a_img_fie_name){
    	if (!isset($a_img_fie_name) or $a_img_fie_name == "") {
    		return "";
    	}
    	 
    	$active_site = $this->variables['active_site'];
    	$active_domain = $active_site['domain'];
    	$img_url = "{$active_domain}/imgs/dashboard/{$a_img_fie_name}";
    	 
    	return $img_url;
    }
    
    /**
     * 
     * @return string
     */
    private function  build_js_url_dashboard($a_js_fie_name){
    	if (!isset($a_js_fie_name) or $a_js_fie_name == "") {
    		return "";
    	}
    	 
    	$active_site = $this->variables['active_site'];
    	$active_domain = $active_site['domain'];
    	$css_url = "{$active_domain}/js/dashboard/{$a_js_fie_name}";
    	 
    	return $css_url;
    }
    
    private function  build_js_url($a_js_fie_name){
    	if (!isset($a_js_fie_name) or $a_js_fie_name == "") {
    		return "";
    	}
    	 
    	$active_site = $this->variables['active_site'];
    	$active_domain = $active_site['domain'];
    	$css_url = "{$active_domain}/js/{$a_js_fie_name}";
    	 
    	return $css_url;
    }
    
    /**
     * 
     * @param string $a_css_filename
     * @return string
     */
    private function build_css_url_dashboard($a_css_filename) {

    	if (!isset($a_css_filename) or $a_css_filename == "") {
    		return "";
    	}
    	
    	$active_site = $this->variables['active_site'];
    	$active_domain = $active_site['domain'];
    	$css_url = "{$active_domain}/css/dashboard/{$a_css_filename}";
    	
    	return $css_url;
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

        $active_site = $this->variables['active_site'];
        $active_domain = $active_site['domain'];
        $community = $this->variables['community'];
        $community_name = $community['name'];
	  $action_is_set = isset($a_action);
	  
	  if($action_is_set){
		$controller_action_url = "{$active_domain}/{$community_name}/{$a_controller_name}/{$a_action}/";
	  }
	  else{
		$controller_action_url = "{$active_domain}/{$community_name}/{$a_controller_name}/default/";		  
	  }
        if (isset($a_parameters_string)) {
            $controller_action_url = "$controller_action_url{$a_parameters_string}/";
        }
        $controller_action_url = declare_url($controller_action_url);

        return $controller_action_url;
    }

    private function build_action_url__SPECIAL_CASE($a_relative_url, $a_parameters_string = null) {

        $active_site = $this->variables['active_site'];
        $active_domain = $active_site['domain'];
        $community = $this->variables['community'];
        $community_name = $community['name'];
        $relative_url = "{$active_domain}/{$community_name}{$a_relative_url}/";
        if (isset($a_parameters_string)) {
            $relative_url = "$relative_url{$a_parameters_string}/";
        }
        $relative_url = declare_url($relative_url);

        return $relative_url;
    }

	private function render_js_declarations(){
		$js = $this->variables['js'];
		$active_site = $this->variables['active_site'];
		$site_domain = $active_site['domain'];
		
		foreach ($js as $jsName) { 
?>
			<script 
				type="text/javascript" 
				src="<?php echo $site_domain . '/' . $jsName ?>"
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
        $template_variables = $this->variables;
        //$language = $country['name'];
        //$action = $this->_action;
        //$controller = $this->_controller;

        $v_active_domain = $active_site['domain'];
	  if(isset($country)&& isset($country['name'])&& !empty($country['name'])){
		  $country_name = $country['name'];
	  }else{
		  $country_name = '';
	  }
        $v_country_prefix = $v_active_domain . '/' . $country_name;

        if (file_exists(REALPATH . 'views/' . $this->_controller . '/' . $this->_action . '.php')) {
            $include_path = (REALPATH . 'views/' . $this->_controller . '/' . $this->_action . '.php');
        } else if (file_exists(REALPATH . 'views/' . $this->_controller . '/' . 'default.php')) {
            $include_path = (REALPATH . 'views/' . $this->_controller . '/' . 'default.php');
        } else if (file_exists(REALPATH . 'views/default/' . $this->_action . '.php')) {
            $include_path = (REALPATH . 'views/default/' . $this->_action . '.php');
        } else {
            if (DEBUG) {
                $messages[] = "Template: Cannot find in the views folder a suitable view component for the controller [$this->_controller] and the action [$this->_action].";
                $messages[] = "Template: Cannot find in the views folder a suitable view component for the controller [$this->_controller] and the action [default].";
                $messages[] = "Template: Cannot find in the views folder a suitable view component for the controller [default] and the action [$this->_action].";
            } else {
                $messages = array("Cannot find a suitable view component for the controller [$this->_controller] and the action [$this->_action].");
            }
            $include_path = (REALPATH . 'views/error/default' . '.php');
        }


        include $include_path;
	  
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

    public function overideAction($action) {
        $this->_action = $action;
        $this->set('action', $action);
    }

    public function overideController($controller) {
        $this->_controller = $controller;
        $this->set('controller', $controller);
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

    private function echo_variable($a_var_name, $a_default_value = '') {
        if (in_array($a_var_name, $this->variables)) {
            echo _($a_var_name);
        } else {
            echo _($a_default_value);
        }
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
    
    
    
    	function get_profile_image($a_ambassador_record){
		$ret_val = "";
		
		$picture_url = $this->build_img_url("foto_perfil_default.jpg");
		
		$picture_name = $a_ambassador_record['picture_url'];
		$picture_name_is_set = isset($picture_name);
		$picture_physical_path = $this->build_uploaded_img_physical_path($picture_name);
		$picture_physicalfile_exists = file_exists($picture_physical_path);

		if ($picture_name_is_set && $picture_physicalfile_exists) { 
			$picture_url = $this->build_uploaded_img_url($picture_name);
		}
		
		$ret_val = $picture_url;
		
		return $ret_val;
		
	}
	
	static function build_video_file_physical_path($a_video_file_file_name){

		  if (!isset($a_video_file_file_name) or $a_video_file_file_name == "") {
			return "";
		  }

		  $active_site = $this->variables['active_site'];
		  $video_file_physical_path = REALPATH ."/media/{$a_video_file_file_name}";

		  return $video_file_physical_path;		
	}


}
?>