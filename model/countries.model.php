<?php

require_once 'model/default.model.php';

class countriesModel extends defaultModel {

    function __construct() {
        parent::__construct('aux_countries');
    }

    function get_unconfigured_countries() {
        $values = null;
        try {
            $query = '
                SELECT aux_countries.* 
FROM aux_countries 
WHERE aux_countries.id NOT IN ( SELECT aux_country_id FROM aux_country_aux_language ) 
ORDER BY name';

            $this->connect();

            $sqlResult = mysql_query($query);

            if ($sqlResult) {
                while ($value = mysql_fetch_assoc($sqlResult)) {
                    $values[] = $value;
                }
            } else {
                $this->disconnect();
                throw new Exception('mysql error:' . mysql_errno(), 0);
            }
        } catch (Exception $e) {
            Logger::exception($this, $e);
            $this->disconnect();
            throw $e;
        }
        $this->disconnect();
        return $values;
    }

    function get_configured_countries_names() {
        $values = null;
        try {
            $query = '
                    SELECT name FROM ' . $this->tableName . ' 
                    INNER JOIN aux_country_aux_language 
                    ON ' . $this->tableName . '.id = aux_country_aux_language.aux_country_id 
                    GROUP BY id 
                    ORDER BY name';

            $this->connect();

            $sqlResult = mysql_query($query);
            $mysql_errors = mysql_error();

            if ($sqlResult) {
                while ($value = mysql_fetch_assoc($sqlResult)) {
                    $values[] = $value['name'];
                }
            } else {
                $this->disconnect();
                throw new Exception('mysql error:' . mysql_error(), 0);
            }
        } catch (Exception $e) {
            Logger::exception($this, $e);
            $this->disconnect();
            throw $e;
        }
        $this->disconnect();
        return $values;
    }

    function get_configured_countries() {
        $values = null;
        try {
            $query = 'SELECT ' . $this->tableName . '.* FROM ' . $this->tableName . ' 
                INNER JOIN aux_country_aux_language 
                ON ' . $this->tableName . '.id = aux_country_aux_language.aux_country_id GROUP BY id';

            $this->connect();

            $sqlResult = mysql_query($query);

            if ($sqlResult) {
                while ($value = mysql_fetch_assoc($sqlResult)) {
                    $values[] = $value;
                }
            } else {
                $this->disconnect();
                throw new Exception('mysql error:' . mysql_errno(), 0);
            }
        } catch (Exception $e) {
            Logger::exception($this, $e);
            $this->disconnect();
            throw $e;
        }
        $this->disconnect();
        return $values;
    }

    function get_languages_by_country_id($id) {
        Logger::error($this, 'DEPRECATED SHOULD USE METHOD IN LANGUAGES CONTROLLER');
        $values = null;

        try {
            $query = '
            SELECT * 
FROM aux_languages
INNER JOIN aux_country_aux_language ON aux_languages.id = aux_country_aux_language.aux_language_id
AND aux_country_id =  \'' . $id . '\';';
            $this->connect();

            $sqlResult = mysql_query($query);

            if ($sqlResult) {
                while ($value = mysql_fetch_assoc($sqlResult)) {
                    $values[] = $value;
                }
            } else {
                $this->disconnect();
                throw new Exception('mysql error:' . mysql_error(), 0);
            }
        } catch (Exception $e) {
            Logger::exception($this, $e);
            $this->disconnect();
            throw $e;
        }
        $this->disconnect();
        return $values;
    }

    function getSelectWithTrimedValues() {
        $value = array();
        try {
            $query = 'SELECT name as name , REPLACE(name, \' \', \'\') as value FROM countries WHERE NAME LIKE \'% %\'';

            $sqlResult = mysql_query($query);
            while ($value = mysql_fetch_assoc($sqlResult)) {
                $values[] = $value;
            }
        } catch (Exception $e) {
            Logger::exception($this, $e);
            throw $e;
        }

        return $values;
    }

    
    function get_complete_country_by_id($a_country_id){
	    DBCHelper2::require_that()->the_param($a_country_id)->is_a_string();
	    $ret_val = null;
	    
	    
	    $country_record = parent::getById($a_country_id);
	    
	    $model = new defaultModel('aux_countries_phone_prefix_codes');
	    $country_phone_prefix_record = $model->getById($a_country_id);
	    $country_phone_prefix = $country_phone_prefix_record['phone_prefix_code'];
	    
	    $model = new defaultModel('aux_countries_zipcode_validation_rules');
	    $country_zipcode_validation_record = $model->getById($a_country_id);
	    $country_zipcode_validation_regex = $country_zipcode_validation_record['validation_regex'];
	    $country_zipcode_validation_msg = $country_zipcode_validation_record['validation_msg'];
	    
	    $model = new defaultModel('aux_countries_phone_validation_rules');
	    $country_phone_validation_record = $model->getById($a_country_id);
	    $country_phone_validation_regex = $country_phone_validation_record['validation_regex'];
	    $country_phone_validation_msg = $country_phone_validation_record['validation_msg'];
	    
	    $country_record['phone_prefix'] = $country_phone_prefix;
	    $country_record['zipcode_validation_regex'] = $country_zipcode_validation_regex;
	    $country_record['zipcode_validation_msg'] = $country_zipcode_validation_msg;
	    $country_record['phone_validation_regex'] = $country_phone_validation_regex;
	    $country_record['phone_validation_msg'] = $country_phone_validation_msg;
	    
	    $ret_val = $country_record;
	    
	    return $ret_val;
    }
    
    
}
