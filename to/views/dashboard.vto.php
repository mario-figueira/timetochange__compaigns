<?php

class dashboardVTO {//extends defaultTO{
	
	protected $grids;// grids are actualy rows in the main grid
	
	public function addGrid($grid){
		require_once REALPATH.'to/views/dashboard_grid.to.php';
		if($grid instanceof dashboard_gridTO){
			$this->grids[] = $grid;
		}
	}
	
	public function __getGrids(){
		return $this->grids;
	}
	
	function __get($name) {
		if (property_exists($this, $name)) {
			return $this->$name;
		}
	}
}