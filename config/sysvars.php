<?php

define('ENVIRONMENT', 'LOCAL_DEVELOP'); //'LOCAL_DEVELOP', 'SHARED_DEVELOP', 'SHARED_DEVELOP_TEST', 'QUALIFICATION', 'CUSTOMER_ACCEPTANCE', 'CUSTOMER_SIMULATION','CUSTOMER_PRODUCTION' 
define('ENVIRONMENT_OWNER', 'mfigueira'); 

 
//define('IS_OFFLINE', false);
define('OFFLINE_CLEARANCE_LEVEL', "0"); //99-DEVELOP, 90-MANTAINANCE, 50-CUSTOMER_ACCEPTANCE, 0-PUBLIC_ACCESS

define('DEVELOP', true);
define('DEVELOP_VIEW_INFO', false);   // shows the view filename e the bottom of the center main div

define('ASSERTION_LEVEL', 3);
define('CAPTCHA_VERIFICATION', false);

define('DEBUG', true);
//define('DEBUG_PHP_ERROR_REPORTING', E_ALL);
//define('DEBUG_PHP_ERROR_REPORTING', E_ALL ^ E_DEPRECATED);
define('DEBUG_PHP_ERROR_REPORTING', E_ALL ^ E_NOTICE ^ E_DEPRECATED);
define('DEBUG_PHP_DISPLAY_ERRORS', 1);
define('DEBUGLOG', false);
define('DEBUGFILE', 'D:/AWork_PHP/___mvc_template/_src/logs/debug.log.txt');
define('ERRORFILE', 'D:/AWork_PHP/___mvc_template/_src/logs/error.log.txt');


//SMTP
define('SMTP_DEBUG',false);



define('SITENAME','mvc_template.com:8888');
define('REALPATH', 'D:/AWork_PHP/___mvc_template/_src/');
define('UPLOADDIR', REALPATH.'uploads/');

define('BASEPATH', 'http://mvc_template.com:8888/');


define('APPMODE', 'FO');
define('BACKOFFICE', false);

define('DS', '/');

#db
define('DBHOSTPORT', '3336');
define('DBHOST', 'localhost');
define('DBUSERNAME', 'root');
define('DBPASSWORD', 'pass');

//define('DBNAME', 'wom_3');
//define('DBNAME', 'wom_merged');

//define('DBNAME', 'wom_script_test');
define('DBNAME', 'mvc__template');

 
define('HIDE_LANDING_POP_VIDEO', false);
//define('SHOW_CONTENT_ID', true);
define('INLINE_CONTENT_EDITING', true);
define('SHOW_FILE_PATHS_IN_HTML', true);


?>