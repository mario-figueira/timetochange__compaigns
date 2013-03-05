<?php


require_once REALPATH . 'util/DBCHelper.php';
require_once 'Auth.php';
require_once REALPATH . 'views/Template.php';

require_once REALPATH . 'util/facebook/facebook.php';
require_once REALPATH . 'util/twitteroauth/twitteroauth.php';

define("DEFAULT_CONTROLLER_NAME", "default");
define("DEFAULT_ACTION_NAME", "default");

/**
 * 
 */
class defaultController {

	protected $auth;
	protected $Command;
	private $Template;
	private $fb_app_id;
	private $fb_secret;
	private $fb_app_url;
	private $twitter_key;
	private $twitter_secret;

	function __construct($a_command) {
		DBCHelper2::require_that()->the_param($a_command)->is_an_object_instance_of_the_class("Command");

		Logger::debug($this, '__contruct(' . $a_command . ')');

		$this->Command = $a_command;
		

		$this->start_pear_auth();
		
		if($this->auth->checkAuth()){
			$this->Command->set_is_logged_in();
		}

		$this->load_site();
		
			
		DBCHelper2::ensure_that()->the_variable($this->Command)->is_an_object_instance_of_the_class("Command");
	}


	private function load_default_css() {

		//$this->Command->add_css("js/jsjquery-ui-1.8.23.custom_allmodules/css/ui-lightness/jquery-ui-1.8.23.custom.css{$timestamp}");
		//$this->Command->add_css("js/tinybox2/style.css{$timestamp}");

		$this->Command->add_css("css/reset.css{$timestamp}");
		$this->Command->add_css("css/global.css{$timestamp}");
		
	}

	private function load_default_js() {
		//$jsArray[] = 'js/libs/jquery-1.7.1.min.js';
		//$jsArray[] = 'js/libs/modernizr-2.5.3.min.js';
		//$jsArray[] = 'js/tinybox2/tinybox.js';
		//$jsArray[] = 'js/jquery.form.js';
		//$jsArray[] = "js/jquery.validate.jform.js";
		//$jsArray[] = "js/jsjquery-ui-1.8.23.custom_allmodules/js/jquery-ui-1.8.23.custom.min.js";
		

		$this->Command->add_js('js/jquery-1.9.0.js');
		$this->Command->add_js('js/jquery-ui-1.10.0.custom.js');
		$this->Command->add_js('js/jquery.form.v3_27.js');		
		$this->Command->add_js('js/global.js');
		$this->Command->add_js('js/timetochange__framework.js');
	}


	private function load_site() {
		try {
				//TODO remover isto e respectivas utilizações

				//$this->load_language();
				//$language_record = $this->Command->get_parameter('language');
				//$this->load_locales($language_record);
				$this->load_default_css();
				$this->load_default_js();
				
				//$this->load_headder();
				//$this->load_footer();
		} catch (Exception $e) {
			Logger::exception($this, $e);
			Logger::debug($this, 'Exception getting Active site.' . $e->getMessage());
			//$this->Command->add_message( $e->getMessage());
			//$this->_error();
			throw $e;
		}
	}

	private static $C_DEFAULT_CALL_UNLOCK_KEY = "tranca_do_default";

	protected function _default($a_unlock_key = null) {
		$unlock_key = $a_unlock_key[0];
		$was_passed_a_correct_unlock_key = ($unlock_key == self::$C_DEFAULT_CALL_UNLOCK_KEY);
		if (!$was_passed_a_correct_unlock_key) {
			throw new Exception("Default.Default não pode ser chamado directamente. Usa o defaultAction", 1, null);
		}
		try {
			$this->default_FO();
		} catch (Exception $e) {
			Logger::exception($this, $e);
			Logger::debug($this, 'Exception while executing the default action of the default controller. The exception message was:' . $e->getMessage());
			throw $e;
		}

		$this->_defaultAction();
	}

	private function default_FO() {


	}





	function _defaultAction() {
			try {
				//$this->load_ambassador_values();
				//$parent_code = $this->Command->get_variable_from_context('parent_code','',FALSE);
				//$_SESSION['parent_code'] = $parent_code;
				//$this->Command->set_parameter('parent_code', $parent_code,false);
				$this->Template = new Template($this, $this->Command);
				$this->Template->render();
			} catch (Exception $e) {
				$this->Command->add_message($e->getMessage());
				$this->_error();
			}
		
	}

