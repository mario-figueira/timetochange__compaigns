<?php

require_once 'controllers/default.controller.php';

/**
 * Description of companies
 *
 * @author pmcosta
 */
class zzzDevPageController extends defaultController {

	public function _default() {
		
            $this->Template = new Template($this->Command);
            $this->Template->render();
	}
	public function _RenderNullBody() {
		
            $this->Template = new Template($this->Command);
            $this->Template->render();
	}

	public function _RenderPHPInfo() {
		
            $this->Template = new Template($this->Command);
            $this->Template->render();
	}
	
	public function _DumpSysvars() {
		
            $this->Template = new Template($this->Command);
            $this->Template->render();
	}
	
	

}

?>
