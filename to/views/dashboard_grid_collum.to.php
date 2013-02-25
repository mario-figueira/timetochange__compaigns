<?php

class dashboard_grid_collumnTO {//extends defaultTO{

    protected $title;
    protected $class = "";
    protected $grid_tables = array();

    function __construct($title) {
        if (isset($title) && !empty($title)) {
            $this->title = $title;
        } else {
            throw new Exception("Invalide \$title['{$title}'] for construction of dashboard_grid_collumnTO");
        }
    }

    public function __set($property, $value) {
        if (property_exists($this, $property)) {

            switch ($property) {
                case 'grid_tables':
                    break;
                default:
                    $this->$property = $value;
            }
        }

        return $this;
    }

    function __get($name) {
        if (property_exists($this, $name)) {
            return $this->$name;
        }
    }

}