	function _error($a_message = null, $a_exception = null, $a_code = null) {
		if ($a_message) {
			$this->Command->add_message($a_message);
		}
		if ($a_code) {
			$this->Command->add_message($a_code);
		}

		if (DEBUG) {
			$msg = print_r($a_exception, true);
			$msg = nl2br($msg);
			$this->Command->add_message($msg);
		}
		$this->Template = new Template($this, $this->Command);
		$this->Template->override_controller('error');
		$this->Template->override_action('default');


		//$this->Template->
		$this->Template->render();
		exit;
	}

	protected function execute_action_class(){
			$controller_name = $this->Command->get_controller_name();
			$action = $this->Command->get_action();

			$action_class_file_name = REALPATH ."/controllers/{$controller_name}.actions/{$action}.action.php";
			$exists_an_action_class= file_exists($action_class_file_name);
			if($exists_an_action_class){
				require_once $action_class_file_name;
				
			}
			
			$action_class_name = "{$action}Action";
			$exists_action_class_name = class_exists($action_class_name);
			if($exists_action_class_name){
				$action_object = new  $action_class_name();
				$action_object->execute($this->Command);
			}
		
	}
	
	function execute() {
		Logger::debug($this, 'execute - BEGIN ');
		DBCHelper2::require_that()->the_variable($this->Command)->is_an_object_instance_of_the_class("Command");

		$action = $this->Command->get_action();
		$action_is_defined = !empty($action);

		if (!$action_is_defined) {
			$action = DEFAULT_ACTION_NAME;
		}

		try {
			$controller_name = $this->Command->get_controller_name();


				$action_corresponds_to_callable_method = is_callable(array(& $this, '_' . $action));

				if (!$action_corresponds_to_callable_method) {
					$method_name = '_' . $action;
					$class_name = get_class($this);
					$display_msg = "The requested action [{$action}] is NOT CALLABLE.";
					$log_msg = "The method [{$method_name}] of the class [{$class_name}] that corresponds to the requested action [{$action}] of the controller [{$controller_name}] is NOT CALLABLE.";

					if (DEBUG) {
						$display_msg = $log_msg;
					}

					Logger::debug($this, $log_msg);

					if (DEBUG) {
						throw new Exception($log_msg, 1, null);
					} else {
						$this->Command->add_message($display_msg);
						$this->_error();
					}
				} else {

					Logger::debug($this, 'executing ' . $action);

					$var_controllername = $this->Command->get_controller_name();

					$is_default_controller = ($var_controllername == DEFAULT_CONTROLLER_NAME);
					$is_default_action = ($action == DEFAULT_ACTION_NAME);
					$is_default_controller_and_default_action = ($is_default_controller && $is_default_action);

					//set_error_handler(array(get_class(),'_error'));
					if ($is_default_controller_and_default_action) {
						call_user_func(array(& $this, '_' . $action), array(self::$C_DEFAULT_CALL_UNLOCK_KEY));
					} else {
						call_user_func(array(& $this, '_' . $action));
					}
				}
			
		} catch (Exception $e) {
			$display_msg = _("Lamentamos imenso o sucedido mas uma situação imprevista inviabilizou a satisfação do pedido com sucesso");
			$log_msg = $display_msg . "The error was: \r\n" . $e->getMessage();
			if (DEBUG) {
				$display_msg = $log_msg;
			}
			Logger::debug($this, $log_msg);
			$this->Command->add_message($display_msg);
			$this->_error(null, $e);
		}
	}

