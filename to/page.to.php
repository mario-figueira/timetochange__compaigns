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

class pageTO extends defaultTO {

    public $id;
    public $original_name;
    public $fk_page_type_id;
    public $fk_site_id;
    public $is_active;
    public $menu_level;
    public $menu_order;
    private $page_type;
    public $printable_name = 'page has no name';

    function __set($name, $value) {
        if (property_exists($this, $name)) {
            if ('page_type' == $name) {
                DBCHelper2::assert_that()->the_param($value)->is_an_object_instance_of_the_class('page_typeTO');
            }
            $this->$name = $value;
            
        }
    }
    
    function __get($name) {
        if (property_exists($this, $name)) {
            return $this->$name;
        }
    }


}

?>
