<?php
define('ENVIRONMENT', 'LOCAL_DEVELOP'); //'LOCAL_DEVELOP', 'SHARED_DEVELOP', 'SHARED_DEVELOP_TEST', 'QUALIFICATION', 'CUSTOMER_ACCEPTANCE', 'CUSTOMER_SIMULATION', 

define('OFFLINE_CLEARANCE_LEVEL', "0"); //99-DEVELOP, 90-MANTAINANCE, 50-CUSTOMER_ACCEPTANCE, 0-PUBLIC_ACCESS

define('DEVELOP', true);
define('DEVELOP_VIEW_INFO', false);   // shows the view filename e the bottom of the center main div

define('ASSERTION_LEVEL', 3);
define('CAPTCHA_VERIFICATION', true);

define('DEBUG', true);
//define('DEBUG_PHP_ERROR_REPORTING', E_ALL);
define('DEBUG_PHP_ERROR_REPORTING', E_ALL && ~E_NOTICE && ~E_DEPRECATED);
define('DEBUG_PHP_DISPLAY_ERRORS', 1);
define('DEBUGLOG', false);
define('DEBUGFILE', 'D:/AWork_updigital/_src/wom_public/wom_public_debug.log.txt');
define('ERRORFILE', 'D:/AWork_updigital/_src/wom_public/wom_public_error.log.txt');

define('PRE_REGISTER_MAIL_RENDER_DEBUG',false);
/*SMTP moved to email_utils_config
define('SMTP_DEBUG',false);
define('SMTP_SERVER',"smtp.gmail.com");
define('SMTP_PORT',"587");
define('SMTP_USER',"");
define('SMTP_PASSWORD',"");
define('CATCH_ALL_EMAIL', "mfigbox@gmail.com");
*/
define('SITENAME','wom.com:8888');
define('REALPATH', 'D:/AWork_updigital/_src/wom_public/');
define('UPLOADDIR', REALPATH.'uploads/');

define('BASEPATH', 'http://wom.com:8888/');


define('APPMODE', 'FO');
define('BACKOFFICE', false);

define('DS', '/');

#db
define('DBHOST', 'localhost:3306');
define('DBHOSTPORT', '3306');
define('DBUSERNAME', 'root');
define('DBPASSWORD', 'pass');
define('DBNAME', 'dev_wom');

define('HIDE_LANDING_POP_VIDEO', true);
define('SHOW_CONTENT_ID', false);
define('INLINE_CONTENT_EDITING', false);
define('SHOW_FILE_PATHS_IN_HTML', false);

?>