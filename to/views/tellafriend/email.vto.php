<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of email
 *
 * @author pmcosta
 */
class emailVTO {
    
    protected $images = array();
    public $email_topo_img;
    
    public $see_in_a_web_browser_url;
    public $visible_in_browser = false;
    
    function addImage($key,$imageTO){
        require_once 'to/views/image.vto.php';
        if($imageTO instanceof imageVTO){
            $this->images[$key] = $imageTO;
        }else{
            //TODO
        }
    }
    
    function get_image($id){
        if(array_key_exists($id, $this->images)){
            return $this->images[$id];
        }else{
            //TODO
        }
    }
}

?>
