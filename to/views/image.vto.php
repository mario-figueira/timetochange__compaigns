<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of image
 *
 * @author pmcosta
 */
require_once 'to/default.to.php';

class imageVTO extends defaultTO{
    public $filename;
    public $web_path;
    public $real_path;
    public $mime_type;
    
    public static function buil_image_vto_by_finelname_and_current_web_path($a_filename,$a_current_web_path = null){
	    $instance = new imageVTO();
	    $instance->filename = $a_filename;
	    $instance->real_path = REALPATH.'imgs/'.$a_filename;
	    if(isset($a_current_web_path) && !empty($a_current_web_path)){
		$instance->web_path = $a_current_web_path.'/imgs/'.$a_filename;
	    }
	    $arra_filename = split('\.', $a_filename);
	    $instance->mime_type = $arra_filename[1];
	    return $instance;
    }
}

?>
