<?php

require_once'default.model.php';
require_once 'util/TextUtil.php';
require_once 'util/Logger.php';
require_once 'util/DBCHelper.php';

class ambassadorModel extends defaultModel {

	function __construct() {
		parent::__construct('ambassador');
	}

	function persist($ambassador_data) {
		$persist_result = parent::persist($ambassador_data);
		if ($persist_result['boolean']) {
			require_once REALPATH . 'util/generateUtils.php';
			$ambassador_data['id'] = $persist_result['id'];
			$ambassador_data['code'] = generateUtils::chaves_gera_chave($persist_result['id']);
			$update_result = $this->update_by_id($ambassador_data['id'], $ambassador_data);
			$update_result['id'] = $persist_result['id'];
			$result = $update_result;
		} else {
			$result = $persist_result;
		}
		return $result;
	}

	function get_ambassador_by_id($a_ambassador_id) {
		DBCHelper::require_that(DBCHelper::the_param(DBCHelper::is_an_integer_string($a_ambassador_id)));

		return parent::getById($a_ambassador_id);
	}

	function get_ambassador_by_code($code) {
		DBCHelper::require_that(DBCHelper::the_param(DBCHelper::is_a_string($code)));

		$arrayFilters = array('code' => $code);
		return parent::getFilteredBy($arrayFilters);
	}

	function pre_activate_ambassador_by_id($id) {
		DBCHelper::require_that(DBCHelper::the_param(DBCHelper::is_an_integer_string($id)));
		$arrayValues = array('registration_status' => 1);
		return parent::update_by_id($id, $arrayValues);
	}

	function get_user_by_email_and_site_id($a_email, $site_id) {
		//$arrayFilters = array('email'=>$a_email, 'country'=>$a_country);
		$arrayFilters = array('email' => $a_email);
		return parent::getFilteredBy($arrayFilters);
	}

	/**
	 *
	 * @param string $a_email ambassador email
	 * @param int $site_id a site/comunity id
	 * @return array with ambassador values or false if no such ambassador
	 * @throws Exception 
	 */
	function get_active_ambassador_by_email_and_site_id(
		$a_email
		, $site_id
	) {
		require_once REALPATH.'enums/user_registration_status.php';
		
		$value = false;
		Logger::debug($this, "get_active_ambassador_by_email_and_site_id($a_email, $site_id)");
		try {
			$query = "
                SELECT * FROM ambassador  
                WHERE 1=1 
                AND email = '{$a_email}' 
                AND fk_site_id = {$site_id} 
			    AND is_active <> 0
                AND registration_status = ".user_registration_status::REGISTERED_CONFIRMED;
			Logger::debug($this, $query);

			$this->connect();
			$result = mysql_query($query);
			Logger::debug($this, $result);

			if (!$result) {
				Logger::debug($this, $query . ' INVALID!');
			} else if (mysql_num_rows($result) == 0) {
				Logger::debug($this, $query . ' GOT 0 results!');
			} else {
				$value = mysql_fetch_assoc($result);
			}


			Logger::debug($this, print_r($value, true));
		} catch (Exception $e) {
			Logger::exception($this, $e);
			$this->disconnect();
			throw $e;
		}
		$this->disconnect();

		return $value;
	}

	function get_user_by_sistema_and_external_user_id(
		$sistema
		, $external_user_id
	) {
		DBCHelper::require_that(DBCHelper::the_param(DBCHelper::is_a_string($sistema)));
		DBCHelper::require_that(DBCHelper::the_param(DBCHelper::is_an_integer_string($external_user_id)));

		$exteranl_users_model = new defaultModel('external_users');
		$external_user_info = $exteranl_users_model->getFilteredBy(array('sistema' => $sistema, 'external_user_id' => $external_user_id), false);

		if ($external_user_info) {
			$user = parent::getById($external_user_info['fk_ambassador_id']);
		} else {
			$user = NULL;
		}
		return $user;
	}

