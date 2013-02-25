<?php

require_once 'util/DBCHelper.php';

/**
 * Description of mysql_db_connection
 *
 * @author mfigueira
 */
class mysql_db_connection {

	private static $instance;
	private $connection;
	private $transaction = false;

	private function __construct() {
		$this->connect();
	}

	/*
	  function __destruct(){
	  $this->disconnect();
	  }
	 */

	public static function get_instance() {
		if (!isset(self::$instance)) {
			self::$instance = new mysql_db_connection();
		}
		return self::$instance;
	}

	protected function connect() {
		try {
			$this->connection = mysql_connect(DBHOST, DBUSERNAME, DBPASSWORD);
                        $mysql_error = mysql_error();
			if (!empty($mysql_error)) {
				throw new Exception(mysql_error());
			}
			mysql_select_db(DBNAME, $this->connection);
			$mysql_error = mysql_error();
			if (!empty($mysql_error)) {
				throw new Exception(mysql_error());
			}
			$query = 'SET NAMES \'utf8\'';
			mysql_query($query);
			$mysql_error = mysql_error();
			if (!empty($mysql_error)) {
				throw new Exception(mysql_error());
			}
		} catch (Exception $e) {
			Logger::exception($this, $e);
			Logger::debug($this, 'Exception connecting to database' . $e->getMessage());
			throw $e;
		}
	}

	public function disconnect() {

		if (isset($this->connection)) {
			Logger::debug($this, 'Destroing connection' . $this->connection);
			mysql_close($this->connection);
			$this->connection = null;
			self::$instance = null;
		}
	}

	public function is_a_transaction_active() {
		return $this->transaction;
	}

	public function begin_transaction() {
		mysql_query("SET GLOBAL TRANSACTION ISOLATION LEVEL SERIALIZABLE");
		mysql_query("BEGIN");
		$this->transaction = true;
	}

	public function commit_transaction() {
		mysql_query("COMMIT");
		$this->transaction = false;
	}

	public function rollback_transaction() {
		mysql_query("ROLLBACK");
		$this->transaction = false;
	}

	public function __toString() {
            //ret_val = 'PHP Notice:  Undefined property: mysql_db_connection::$instance in /Users/pmcosta/Sites/updigital/trunk/wom_public/model/mysql_db_connection.php on line 89';
//		$ret_val = "instance=[" . self::$instance . "]";
		$ret_val ="";
		return $ret_val;
	}

}

?>
