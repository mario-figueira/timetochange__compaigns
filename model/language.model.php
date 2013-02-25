<?php

require_once 'model/default.model.php';

class languageModel extends defaultModel {

    function __construct() {
        parent::__construct('aux_languages');
    }

    function get_by_site_id($communityId) {
        $pResult = parent::getFilteredBy(array('fk_community_id' => $communityId));
        return $pResult;
    }

    function get_languages_by_country_id($id) {
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

}