	/* DATABASE OPERATIONS */

/*
	function _login() {

		$this->auth->logout();
		$this->start_pear_auth();

		$json_reply = array();
		$json_reply['code'] = 0;
		$json_reply['message'] = 'Nothing happend';
		$json_reply['printable_message'] = '';

		$auth_status = $this->auth->getStatus();
		switch ($auth_status) {
			case -1:
				$json_reply['code'] = -1;
				$json_reply['message'] = 'Session exceeded idle time';
				$json_reply['printable_message'] = _("login_box::message - Login session expired.");
				break;
			case -2:
				$json_reply['code'] = -2;
				$json_reply['message'] = 'Session expired';
				$json_reply['printable_message'] = _("login_box::message - Login session expired.");
				break;
			case -3:
				$json_reply['code'] = -3;
				$json_reply['message'] = 'Invalid login';
				$json_reply['printable_message'] = _("login_box::message - Inválid login credentials.");
				break;
			case -4:
				$json_reply['code'] = -4;
				$json_reply['message'] = 'Unexpected error (AUTH_METHOD_NOT_SUPPORTED)';
				$json_reply['printable_message'] = _("login_box::message - Unexpected error. Please try later!");
				break;
			case -5:
				$json_reply['code'] = -5;
				$json_reply['message'] = 'Unexpected error (AUTH_SECURITY_BREACH)';
				$json_reply['printable_message'] = _("login_box::message - Unexpected error. Please try later!");
				break;
			case -6:
				$json_reply['code'] = -6;
				$json_reply['message'] = 'Unexpected error (AUTH_CALLBACK_ABORT) Session Aborted';
				$json_reply['printable_message'] = _("login_box::message - Unexpected error. Please try later!");
				break;
			default:
				break;
		}

		if ($this->auth->checkAuth()) {
			$json_reply['code'] = 1;
			$json_reply['message'] = 'Success';
			$json_reply['printable_message'] = "";
			if (!BACKOFFICE) {
				$this->set_current_user();
				//raise the login event on the user points sub-system
				$ambassador = $this->Command->get_parameter('ambassador');
				$ambassador_id = $ambassador['id'];
				require_once REALPATH . 'classes/ambassador.php';
				$ambassador = new ambassador($ambassador_id);
				$event_processor = $GLOBALS['event_processor'];
				$event_processor->event_process(event_type::$login, $ambassador, null);


				$this->set_cookie();
			}
		}

		echo json_encode($json_reply);
	}
*/
	
	function logout() {
		$this->auth->logout();
		$this->Command->reset_is_logged();
		//$this->auth->start();
	}
	
/*	
	function _logout() {
		$this->auth->logout();
		$cookie_expire = time() - 3600;
		$date = date('Y-m-d h:',$cookie_expire);
		$cookie_set_ret_val = setcookie("wrm", "", $cookie_expire, '/');
		$cookie_set_ret_val = setcookie("wrm_temp", "tmp", $cookie_expire, '/');
		unset($cookie_set_ret_val);
		unset($_COOKIE['wrm']);
		$this->auth->start();
		$this->Command->reset_is_logged_in_and_update_site_mode();
		$this->Command->set_action('default');
		$this->default_FO();
		//TODO remover o carregamento dos menus do contrutor e passar para os metodos
		$this->load_main_menu();
		$this->load_footer();
		$this->Template = new Template($this->Command);
		$this->Template->render();
	}
*/
	
	protected function start_pear_auth() {
		/* HANDLE AUTH */
		
		require_once REALPATH .'enums/user_registration_status.php';
		
		try {
			
			//$active_site = $this->Command->get_active_site();
			//$active_site_id = $active_site['id'];


			$community_name = "default";
			$cookie_name = "ttc_{$community_name}";

			$sessionName = $cookie_name;

			$dbusername = DBUSERNAME;
			$dbpassword = DBPASSWORD;
			$dbhost = DBHOST;
			$dbhostport = DBHOSTPORT;
			$dbname = DBNAME;
			$dbhostfullname = "";
			if(empty($dbhostport)){
				$dbhostfullname = "{$dbhost}";
			}else{
				$dbhostfullname = "{$dbhost}:{$dbhostport}";
			}
			
			$dsn_str = "mysql://{$dbusername}:{$dbpassword}@{$dbhostfullname}/{$dbname}";
			$options = array(
			    'dsn' => $dsn_str
			    , 'usernamecol' => 'email'
			    , 'passwordcol' => 'password'
			    , 'table' => 'user'
			    /*, 'db_fields' => array('id', 'name', 'surname')
			    , 'db_where' => "( status==1 )"
			    , 'sessionName' => $sessionName*/
			);
			

			$auth = new Auth('MDB2', $options, '', false);


			$auth_start_res = $auth->start();
			
			$this->auth = $auth;
		} catch (Exception $e) {
			throw $e;
		}
	}

	/* AFOA */

	private function setSocialSettings() {
		try {
			$this->Command->set_parameter('fb_app_id', '241504035968115'); //@TODO load dinamucly
			$this->Command->set_parameter('fb_secret', '743c324e894290debfa8c7d799dec246'); //@TODO load dinamucly
			$this->Command->set_parameter('fb_app_url', BASEPATH . '/' . $this->Command->get_parameters('language'));


			$this->Command->set_parameter('twitter_key', 'j97sAUJ7YEdZgt0eD7Uw');
			$this->Command->set_parameter('twitter_secret', 'tozPOTkm2qQDFBzB3Fa1ouZEblPhWHgBwyW9wJz90Nw');
		} catch (Exception $e) {
			Logger::exception($this, $e);
			throw $e;
		}
	}

