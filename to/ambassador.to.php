<?php
/**
 * Description of ambassadorTO
 *
 * @author pmcosta
 */
require_once 'to/default.to.php';

class ambassadorTO extends defaultTO {

    public $id;
    public $fk_site_id;
    public $email;
    public $password;
    public $code;
    public $created;
    public $registration_status;
    public $parent_id;
    public $first_name;
    public $last_name;
    public $picture_url;
    public $gender;
    public $birthday;
    public $is_active;
    public $already_receveid_profile_bonus;

    public function __construct($a_array = null, $a_boolean_ignore_extra = false) {
	    parent::__construct($a_array, $a_boolean_ignore_extra);
    }

    public function update_by_ambassador($a_ambassador) {
        if ($a_ambassador instanceof ambassadorTO) {
            $array_ambassador = $a_ambassador->get_as_array();
            $this->update_by_array($array_ambassador);
        } else {
            throw new Exception("Trying to update ambassador TO with " . get_class($a_ambassador));
        }
    }

    public function update_by_array($a_array) {
        foreach ($a_array as $key => $value) {
            if (!empty($value)) {
                $this->$key = $value;
            }
        }
    }

    public function get_as_array() {
        $result = array();
        $array = get_object_vars($this);
        foreach ($array as $key => $value) {
            if (!empty($value)) {
                $result[$key] = $value;
            }
        }
        return $result;
    }
    
    public function is_valid(){
	    $result = false;
	    if(isset($this->id) && isset($this->email) && $this->code){
		    $result = true;
	    }
	    return $result;
    }

}
?>
