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
class tabs_navigatorVTO {
    
    protected $tabs = array();
    
    
    public function __construct($tabs_navigator,$page_content,$bottom_navigator){

    }
    
    public function __set($tab_name, $tab_name) {
        if($value instanceof tabVTO){
            $tabs[$tab_name] = $tab_name;
        }
    }
}
?>