	private function authTwitter() {
		//obter twitter user  para poder obter o id
		session_start();

		require_once REALPATH . 'util/twitteroauth/lib/EpiCurl.php';
		require_once REALPATH . 'util/twitteroauth/lib/EpiOAuth.php';
		require_once REALPATH . 'util/twitteroauth/lib/EpiTwitter.php';
		require_once REALPATH . 'util/twitteroauth/lib/secret.php';

		$twitterObj = new EpiTwitter($consumer_key, $consumer_secret);

		$twitterObj->setToken($_GET['oauth_token']);
		$token = $twitterObj->getAccessToken();
		$twitterObj->setToken($token->oauth_token, $token->oauth_token_secret);
		$_SESSION['ot'] = $token->oauth_token;
		$_SESSION['ots'] = $token->oauth_token_secret;
		$twitterInfo = $twitterObj->get_accountVerify_credentials();
		$twitterInfo->response;

		$username = $twitterInfo->screen_name;
		$urlImage = $twitterInfo->profile_image_url;
		$first_name = $twitterInfo->name;

		$user_id = '';

		require_once REALPATH . 'model/ambassador.model.php';
		$ambassador_model = new ambassadorModel();

		if ($appUser) {
			$this->auth->setAuth($appUser['email']);
		} else {
			header('location:' . BASEPATH . $country['name'] . '/registration/default/sistema/TWITTER/external_user_id/' . $user_id . '/email//first_name/' . $first_name . '/last_name//picure_url/' . $urlImage . '/gender//');
		}


		if ($appUser) {
			$this->auth->setAuth($appUser['email']);
		} else {
			header('location:' . BASEPATH . $country['name'] . '/registration/default/sistema/TWITTER/external_user_id/' . $user_id . '/email//first_name/' . $first_name . '/last_name//picure_url/' . $urlImage . '/gender//');
		}
	}

	private function authFacebook() {
		try {
			$facebook = new Facebook(array('appId' => $this->fb_app_id, 'secret' => $this->fb_secret, 'cookie' => true));

			$facebook_user_id = $facebook->getUser();
			if ($facebook_user_id) {
				try {
					// Proceed knowing you have a logged in user who's authenticated.
					$user_profile = $facebook->api('/me');
				} catch (FacebookApiException $e) {
					Logger::exception($this, $e);
					$facebook_user_id = null;
				}
			}

			// 	n or logout url will be needed depending on current user state.
			if ($user_profile) {
				$user_email = $user_profile['email'];
				$user_id = $user_profile['id'];

				require_once REALPATH . 'model/ambassador.model.php';
				$ambassador_model = new ambassadorModel();

				$appUser = $ambassador_model->get_user_by_sistema_and_external_user_id('FACEBOOK', $user_id);

				if ($appUser) {
					$this->auth->setAuth($appUser['email']);
					//$aut_data = $this->auth->getAuthData();
					$this->Command->set_parameter('ambassador', $appUser);
				} else {
					$appUser = $ambassador_model->get_ambassador_by_email($user_email);

					//verificar se existe na base de dados
					$existe_registo = ($appUser != null);
					if ($existe_registo) { //se existir faço login com esse user
						//associa, insere registo na tabela external_users
						$external_users_model = new defaultModel('external_users');
						$result = $external_users_model->persist(array('sistema' => 'FACEBOOK', external_user_id => $user_id, 'fk_ambassador_id' => $appUser['id']));
						if ($result['boolean']) {
							$this->auth->setAuth($user_email);
						} else {
							if (DEBUG) {
								$this->Command->add_message($result['message']);
							} else {
								$this->Command->add_message('Unexpected error! Try again later.');
							}
						}
						//faz login,ver peer auth visto não termos password
					} else { //se não existir mando para a pagina de registo // Se não tiver o email no meu sistema redireciono para Registo
						$urlImage = 'http://graph.facebook.com/' . $user_id . '/picture?type=large';
						$first_name = $user_profile['first_name'];
						$last_name = $user_profile['last_name'];
						$gender = $user_profile['gender'];
						header('location:' . BASEPATH . $country['name'] . '/registration/default/sistema/FACEBOOK/external_user_id/' . $user_id . '/email/' . $user_email . '/first_name/' . $first_name . '/last_name/' . $last_name . '/picure_url/' . $urlImage . '/gender/' . $gender . '/');
					}
				}
				//template
			} else {
				$loginUrl = $facebook->getLoginUrl(array('scope' => 'publish_stream,email,user_photos'));
			}
		} catch (Exception $e) {
			throw $e;
		}
	}

