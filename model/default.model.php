<?php

require_once REALPATH .'util/DBCHelper.php';
require_once REALPATH .'model/mysql_db_connection.php';
require_once REALPATH .'util/TextUtil.php';

/**
 * 
 * @author pmcosta
 *
 */
class defaultModel {

	var $tableName;
	private $connection;
	private $columns_definitions;

	function __construct($tableName) {
		DBCHelper::require_that(DBCHelper::the_param(DBCHelper::is_a_string($tableName)));
		$this->tableName = $tableName;
		$this->columns_definitions = $this->table_columns_get();
	}

	protected function begin_transaction() {
		$this->connection->begin_transaction();
	}

	protected function commit_transaction() {
		$this->connection->commit_transaction();
	}

	protected function rollback_transaction() {
		$this->connection->rollback_transaction();
	}

	protected function connect() {
		if (!isset($this->connection)) {
			$this->connection = mysql_db_connection::get_instance();
		}
	}

	protected function disconnect() {
		if(!isset($this->connection)){return;};
		if($this->connection->is_a_transaction_active()){return;};
		
		Logger::debug($this, 'Destroing connection' . $this->connection);
		$this->connection->disconnect();
		$this->connection = null;	
	}

		
	protected function mysql_query($a_query) {
		Logger::debug($this, 'mysql_query(a_query[' . $a_query . '])');

		$ret_val = false;

		$query_exec_result = mysql_query($a_query);

		if (!$query_exec_result) {
			$query_exec_error_no = mysql_errno();
			if($query_exec_error_no!=0){
				$query_exec_errors = mysql_error();
				$display_msg = "An error ocurred while executing up a mysql query.";
				$log_msg = $display_msg . "The error was: \r\n $query_exec_errors";
				$log_msg = $log_msg. "\r\n The query was:" . $a_query; 
				if (DEBUG) { // only displays detailed information when in DEBUG mode
					$display_msg = $log_msg; 
				}
				Logger::error($this, $log_msg);
				throw new Exception($display_msg, 1, null);
			}
		}

		$ret_val = $query_exec_result;

		return $ret_val;
	}
	
	protected function mysql_fetch_assoc($a_query_res) {

		$ret_val = false;

		$query_exec_result = mysql_fetch_assoc($a_query_res);

		if (!$query_exec_result) {
			$query_exec_error_no = mysql_errno();
			if($query_exec_error_no!=0){
				$query_exec_errors = mysql_error();
				$display_msg = "An error ocurred while fetching a mysql query fetch.";
				$log_msg = $display_msg . "The error was: \r\n $query_exec_errors";
				if (DEBUG) { // only displays detailed information when in DEBUG mode
					$display_msg = $log_msg;
				}
				Logger::error($this, $log_msg);
				throw new Exception($display_msg, 1, null);
			}
		}

		$ret_val = $query_exec_result;

		return $ret_val;
	}


	/* CREATE */
	
	private function extract_only_fields_to_save($a_arrayValues){
		$ret_val = array();
		
		$data = array();
		foreach($a_arrayValues as $key=>$value){
			if(key_exists($key, $this->columns_definitions)){
				$data[$key] = $value;
			}
		}
		
		$ret_val = $data;
		
		return $ret_val;
	}

	function persist($arrayValues) {
		
		
		$data = $this->extract_only_fields_to_save($arrayValues);
		
		
		
		
		$result = array("boolean" => false, 'id' => 0, 'message' => 'no message');
		try {
			$sql = 'INSERT INTO ' . $this->tableName . ' (';

			foreach ($data as $key => $value) {
				$cols[] = "`$key`";
				if(is_a($value, "DateTime")){
					$values [] = 'UNIX_TIMESTAMP(' . $value->getTimestamp() . ')';
				}
				else{
					$values [] = '\'' . mysql_escape_string($value) . '\'';
				}
			}
			$sql .= implode(',', $cols);
			$sql .= ') VALUES (';
			$sql .= implode(',', $values);
			$sql .= ');';
			//Logger::debug($this, $sql);

			$this->connect();
			$sqlResult = $this->mysql_query($sql);

			//Logger::debug($this, mysql_error());
			if ($sqlResult) {
				$result['boolean'] = true;
				$result['id'] = mysql_insert_id();
				$result['message'] = 'Sucess';
			} else {
				$result['boolean'] = false;
				$result['message'] = $sql . ' GOT ' . mysql_error();
			}
		} catch (Exception $e) {
			Logger::exception($this, $e);
			$this->disconnect();
			throw $e;
		}
		$this->disconnect();
		//Logger::debug($this, '$sql ['.$sql.'] GOT '. print_r($result,true));

		return $result;
	}