	public function get_total_atp_points_by_ambassador_id(
		$a_ambassador_id
	) {
		$retVal = 0;
		$temp_date = date('Y-m-d');
		$date = new DateTime($temp_date);

		$year_ago = new DateTime();
		$year_ago->setTimestamp(strtotime('now - 1 year'));

		$interval = date_diff($date, $year_ago);
		$retVal = $this->get_total_atp_points($a_ambassador_id, $date, $interval);

		return $retVal;
	}

	public function get_total_atp_points(
		$a_ambassador_id
		, $a_date
		, $a_period_in_months
	) {
		DBCHelper::require_that(DBCHelper::the_param(DBCHelper::is_an_integer_string($a_ambassador_id)));
		DBCHelper::require_that(DBCHelper::the_param(DBCHelper::is_a_date($a_date)));
		DBCHelper::require_that(DBCHelper::the_param(DBCHelper::is_a_date_interval($a_period_in_months)));

		$retVal = 0;


		$atp_user_points_rowsource = $this->get_atp_user_points_rowsource_by_ambassador_id($a_ambassador_id, $a_date, $a_period_in_months);
		$permanent_user_points_rowsource = $this->get_permanent_user_points_rowsource_by_ambassador_id($a_ambassador_id);

		try {
			$query = "	select 
						sum(points_quantity) as points_total 
						from (
							select points_quantity
							{$atp_user_points_rowsource}

							union all

							select points_quantity
							{$permanent_user_points_rowsource}
						) as partials;						 
				";

			parent::connect();
			$result = mysql_query($query);
			$error = mysql_error();
			while ($value = mysql_fetch_assoc($result)) {
				$values[] = $value;
			}
			if ($values[0]['points_total']) {
				$retVal = $values[0]['points_total'];
			}
		} catch (Exception $e) {
			Logger::exception($this, $e);
			parent::disconnect();
			throw $e;
		}
		parent::disconnect();
		//Logger::debug($this, '$sql ['.$sql.'] GOT '.print_r($values,true));

		DBCHelper::ensure_that(DBCHelper::the_return_value(DBCHelper::is_an_integer_string($retVal)));
		return $retVal;
	}
	
	public function get_permanent_user_points_rowsource_by_ambassador_id(
		$a_ambassador_id
	){
		DBCHelper::require_that(DBCHelper::the_param(DBCHelper::is_an_integer_string($a_ambassador_id)));
		
		$ret_val = null;
		
		$query = "
				from user_points  
				where 1=1
				  and ambassador_id = $a_ambassador_id 
				  and for_lifetime = 1
		";
		
		$ret_val = $query;
		
		return  $ret_val;
		
	}
	
	public function get_atp_user_points_rowsource_by_ambassador_id(
		$a_ambassador_id
		, $a_date
		, $a_period_in_months
	){
		DBCHelper::require_that(DBCHelper::the_param(DBCHelper::is_an_integer_string($a_ambassador_id)));
		
		$ret_val = null;
		
		$date = date_add($a_date, $a_period_in_months);
		$date_str = date_format($date, 'Y-m-d');		
		
		$query = "
				from user_points  
				where 1=1
				  and ambassador_id = $a_ambassador_id 
				  and effective_date >= '$date_str'
				  and for_lifetime = 0
		";
		
		$ret_val = $query;
		
		return  $ret_val;
		
	}

	public function get_atp_user_points_records(
		$a_ambassador_id
		, $a_date
		, $a_period_in_months
	) {
		DBCHelper::require_that(DBCHelper::the_param(DBCHelper::is_an_integer_string($a_ambassador_id)));
		DBCHelper::require_that(DBCHelper::the_param(DBCHelper::is_a_date($a_date)));
		DBCHelper::require_that(DBCHelper::the_param(DBCHelper::is_a_date_interval($a_period_in_months)));

		$ret_val = null;

		//$date = date_create($a_date);
		//$interval = date_interval_create_from_date_string(" - $a_period_in_months");

		$atp_user_points_rowsource = $this->get_atp_user_points_rowsource_by_ambassador_id($a_ambassador_id, $a_date, $a_period_in_months);
		$permanent_user_points_rowsource = $this->get_permanent_user_points_rowsource_by_ambassador_id($a_ambassador_id);
		
		$values = array();
		try {
			$query = "	
					select * 
					from(			
						select *
						{$atp_user_points_rowsource}
						union all

						select *
						{$permanent_user_points_rowsource}
					) as partials;						 
				";

			parent::connect();
			$result = $this->mysql_query($query);
			$error = mysql_error();
			while ($value = mysql_fetch_assoc($result)) {
				$values[] = $value;
			}
			
			$ret_val = $values;
			
		} catch (Exception $e) {
			Logger::exception($this, $e);
			parent::disconnect();
			throw $e;
		}
		parent::disconnect();
		//Logger::debug($this, '$sql ['.$sql.'] GOT '.print_r($values,true));

		DBCHelper::ensure_that(DBCHelper::the_return_value(DBCHelper::is_an_array($ret_val)));
		return $ret_val;
	}
	
	

