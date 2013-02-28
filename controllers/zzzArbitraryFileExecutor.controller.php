<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of zzzArbitraryFileExecutor
 *
 * @author mfigueira
 */
include_once 'controllers/default.controller.php';

class zzzArbitraryFileExecutorController extends defaultController {
	function _execute() {
		if (!DEBUG) {
			Logger::debug($this, "Didn't run. For security reasons only works in debug mode.");
			return;
		}

		$include_path = $this->Command->get_parameters('file');
		$include_path = str_replace('_DS_', '\\', $include_path);
		include_once $include_path;
	}

}

?>
