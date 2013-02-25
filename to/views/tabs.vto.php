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
class tabsVTO extends defaultTO{
    
    protected $tabs = array();
    
    function addTab($anchor) {
        require_once 'to/views/anchor.to.php';
        if($anchor instanceof anchorTO){
            $this->tabs[] = $anchor;
        }else{
            //TODO
        }
    }
    
}

?>