	public function get_unconfirmed_pre_registrations_qnt_by_site_id(
		$a_site_id
	) {
		DBCHelper2::require_that()->the_param($a_site_id)->is_an_integer_string($a_site_id);

		$retVal = array();

		$values = array();
		try {
			$query =
				  "	
					select count(*) as qty 
					from 
						ambassador amb
					where 1=1
					  and amb.registration_status = 0
					  and amb.fk_site_id = {$a_site_id};
				";

			parent::connect();
			$result = $this->mysql_query($query);
			if (DEBUG) {
				$error = mysql_error();
			};

			while ($value = $this->mysql_fetch_assoc($result)) {
				$values[] = $value;
			}
		} catch (Exception $e) {
			Logger::exception($this, $e);
			parent::disconnect();
			throw $e;
		}
		parent::disconnect();

		$retVal = $values[0]['qty'];
		return $retVal;
	}
	 
	public function get_unconfirmed_pre_registrations_by_site_id(
		$a_site_id
	) {
		DBCHelper2::require_that()->the_param($a_site_id)->is_an_integer_string($a_site_id);

		$retVal = array();

		$values = array();
		try {
			$query =
				  "	
					select amb.email 
					from 
						ambassador amb
					where 1=1
					  and amb.registration_status = 0
					  and amb.fk_site_id = {$a_site_id};
				";

			parent::connect();
			$result = $this->mysql_query($query);
			if (DEBUG) {
				$error = mysql_error();
			};

			while ($value = $this->mysql_fetch_assoc($result)) {
				$values[] = $value;
			}
		} catch (Exception $e) {
			Logger::exception($this, $e);
			parent::disconnect();
			throw $e;
		}
		parent::disconnect();

		$retVal = $values;
		return $retVal;
	}

	public function get_confirmed_pre_registrations_qnt_by_site_id(
		$a_site_id
	) {
		DBCHelper2::require_that()->the_param($a_site_id)->is_an_integer_string($a_site_id);

		$retVal = array();

		$values = array();
		try {
			$query =
				  "	
					select count(*) as qty 
					from 
						ambassador amb
					where 1=1
					  and amb.registration_status <> 0
					  and amb.fk_site_id = {$a_site_id};
				";

			parent::connect();
			$result = $this->mysql_query($query);
			if (DEBUG) {
				$error = mysql_error();
			};

			while ($value = $this->mysql_fetch_assoc($result)) {
				$values[] = $value;
			}
		} catch (Exception $e) {
			Logger::exception($this, $e);
			parent::disconnect();
			throw $e;
		}
		parent::disconnect();

		$retVal = $values[0]['qty'];
		return $retVal;
	}

	public function get_confirmed_pre_registrations_by_site_id(
		$a_site_id
	) {
		DBCHelper2::require_that()->the_param($a_site_id)->is_an_integer_string($a_site_id);

		$retVal = array();

		$values = array();
		try {
			$query =
				  "	
					select amb.email 
					from 
						ambassador amb
					where 1=1
					  and amb.registration_status <> 0
					  and amb.fk_site_id = {$a_site_id};
				";

			parent::connect();
			$result = $this->mysql_query($query);
			if (DEBUG) {
				$error = mysql_error();
			};

			while ($value = $this->mysql_fetch_assoc($result)) {
				$values[] = $value;
			}
		} catch (Exception $e) {
			Logger::exception($this, $e);
			parent::disconnect();
			throw $e;
		}
		parent::disconnect();

		$retVal = $values;
		return $retVal;
	}
	
	
	