	/* READ */

	function get_all() {
		$values = array();
		try {
			$sql = 'SELECT * FROM ' . $this->tableName . ' ;';
			//Logger::debug($this, '$sql ['.$sql.']');

			$this->connect();
			$result = mysql_query($sql);
			while ($value = mysql_fetch_assoc($result)) {
				$values[] = $value;
			}
		} catch (Exception $e) {
			Logger::exception($this, $e);
			$this->disconnect();
			throw $e;
		}
		$this->disconnect();

		//Logger::debug($this, '$sql ['.$sql.'] GOT '.print_r($values,true));
		return $values;
	}

	function getById($id) {
		$value = null;
		Logger::debug($this, 'getById(' . $id . ')');
		try {
			$sql = 'SELECT * FROM ' . $this->tableName . ' WHERE id =\'' . $id . '\';';
			Logger::debug($this, $sql);

			$this->connect();
			$result = mysql_query($sql);
			Logger::debug($this, $result);

			if (!$result) {
				Logger::debug($this, $sql . ' INVALID!');
			} else if (mysql_num_rows($result) == 0) {
				Logger::debug($this, $sql . ' GOT 0 results!');
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

	function getFilteredBy($arrayFilters, $asArray = false) {
		$stringArraBool = $asArray ? 'AsArray' : 'singleresult';

		Logger::debug($this, 'GET FILTERED BY(' . TextUtil::toString($arrayFilters) . ', ' . $stringArraBool . ' )');

		$values = array();
		try {
			$first = true;
			$sql = 'SELECT * FROM ' . $this->tableName . ' ';
			foreach ($arrayFilters as $key => $value) {
				if ($first) {
					$sql .= ' WHERE ' . $key . (($value == NULL) ? ' IS NULL' : ' = ' . '"' . $value . '"');
					$first = false;
				} else if ($value === 0) {//TODO BURRADA MARTELADA
					$sql .= ' AND  ' . $key . ' = 0';
				} else if ($value === 0.0) {//TODO BURRADA MARTELADA
					$sql .= ' AND  ' . $key . ' = 0.0';
				} else if ($value === FALSE) {//TODO BURRADA MARTELADA
					$sql .= ' AND  ' . $key . ' = 0';
				} else {
					$sql .= ' AND ' . $key . (($value == NULL) ? ' IS NULL' : ' = ' . '"' . $value . '"');
				}
			}

			$sql .= ' ;';

			$this->connect();
			$result = mysql_query($sql);


			if (!mysql_error()) {
				while ($value = mysql_fetch_assoc($result)) {
					$values[] = $value;
				}
			} else {
				Logger::error($this, '[' . $sql . '] ->' . mysql_error());
				throw new Exception('[' . $sql . '] ->' . mysql_error(), -1);
			}

			if (!$asArray && is_array($values) && count($values)!=0) {
				$values = $values[0];
			}
		} catch (Exception $e) {
			Logger::exception($this, $e);
			$this->disconnect();
			throw $e;
		}
		$this->disconnect();

		//mfigueira, must be commented because it explodes the stack
		//Logger::debug($this, '$sql [' . $sql . '] GOT ' . TextUtil::toString($values));
		return $values;
	}
	
	public function get_records_by_filter($arrayFilters, $asArray = true){
		return $this->getFilteredBy($arrayFilters, $asArray);
	}

	/* UPDATE */

	private function quote($a_value) {
		$retVal = '\'' . $a_value . '\' ';

		return $retVal;
	}

	private function format($a_value) {
		$retVal = '';
		if ($a_value === null) {
			$retVal = 'NULL';
		} else {
			$retVal = $this->quote($a_value);
		}
		return $retVal;
	}

	function update_by_id($id, $arrayValues) {
		DBCHelper2::require_that()->the_param($id)->is_an_integer_string();
		DBCHelper2::require_that()->the_param($arrayValues)->is_an_array_with_at_least_one_element();
		
		
		$data = $this->extract_only_fields_to_save($arrayValues);

		
		try {
			$result = array("boolean" => true, 'id' => 0, 'message' => 'nomessage');
			$sql = '
		UPDATE ' . $this->tableName . '
		SET ';

			$i = 1;
			

			foreach ($data as $key => $value) {
				if(is_a($value, "DateTime")){
					$sql .= ' ' . $key . '=' . 'UNIX_TIMESTAMP(' . $value->getTimestamp() . ')' . (($i == sizeof($data)) ? ' ' : ' ,');
				}else{
					$sql .= ' ' . $key . '=' . $this->format($value) . (($i == sizeof($data)) ? ' ' : ' ,');
				}
				$i++;
			}
			$sql .= 'WHERE id=' . $id . ';';

			$this->connect();
			$sqlResult = $this->mysql_query($sql);
			//$error = mysql_error();

			if ($sqlResult) {
				$result['boolean'] = true;
				$result['message'] = 'Successful update';
			} else {
				$result['boolean'] = false;
				$result['message'] = 'QUERY ' . $sql . ' ERROR ' . mysql_error();
			}
		} catch (Exception $e) {
			Logger::exception($this, $e);
			$this->disconnect();
			throw $e;
		}
		$this->disconnect();

		return $result;
	}

	/* DELETE */

	function deleteById($id) {
		try {
			$result = array("boolean" => true, 'id' => 0, 'message' => 'nomessage');
			$sql = 'DELETE FROM ' . $this->tableName . ' WHERE id=' . $id . ';';

			$this->connect();
			$sqlResult = mysql_query($sql);

			$mysql_error_object = mysql_error();
			$mysql_affected_rows_qty = mysql_affected_rows();
			$just_one_row_affected = $mysql_affected_rows_qty == 1;

			if ($just_one_row_affected) {
				$result['boolean'] = true;
				//$result['id'] = mysql_insert_id();
			} else {
				$result['boolean'] = false;
				$result['message'] = 'QUERY ' . $sql . '<br />';
				$result['message'] = 'Afected rows[' .$mysql_affected_rows_qty . ']' . '<br />';
				$mysql_error_object = mysql_error();
				if ($mysql_error_object && DEBUG) {
					$result['message'] .= 'SQL ERROR ' . $mysql_error_object;
				}
			}
		} catch (Exception $e) {
			Logger::exception($this, $e);
			$this->disconnect();
			throw $e;
		}
		$this->disconnect();

		return $result;
	}
	
	
	public function table_columns_get(){
		$ret_val = array();
		
		
		$values = array();
		Logger::debug($this, 'table_columns_get');
		try {
			$table_name = $this->tableName;
			$sql = "SHOW COLUMNS FROM {$table_name}";
			Logger::debug($this, $sql);

			$this->connect();
			$result = mysql_query($sql);
			Logger::debug($this, $result);

			if (!$result) {
				Logger::debug($this, $sql . ' INVALID!');
			} else if (mysql_num_rows($result) == 0) {
				Logger::debug($this, $sql . ' GOT 0 results!');
			} else {
				while ($value = mysql_fetch_assoc($result)) {
					$values[] = $value;
				}

			}

			

			Logger::debug($this, print_r($value, true));
		} catch (Exception $e) {
			Logger::exception($this, $e);
			$this->disconnect();
			throw $e;
		}
		$this->disconnect();
		
		
		$columns_definitions = array();
		
		foreach($values as $column_definition){
			$field_name = $column_definition['Field'];
			$definition = array_slice($column_definition, 1);
			$columns_definitions[$field_name] = $definition;
		}
		
		
		$ret_val = $columns_definitions;
		
		return $ret_val;
	}

}