	/*
	private function login_ambassador_from_cookie() {
		$res = false;
		if (	
			  $this->Command->get_action() != 'logout' &&
			  isset($_COOKIE['wrm'])) {
			$remeber_me_cookie = json_decode($_COOKIE['wrm'], true);
			$valid_cookie_pair = $this->validate_user_email_md5_password($remeber_me_cookie['u'], $remeber_me_cookie['p']);
			if ($valid_cookie_pair) {
				$this->force_user_login($remeber_me_cookie['u']);
				$res = true;
			}
		}
		return $res;
	}
*/


	private function force_user_login($a_user_email) {
		$res = $this->auth->setAuth($a_user_email);
		return $res;
	}

	private function set_cookie() {
		$result = false;
		try {
			$user = array();
			$comunity = $this->Command->get_community();
			$user['u'] = $_POST['username'];
			$user['p'] = md5($_POST['password']);
			$cookie_name = 'wrm';
			$cookie_value = json_encode($user);

			$result = setcookie($cookie_name, $cookie_value, time() + (20 * 365 * 24 * 60 * 60), '/');
		} catch (Exception $e) {
			
		}
		return $result;
	}
/*
	private function validate_user_email_md5_password($a_ambassador_email, $a_ambassador_password) {
		$result = false;
		try {
			require_once REALPATH . 'model/ambassador.model.php';
			$ambassador_model = new ambassadorModel();
			$arrayFilters = array(
			    'email' => $a_ambassador_email,
			    'password' => $a_ambassador_password);
			$result = $ambassador_model->getFilteredBy($arrayFilters);

			if (sizeof($result) == 1) {
				$result = true;
			}
		} catch (Exception $e) {
			error_log($e);
		}

		return $result;
	}
*/
	/*	 * pmcosta end of aux for login v2 */

	/* END OF AUTH */

	protected function SetFieldError($a_fieldName, $a_errorMsg) {
		$this->Command->set_parameter($a_fieldName . '_error', $a_errorMsg);
	}
/*
	function get_current_auth_user() {
		require_once REALPATH . 'repositories/repository.FACTORY.php';
		$repo_factory = new repository__FACTORY();
		$user_repo = new $repo_factory->get_repository_by_business_entity_name("user");

		$user_data = $this->auth->getAuthData();

		if (empty($user_data)) {
			$isAuth = $this->auth->checkAuth();
			if ($isAuth) {
				if ($this->auth->session) {
					$mail = $this->auth->session['username'];
					$ambassador_data = $ambassador_model->get_ambassador_by_email_and_site_id($mail, $active_site_id);
				}
			}
		}

		require_once REALPATH . 'classes/ambassador.php';
		return new ambassador($ambassador_data['id']);
		
	}
*/
	protected function enforce_user_is_loggedin() {
		if (!$this->is_logged_in()) {
			$this->_error("Deverá estar logado para ver este conteúdo.", 1);
		}
	}

	protected function is_logged_in() {
		$ret_val = null;

		//$ret_val = !isset($this->Command->get_parameter('ambassador'));
		$ret_val = $this->Command->is_logged_in();

		return $ret_val;
	}

	
	private function set_current_user() {
		try {
			require_once REALPATH . 'repositories/repository.FACTORY.php';
			$repo_factory = new repository__FACTORY();
			$user_repo = new $repo_factory->get_repository_by_business_entity_name("user");

			$user = $this->get_current_auth_user();
			$current_user_id = $user->id;
			if (isset($current_user_id)) {
				$user = $user_repo->get_by_id($current_user_id);
				if (isset($user)) {
					$this->Command->set_current_user($user);  
				}
				else{
					//WHAT!?!? REVIEW IT
				}
			}
			else{
				//WHAT!?!? REVIEW IT
			}
		} catch (Exception $e) {
			Logger::exception($this, $e);
			throw $e;
		}
	}

	/**
	 *
	 * @return string describing object 
	 */
	function __toString() {
		$str = implode('|', get_object_vars($this->Command));
		return $str;
	}
	
	
	

	protected function get_from_post($a_key, $a_default_value = null) {
		return key_exists($a_key, $_POST) ? $_POST[$a_key] : $a_default_value;
	}

	protected function redirect_to_controller_action($a_controller_name, $a_action_name, $a_parameters_str=null){
		require_once REALPATH ."/views/action_url_builder.php";
		$action_url_builder = new action_url_builder();
		
		$selected_menu_index = $this->Command->get_parameter("selected_menu");
		$action_url = $action_url_builder->build_url($a_controller_name, $a_action_name, $selected_menu_index, $a_parameters_str);
		
		header("location:" .$action_url);
	}


}

?>