	public function get_friends_that_registered_qty($a_ambassador_id){
		DBCHelper2::require_that()->the_param($a_ambassador_id)->is_an_integer_string();

		$ret_val = array();

		$values = array();
		try {
			$query =
				  "	
					select count(*) as qty 
					from 
						ambassador amb
					where 1=1
					  and amb.registration_status >= 1
					  and amb.parent_id = {$a_ambassador_id};
				";

			parent::connect();
			$result = $this->mysql_query($query);
			if (DEBUG) {
				$error = mysql_error();
			};

			while ($value = $this->mysql_fetch_assoc($result)) {
				$values[] = $value;
			}
		} catch (Exception $e) {
			Logger::exception($this, $e);
			parent::disconnect();
			throw $e;
		}
		parent::disconnect();

		$ret_val = $values[0]['qty'];
		
		
		
		return $ret_val;		
	}
	
	
	
	
	
	
	
	
	public function get_ambassadors_for_invitation_management($a_campaign_id){
		DBCHelper2::require_that()->the_param($a_campaign_id)->is_an_integer_string();

		$ret_val = array();

		$values = array();
		try {
			$query =
				  "	
					select 
						amb.*
						, enroll.enrollment_status
						, enroll.invitation_status
					from 
						(
							select 
								camp.id as campaign_id
								, amb.id as ambassador_id
							from 
								campaign camp, ambassador amb
							where 1=1
							  and amb.fk_site_id = camp.fk_site_id
							  and camp.id = {$a_campaign_id}
						) as all_campaign_community_ambassadors							  
						left join ambassador_campaign_enrollment enroll 
						  on enroll.fk_campaign_id = all_campaign_community_ambassadors.campaign_id
						  and enroll.fk_ambassador_id = all_campaign_community_ambassadors.ambassador_id
						, ambassador amb
						
					where 1=1
					  and amb.id = all_campaign_community_ambassadors.ambassador_id
					  and amb.registration_status >= 3				  
					order by amb.id;
				";

			parent::connect();
			$result = $this->mysql_query($query);
			if (DEBUG) {
				$error = mysql_error();
			};

			while ($value = $this->mysql_fetch_assoc($result)) {
				$values[] = $value;
			}
		} catch (Exception $e) {
			Logger::exception($this, $e);
			parent::disconnect();
			throw $e;
		}
		parent::disconnect();

		$ret_val = $values;		
		
		
		return $ret_val;		
	}
	
	private function build_ambassador_campaign_enrollment_build_get_filter(
		$a_ambassador_id
		, $a_campaign_id
	){
		DBCHelper2::require_that()->the_param($a_ambassador_id)->is_an_integer_string();
		DBCHelper2::require_that()->the_param($a_campaign_id)->is_an_integer_string();
		
		$ret_val = null;
			
		$ambassador_campaign_enrollment_get_filter = array();
		$ambassador_campaign_enrollment_get_filter["fk_ambassador_id"] = $a_ambassador_id;
		$ambassador_campaign_enrollment_get_filter["fk_campaign_id"] = $a_campaign_id;

		$ret_val = $ambassador_campaign_enrollment_get_filter;
		
		return $ret_val;
	}
	
	private function get_ambassador_campaign_enrollment_record(
		$a_ambassador_campaign_enrollment_get_filter
	){
		DBCHelper2::require_that()->the_param($a_ambassador_campaign_enrollment_get_filter)->is_an_array();
		
		$ret_val = null;
						
		//require_once REALPATH ."model/default.model.php";
		$default_model = new defaultModel("ambassador_campaign_enrollment");
				
		$ambassador_campaign_enrollment_record = $default_model->getFilteredBy($a_ambassador_campaign_enrollment_get_filter, true);

		$ret_val = $ambassador_campaign_enrollment_record;
		
		return $ret_val;
		
	}
	
