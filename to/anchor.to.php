<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ambassadorTO
 *
 * @author pmcosta
 */
require_once 'to/default.to.php';
require_once 'to/page_type.to.php';
require_once 'to/page.to.php';

class anchorTO extends defaultTO {
    
    public $url;
    public $target;
    public $name;
    public $img_url;
    public $url_type; //app_action or full_external
    public $class;
    public $active = false;

    public static function build_from_page($a_pageTO = NULL){
        $instance = new anchorTO(null);
        if($a_pageTO instanceof pageTO){
            $page_type = $a_pageTO->page_type;
            if($page_type instanceof page_typeTO){
                $instance->url = $page_type->controller."/".$page_type->action;
                $instance->target = '_self';
                $instance->name = $a_pageTO->printable_name;
		    $instance->url_type = "app_action";
            }else{
                throw new Exception('build_from_page only acepts pageTO with page_type',1,NULL);
            }
        }else{
                throw new Exception('build_from_page only acepts pageTO as argument',1,NULL);
        }
        
        return $instance;
    }
}

?>
