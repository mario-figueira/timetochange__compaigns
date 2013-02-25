<?php
//
//ATENÇÃO COM CÒDIGO COLOCADO ANTES DO BLOCO DE PRE-BOOTSTRAP DE INICIALIZAÇÂO, COSTUMA DAR RAIA
//

// for full debug of sysvars.php
//error_reporting(E_ALL);
//ini_set('display_errors', 1);

//set_error_handler(
//	 function ($errno, $errstr, $errfile, $errline){	
//		echo $errno;
//		exit;
//	}
//);
//
//set_exception_handler(	 
//	  function (Exception $exception){	
//		echo $exception->getCode();
//		echo $exception->getMessage();
//		exit;
//	}
//);
//
//$msg = "";
//$bootstrap_step = "0000";
//
//$arra = array();
////echo $arra[10];
//
////$qq->andre();
//throw new Exception('mensagem',1, null);



// pre-bootstrap 
//	session starting
//	loading of minimal configuration, assertion and logging support
try {
	
	$bootstrap_step = "0001";
	ini_set('default_charset', 'utf-8');
	
	$bootstrap_step = "0002";
	header('Content-Type: text/html; charset=utf-8'); //MUITO MUITO IMPORTANTE

	
	$bootstrap_step = "0003";
	require_once 'config/sysvars.php';
	
	if (DEBUG) {
		if (!defined('DEBUG_PHP_ERROR_REPORTING')) {
			define('DEBUG_PHP_ERROR_REPORTING', 0);
		}
		error_reporting(DEBUG_PHP_ERROR_REPORTING);

		if (!defined('DEBUG_PHP_DISPLAY_ERRORS')) {
			define('DEBUG_PHP_DISPLAY_ERRORS', 0);
		}
		ini_set('display_errors', DEBUG_PHP_DISPLAY_ERRORS);
	} else {
		error_reporting(0);
		ini_set('display_errors', 0);
	}
 
 
	$bootstrap_step = "0004";
	date_default_timezone_set('Europe/Lisbon');

	$bootstrap_step = "0006";
	session_start();


	$bootstrap_step = "0008";
	require_once 'util/DBCHelper.php';
	$bootstrap_step = "0010";
	require_once 'util/Logger.php';
} catch (Exception $e) {
	$msg = "PRE-BOOTSTRAP ERROR: Sorry an error ocurred while executing pre-bootstrap step: [$bootstrap_step].";
	echo $msg;
	exit;
}


if(ENVIRONMENT=='LOCAL_DEVELOP' && DEVELOP==true && ENVIRONMENT_OWNER == 'mfigueira'){
    //TODO mario reve o handling de erros sff
    try {
        //require_once REALPATH . "generate_translation_file.php";
    } catch (Exception $e) {
        $msg = "PRE-BOOTSTRAP ERROR: Sorry an error ocurred while executing pre-bootstrap step: [$bootstrap_step].";
        if(DEBUG){
            //echo $e['xdebug_message'];
            var_dump($e);
        }
        echo $msg;
        exit;
    }
}


if(ENVIRONMENT=='LOCAL_DEVELOP' && DEVELOP==true && ENVIRONMENT_OWNER == 'mfigueira'){
	//keep it commented
	//require_once REALPATH ."repositories/repository.FACTORY.TESTS.php";
	//repository__FACTORY__TESTS::run();

	//require_once REALPATH ."business_entities/ztest.BE.TESTS.php";
	//ztest__BE__Tests::run();
}



// bootstrap fase 1
//	basic system loading and initialization
//	routing loading and initialization
try {



	$bootstrap_step = "0260";
	require_once 'router/url_interperter.php';
	$bootstrap_step = "0270";
	require_once 'router/command.php';
	$bootstrap_step = "0280";
	require_once 'router/command_dispatcher.php';
	$bootstrap_step = "0290";
	require_once 'Auth.php';
} catch (Exception $e) {
	$msg = "BOOTSTRAP FASE 1 ERROR: An error ocurred while executing bootstrap fase one step: [$bootstrap_step].";
	Logger::exception(null, $e);
	nice_error_message_show();
	if (DEBUG) {
		echo $msg;
		var_dump($e);
	} else {
		
	}
	exit;
}



// bootstrap command interpretation fase
//	dispatching
try {

	$bootstrap_step = "1010";
	
	$url = $_SERVER['PATH_INFO'];
	$interpreter = new url_interpreter($url);

	//throw new Exception("forced exception", 9999, null);

	$bootstrap_step = "1020";
	$command = $interpreter->command__get();
} catch (Exception $e) {
	$msg = "BOOTSTRAP COMMAND INTERPRETATION FASE ERROR: An error ocurred while executing the command interpretation step: [$bootstrap_step].";
	Logger::exception(null, $e);
	nice_error_message_show();
	if (DEBUG) {
		echo $msg;
		var_dump($e);
	} else {
		
	}
	exit;
}

// bootstrap dispatching fase
//	dispatching
try {
	$bootstrap_step = "1030";
	$commandDispatcher = new command_dispatcher($command);

	$bootstrap_step = "1040";
	$commandDispatcher->dispatch();
} catch (Exception $e) {
	$msg = "BOOTSTRAP DISPATCH FASE ERROR: An error ocurred while executing the dispatching step: [$bootstrap_step].";
	Logger::exception(null, $e);
	nice_error_message_show();
	if (DEBUG) {
		echo $msg;
		var_dump($e);
	} else {
		
	}
	exit;
}

function nice_error_message_show() {
	include "views/bootstrap_error_msg.php";
}

function declare_url($a_url) {
	$ret_val = add_debug_to_url($a_url);

	DBCHelper2::ensure_that()->the_return_value($ret_val)->is_a_string();
	return $ret_val;
}

function add_debug_to_url($a_url) {
	$ret_val = $a_url;

	if (DEBUG) {
		$ret_val = $ret_val . "?XDEBUG_SESSION_START=netbeans-xdebug";
	}

	DBCHelper2::ensure_that()->the_return_value($ret_val)->is_a_string();
	return $ret_val;
}




//http://mvc_template.com:8888/hello/world/param1/param1value/param2/param2value?XDEBUG_SESSION_START=netbeans-xdebug
?>