	public function invite_ambassador(
		$a_ambassador_id
		, $a_campaign_id
	){
		DBCHelper2::require_that()->the_param($a_ambassador_id)->is_an_integer_string();
		DBCHelper2::require_that()->the_param($a_campaign_id)->is_an_integer_string();
		
		//require_once REALPATH ."model/default.model.php";
		$default_model = new defaultModel("ambassador_campaign_enrollment");
		
		$ambassador_campaign_enrollment_get_filter = $this->build_ambassador_campaign_enrollment_build_get_filter($a_ambassador_id, $a_campaign_id);
		DBCHelper2::assert_that()->the_variable($ambassador_campaign_enrollment_get_filter)->is_an_array();
		
		$ambassador_campaign_enrollment_records = $default_model->getFilteredBy($ambassador_campaign_enrollment_get_filter, true);
				
		DBCHelper2::assert_that()->the_variable($ambassador_campaign_enrollment_records)->is_an_array_with_at_most_n_elements(1);
		$ambassador_campaign_enrollment_record = $ambassador_campaign_enrollment_records[0];
			//enrollment_status
			//fk_ambassador_perspective_campaign_status_id

		$record_exists = !is_null($ambassador_campaign_enrollment_record);
		
		if($record_exists){
			DBCHelper2::assert_that()->the_variable($ambassador_campaign_enrollment_record)->is_an_array_with_at_least_one_element();

			$ambassador_campaign_enrollment_record["invitation_status"] = 1;
			$update_callret = $default_model->update_by_id($ambassador_campaign_enrollment_record['id'], $ambassador_campaign_enrollment_record);
		}
		else{
			DBCHelper2::assert_that()->the_variable($ambassador_campaign_enrollment_get_filter)->is_an_array_with_n_elements(2);
			$ambassador_campaign_enrollment_record = $ambassador_campaign_enrollment_get_filter;
			
			$ambassador_campaign_enrollment_record["invitation_status"] = 1;
			
			$persist_callret = $default_model->persist($ambassador_campaign_enrollment_record);
			
		}
		

	}
	
	public function get_pending_invitation_mail_sendings_for_campaign(
		$a_campaign_id
	){
		DBCHelper2::require_that()->the_param($a_campaign_id)->is_an_integer_string();

		$ret_val = array();

		$values = array();
		try {
			$query =
				  "	
					select 
						enroll.id as enroll_id
						, amb.id as ambassador_id
						, amb.email as ambassador_email
						, amb.first_name as ambassador_first_name
						, amb.last_name as ambassador_last_name
					from 
						ambassador_campaign_enrollment enroll 						
						, ambassador amb
					where 1=1
					  and enroll.fk_ambassador_id = amb.id
					  and enroll.invitation_status = 1 -- unconfirmed, no mail sended
					  and enroll.fk_campaign_id = {$a_campaign_id}
				";

			parent::connect();
			$result = $this->mysql_query($query);
			if (DEBUG) {
				$error = mysql_error();
			};

			while ($value = $this->mysql_fetch_assoc($result)) {
				$values[] = $value;
			}
		} catch (Exception $e) {
			Logger::exception($this, $e);
			parent::disconnect();
			throw $e;
		}
		parent::disconnect();

		$ret_val = $values;		
		
		
		return $ret_val;			
	}
	
	public function mark_ambassador_as_invited(
		$a_ambassador_id
		, $a_campaign_id
	){
		DBCHelper2::require_that()->the_param($a_ambassador_id)->is_an_integer_string();
		DBCHelper2::require_that()->the_param($a_campaign_id)->is_an_integer_string();
		
		$get_filter = $this->build_ambassador_campaign_enrollment_build_get_filter($a_ambassador_id, $a_campaign_id);
		$enrollment_records = $this->get_ambassador_campaign_enrollment_record($get_filter);
		
		DBCHelper2::assert_that()->the_variable($enrollment_records)->is_an_array_with_n_elements(1);
		$enrollment_record = $enrollment_records[0];
		
		$enrollment_id = $enrollment_record['id'];
		$enrollment_record['invitation_status'] = 2; //
		
		$default_model = new defaultModel("ambassador_campaign_enrollment");		

		$update_callret = $default_model->update_by_id($enrollment_id, $enrollment_record);
	}

}