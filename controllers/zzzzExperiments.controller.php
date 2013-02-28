<?php

require_once 'controllers/default.controller.php';

class zzzzExperimentsController extends defaultController {

	public function _default() {
		parent::_default();
	}
	
	public function _rumbas(){
		try{
	$client = new SoapClient("http://localhost:3000/rumbas/wsdl", array(
        // Stuff for development.
        'trace' => 1,
        'exceptions' => true,
        'cache_wsdl' => WSDL_CACHE_NONE,
        'features' => SOAP_SINGLE_ELEMENT_ARRAYS,

        // Auth credentials for the SOAP request.
        //'login' => 'username',
        //'password' => 'password',

        // Proxy url.
        'proxy_host' => null, // Do not add the schema here (http or https). It won't work.
        'proxy_port' => null,

        // Auth credentials for the proxy.
        'proxy_login' => NULL,
        'proxy_password' => NULL,
    ) );
	$something =  $client->integer_to_string(array("Request1", 1));
}
 catch (Exception $e){
	 $i=1;
	 $i++;
	 
 }
 
	exit;
	}

	
}