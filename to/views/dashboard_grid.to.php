<?php
class dashboard_gridTO {//extends defaultTO{
	
	protected $grid_cols;
        
        public function __construct($title){
            if(isset($title) && !empty($title)){
                    $this->title = $title;
            }else{
                    throw new Exception("Invalide \$title['{$title}'] for construction of dashboard_grid_collumnTO");
            }
        }
	public function __set($property, $value) {
		if (property_exists($this, $property)) {
			
			switch ($property){
				case 'grid_cols':
					//grid cols shouldnt be set possibly throw exception
					break;
				default:
					$this->$property = $value;
			}
		}
	
		return $this;
	}
	
	public function addCol($col){
		require_once REALPATH.'to/views/dashboard_grid_collum.to.php';
		if($col instanceof dashboard_grid_collumnTO){
			$this->grid_cols[] = $col;
		}
	}
	
	function __get($name) {
        if (property_exists($this, $name)) {
            return $this->$name;
        }
    }
	
}