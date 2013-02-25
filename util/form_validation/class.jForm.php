<?php

/**
 * class jForm
 *
 * @author Jonas Lagerwall
 * 2011-10-28
 *
 * A class to validate html forms
 *
 * Feel free to use it any way you like.
 *
 * @version 1.3.1
 * @require class.is.php
 * @website http://jform.lagerwall.net
 * @changelog
 *
 * 1.3.1	Messed it up a bit with 1.3, this is just a fix.
 *
 * 1.3		2012-05-14 added the "transform" attribute. uppercase, lowercase and capitalize, from an idea by Tony Coombe
 * 			Combined with style="text-transform:uppercase|lowercase|capitalize" it becomes rather neat.
 * 			I also added the auto-transform-functionality to zipcodes, so a zipcode can be transformed into e.g. uppercase
 * 			(Maybe I'm on a slippery slope with this, in a perfect world a validator probably shouldn't modify values, but what the heck. You don't have to use it.)
 *
 * 1.2.1	2012-05-11 some bugfixes and better (well, more, anyway) comments.
 *
 * 1.2		2012-04-12 added the captcha input type. <input name="foo" type="captcha" />
 * 			@requires SecurImage, found at http://www.phpcaptcha.org/
 * 			Put the extracted /securimage/ folder in the same directory as class.jForm.php
 * 			Please note: In order for captcha to work you must include class.jForm.php before you send any output to the browser.
 *
 * 1.1 		2012-03-03 added support for conditional requirements
 * 			<input required="first_name!=''" /> (This means the field is required if first_name has a value)
 * 			possible operands are !=, =, «, and », where « and » are used instead of < and >. < and > would mess everything up. :(
 *
 */
require 'class.is.php';

/**
 * @todo getElementById? I could reuse jQuery's "equalTo"....
 */
class jForm {

    private $invalid_stuff = array(
        'html4' => array(
            'invalid_types' => array(
                'captcha', 'color', 'date', 'datetime', 'datetime-local', 'email', 'month', 'number', 'range', 'search', 'tel', 'time', 'url', 'week',
                'zipcode', 'creditcard', 'integer', 'alphanumeric', 'alphabetic',
            ),
            'invalid_attributes' => array(
                'input' => array('transform', 'required', 'min', 'max', 'step', 'minlength', 'validate', 'countryelement', 'callback', 'mustmatch'),
                'textarea' => array('transform', 'required', 'min', 'max', 'minlength', 'validate', 'maxlength', 'callback'),
                'select' => array('required', 'validate', 'callback'),
            ),
        ),
        'html5' => array(
            'invalid_types' => array(
                'captcha', 'zipcode', 'creditcard', 'integer', 'alphanumeric', 'alphabetic',
            ),
            'invalid_attributes' => array(
                'input' => array('transform', 'minlength', 'required', 'validate', 'countryelement', 'callback', 'mustmatch'),
                'textarea' => array('transform', 'validate', 'minlength', 'maxlength', 'callback'),
                'select' => array('validate', 'callback'),
            ),
        ),
    );
    protected $language = 'en_gb';
    protected $charset = 'UTF-8';
    protected $html = '';
    protected $rules = array();
    protected $added_rules = array();
    protected $error_messages = array();
    protected $errors = array();
    protected $forms = array();
    protected $variables = array();
    protected $set_values = array();

    /**
     * Get the error array
     * @return	Array		The error array.
     */
    public function getErrors() {
        return $this->errors;
    }

    /**
     * Sets the language
     *
     * @param string $language //this is no longer true -> Two-letter language codes following standard RFC 4646
     * @example sv_se, en_gb, ru_ru
     */
    public function setLanguage($language) {
        $this->language = $language;
    }

    /**
     * Fetch the error message for a particular error type
     * @param	String	$errortype	The type of error
     * @param	String	$language	The language to use
     * @return	String				The error message
     */
    public function getErrorMessage($errortype, $language = '') {
        $language = ($language) ? $language : $this->language;

        $filename = dirname(__FILE__) . '/lang.' . $language . '.php';
        if (is_file($filename)) {
            include_once($filename);
        }
        /*

          else
          {
          throw new Exception('This language is not implemented.');
          }
         */
        if (isset($this->error_messages[$language][$errortype])) {
            return $this->error_messages[$language][$errortype];
        } else {
            if ($language == 'en_gb') {
                return 'Error message for "' . $errortype . '" does not exist.';
            } else {
                return $this->getErrorMessage($errortype, 'en_gb');
            }
        }
    }

    /**
     * Add a Rule to a form element
     *
     * @param string $field
     * @param string $key
     * @param string $value
     *
     * @example $form -> addRule('name_of_an_element', 'validate', 'numeric');
     */
    public function triggerError($error_string, $element_name = '') {
        $error_message = $this->getErrorMessage($error_string);
        if ($error_message != 'Error message for "' . $error_string . '" does not exist.') {
            $error_string = $error_message;
        }

        if ($element_name) {
            $this->errors[$element_name] = trim($error_string);
        } else {
            $this->errors[] = trim($error_string);
        }
    }

    /**
     * Add a form to the jForm object
     *
     * @param string|filename html
     */
    public function addForm($html) {
        if (strpos($html, '<') === false) { // filenames cannot contain "<>"
            if (is_file($html)) {
                $this->forms[] = $html;
                return;
            } else {
                throw new Exception('Form with file name "' . $html . '" not found');
            }
        }
        $this->html.=$html;
    }

    /**
     * Returns the status of the validated form
     * @return	Boolean		True if the form input has passed validation, false otherwise
     */
    public function isOk() {
        return !sizeof($this->errors);
    }

    /**
     * Set multiple values in the form
     *
     * @param array $array element_name => value
     */
    public function setValues(array $array, $container = '') {
        if ($container) {
            foreach ($array as $key => $value) {
                $this->setValue($container . '[' . $key . ']', $value);
            }
        } else {
            foreach ($array as $key => $value) {
                $this->setValue($key, $value);
            }
        }
    }

    /**
     * Set the value of a form element
     *
     * @param string $element_name
     * @param string $value
     */
    public function setValue($element_name, $value) {
        $this->set_values[$element_name] = trim($value);
    }

    /**
     * Set multiple variables used in one or more included files
     *
     * @param array $array element_name => value
     */
    public function setVariables(array $array) {
        foreach ($array as $key => $value) {
            $this->setVariable($key, $value);
        }
    }

    /**
     * Set a variable to be used in one or more included files
     *
     * @param string $variable_name
     * @param string $value
     */
    public function setVariable($variable_name, $value) {
        $this->variables[$variable_name] = $value;
    }

    /**
     * Add a rule to a form element
     *
     * @param string $element_name
     * @param string $value
     *
     * @example $form->addRule('username', 'required', 'required');
     */
    public function addRule($element_name, $attribute_name, $rule) {
        if (!isset($this->added_rules[$element_name])) {
            $this->added_rules[$element_name] = array();
        }
        $this->added_rules[$element_name][$attribute_name] = $rule;
    }

    /**
     * The constructor
     *
     * @param string|filename
     */
    public function __construct($html, $language = 'en_gb') {
        $this->addForm($html);
        $this->language = $language;
    }

    /**
     * Callback function used by the validate function to trim
     * $_GET and $_POST variables
     *
     * @param string $item
     */
    private function jtrim($item) {
        $item = trim($item);
        if (get_magic_quotes_gpc()) {
            $item = stripslashes($item);
        }
        return $item;
    }

    /**
     * Get the value of a DOM element, posted or set
     * @param	String	$element_name	the name of the DOM element
     * @return	String					the value of the element, returns false if not set
     */
    public function &getValue($element_name) {
        if (isset($this->posted_values)) {
            if (strpos($element_name, '[')) {
                $name = substr($element_name, 0, strpos($element_name, '['));
                if (!isset($this->posted_values[$name])) {
                    return '';
                }
                $current_tag = $this->posted_values[$name];
                preg_match_all('/\[([^]]+)\]/', $element_name, $bracket_matches);
                foreach ($bracket_matches[1] as $element_name) {
                    $l_found = false;
                    foreach ($current_tag as $l_tag_key => $l_tag_value) {
                        if ($l_tag_key == $element_name) {
                            $l_found = true;
                            break;
                        }
                    }
                    //if(isset($current_tag[$element_name])){
                    //	$current_tag = &$current_tag[$element_name];
                    if ($l_found && isset($l_tag_value)) {
                        $current_tag = $l_tag_value;
                    } else {
                        return '';
                    }
                }
            } else {
                if (isset($this->posted_values[$element_name])) {
                    $current_tag = &$this->posted_values[$element_name];
                } else {
                    $current_tag = '';
                }
            }
            $current_tag = self::jtrim($current_tag);
            return $current_tag;
        } elseif (isset($this->set_values[$element_name])) {
            return $this->set_values[$element_name];
        } else {
            $return = false;
            return $return;
        }
    }

    /**
     * Validates the form
     * @param	array	$values	The values to be validated, usually $_POST or $_GET, but I suppose you could validate $_SESSION and $_COOKIE as well. Or any array of values.
     * @return	Boolean			Returns true if validation passes, false otherwise.
     */
    public function validate(array $values) {
        $this->posted_values = $values;

        $rules = & $this->getRules();
        foreach ($rules as $element_name => $element) {
            $element_attributes = $element['attributes'];
            $error_str = '';
            $value = &$this->getValue($element_name);

            /**
             * the transform attribute was added in version 1.3
             */
            if (isset($element_attributes['transform'])) {
                $value = $this->transform($value, $element_attributes['transform']);
            }

            /**
             * first, check if it is required.
             */
            $length = strlen($value);

            if (!$length and isset($element_attributes['required'])) {
                if ($element_attributes['required'] == 'required') {
                    $error_str = $this->getErrorMessage('required');
                } elseif ($element_attributes['required'] == '') {
                    $error_str = 'Malformed required-syntax.';
                } else {
                    // there is a condition!
                    /**
                     * Had to do it trixy because of the following:
                     * ''!=point[survey_answer][answer_text][question_id=1][Gymnasiet(minst 2 Ã¥r)][points]
                     * The "=" in [question_id=1] messes it up. I wish I didn't have to do this but I do. The above weirdness is from a live project.
                     */
                    $values = explode('&', $element_attributes['required']);
                    $booleans = array();
                    $pattern = '/(!=|«|»|=)/'; // « and » are used instead of < and >. the latter ones would mess up getDomElements() completely

                    foreach ($values as $val) {
                        $results = preg_split($pattern, $val, -1, PREG_SPLIT_DELIM_CAPTURE);
                        if (sizeof($results) == 3) {
                            $first_value = $results[0];
                            $operand = $results[1];
                            $second_value = $results[2];
                        } else {
                            /**
                             * Try putting together the pieces and see if any fit
                             */
                            $first_value = '';
                            $temp = '';
                            for ($i = 0; $i < sizeof($results); $i++) {
                                $temp.= $results[$i];
                                if (isset($rules[$temp])) {
                                    $first_value = $temp;
                                    $operand = $results[++$i];
                                    $second_value = '';
                                    $i++;
                                    for (; $i < sizeof($results); $i++) {
                                        $second_value.=$results[$i];
                                    }
                                }
                            }
                            /**
                             * Try the same thing starting from the end
                             */
                            if (!$first_value) {
                                $temp = '';
                                for ($i = sizeof($results) - 1; $i >= 0; $i--) {
                                    $temp = $results[$i] . $temp;
                                    if (isset($rules[$temp])) {
                                        /**
                                         * @bugfix 1.2.1 I had the variables switched around, which would have messed up any
                                         */
                                        $second_value = $temp;
                                        $operand = $results[--$i];
                                        $first_value = '';
                                        $i--;
                                        for (; $i >= 0; $i--) {
                                            $first_value.=$results[$i];
                                        }
                                    }
                                }
                            }
                            if (!isset($first_value)) {
                                $error_str = 'Malformed required-syntax.';
                            }
                        }
                        $first_value = isset($rules[$first_value]) ? $this->getValue($first_value) : trim($first_value, "'");
                        $second_value = isset($rules[$second_value]) ? $this->getValue($second_value) : trim($second_value, "'");
                        if ($operand == '=') {
                            $operand = '==';
                        }
                        if ($operand == '«') {
                            $operand = '<';
                        }
                        if ($operand == '»') {
                            $operand = '>';
                        }
                        $booleans[] = '(' . var_export($first_value, 1) . $operand . var_export($second_value, 1) . ')';
                    }
                    if (!$error_str) {
                        $eval_str = '$boolean=' . implode(' & ', $booleans) . ';';
                        eval($eval_str);
                        if ($boolean) {
                            $error_str = $this->getErrorMessage('required');
                        }
                    }
                }
            }

            /**
             * next, check the rules.
             */
            if (!$error_str) {
                $type = isset($element_attributes['type']) ? $element_attributes['type'] : '';

                /**
                 * The validate-attribute overrides the "type". So we can validate hidden fields.
                 */
                $type = isset($element_attributes['validate']) ? $element_attributes['validate'] : $type;

                switch ($type) {
                    case 'week' : if ($length && !is::Week($value)) {
                            $error_str = $this->getErrorMessage($type);
                        } break;
                    case 'month' : if ($length && !is::Month($value)) {
                            $error_str = $this->getErrorMessage($type);
                        } break;
                    case 'color' : if ($length && !is::Color($value)) {
                            $error_str = $this->getErrorMessage($type);
                        } break;
                    case 'creditcard' : if ($length && !is::CreditCard($value)) {
                            $error_str = $this->getErrorMessage($type);
                        } break;
                    case 'url' : if ($length && !is::Url($value)) {
                            $error_str = $this->getErrorMessage($type);
                        } break;
                    case 'integer' : if ($length && !is::Integer($value)) {
                            $error_str = $this->getErrorMessage($type);
                        } break;
                    case 'number' : if ($length && !is::Number($value)) {
                            $error_str = $this->getErrorMessage($type);
                        } break;
                    case 'range' : if ($length && !is::Number($value)) {
                            $error_str = $this->getErrorMessage('number');
                        } break;
                    case 'email' : if ($length && !is::Email($value)) {
                            $error_str = $this->getErrorMessage($type);
                        } break;
                    case 'alphabetic' : if ($length && !is::Alphabetic($value)) {
                            $error_str = $this->getErrorMessage($type);
                        } break;
                    case 'alphanumeric' : if ($length && !is::AlphaNumeric($value)) {
                            $error_str = $this->getErrorMessage($type);
                        } break;
                    case 'time' : if ($length && !is::Time($value)) {
                            $error_str = $this->getErrorMessage($type);
                        } break;
                    case 'datetime' : if ($length && !is::DateTime($value)) {
                            $error_str = $this->getErrorMessage($type);
                        } break;
                    case 'datetime-local' : if ($length && !is::DateTimeLocal($value)) {
                            $error_str = $this->getErrorMessage($type);
                        } break;
                    case 'date' : if ($length && !is::Date($value, isset($element_attributes['dateformat']) ? $element_attributes['dateformat'] : 'yyyy-mm-dd')) {
                            $error_str = $this->getErrorMessage($type);
                        }break;
                    case 'captcha' :
                        if ($length) {
                            include_once 'securimage/securimage.php';
                            $securimage = new Securimage();
                            if ($securimage->check($value) == false) {
                                $error_str = $this->getErrorMessage($type);
                            }
                        }
                        break;

                    case 'zipcode' :
                        if ($length) {
                            $country = isset($element_attributes['countryelement']) ? $this->getValue($element_attributes['countryelement']) : $this->country;
                            /**
                             * added the auto-transform functionality in version 1.3
                             */
                            if (isset(is::$zipcode_patterns[$country]['transform'])) {
                                $value = $this->transform($value, is::$zipcode_patterns[$country]['transform']);
                            }

                            if (!is::Zipcode($value, $this->getValue($element_attributes['countryelement']))) {
                                $error_str = $this->getErrorMessage($type);
                            } else {
                                // no country is set, so no validation is possible
                            }
                        }
                        break;
                }
            }
            if (!$error_str && $length && isset($element_attributes['maxlength']) && $length > $element_attributes['maxlength']) {
                $error_str = str_replace('{length}', $element_attributes['maxlength'], $this->getErrorMessage('maxlength'));
                $error_str = str_replace('{current}', $length, $error_str);
            }
            if (!$error_str && $length && isset($element_attributes['minlength']) && $length < $element_attributes['minlength']) {
                $error_str = str_replace('{length}', $element_attributes['minlength'], $this->getErrorMessage('minlength'));
                $error_str = str_replace('{current}', $length, $error_str);
            }
            if (!$error_str && $length && isset($element_attributes['min']) && is::Numeric($value) && $value < $element_attributes['min']) {
                $error_str = str_replace('{value}', $element_attributes['min'], $this->getErrorMessage('min'));
            }
            if (!$error_str && $length && isset($element_attributes['max']) && is::Numeric($value) && $value > $element_attributes['max']) {
                $error_str = str_replace('{value}', $element_attributes['max'], $this->getErrorMessage('max'));
            }
            if (!$error_str && isset($element_attributes['mustmatch']) && $this->getValue($element_attributes['mustmatch']) !== $value) {
                $error_str = $this->getErrorMessage('mustmatch');
            }

            if (!$error_str && isset($element['enum']) && $length) {
                if (!in_array($value, $element['enum'])) {
                    $error_str = str_replace('{enum}', implode(', ', $element['enum']), $this->getErrorMessage('enum'));
                }
            }
            if (!$error_str && isset($element_attributes['callback'])) {
                $error_str = $this->executeCallback($element_attributes['callback'], $value);
            }

            if ($error_str) {
                $this->triggerError($error_str, $element_name);
            }
        }
        return !sizeof($this->errors);
    }

    private function transform($value, $transformation) {
        switch ($transformation) {
            case 'uppercase':
                $value = strtoupper($value);
                break;
            case 'lowercase':
                $value = strtolower($value);
                break;
            case 'capitalize':
                $value = ucwords($value);
                break;
            default:
                break;
        }
        return $value;
    }

    /**
     * Get JavaScript class names for an element from the rules
     * @param	array	$attributes	The element attributes
     * @return	String			The compounded class name
     */
    private function _getJavascriptClassNameFromRules(array $attributes) {
        $class = '';
        if (isset($attributes['type'])) {
            switch ($attributes['type']) {

                case 'checkbox' :
                case 'radio' :
                case 'text' :
                case 'hidden' :
                case 'button' :
                case 'submit' :
                case 'password' :
                case 'image' :
                case 'file' :
                case 'range' : // does not work in jQuery validator
                    break;
                default:
                    $class.= ' ' . $attributes['type'];
                    break;
                    break;
            }
        }
        if (isset($attributes['required']) and $attributes['required'] == 'required') {
            $class.=' required';
        }
        if (isset($attributes['min'])) {
            $class.=' min[' . $attributes['min'] . ']';
        }
        if (isset($attributes['max'])) {
            $class.=' max[' . $attributes['max'] . ']';
        }
        if (isset($attributes['minlength'])) {
            $class.=' minlength[' . $attributes['minlength'] . ']';
        }
        if (isset($attributes['maxlength'])) {
            $class.=' maxlength[' . $attributes['maxlength'] . ']';
        }
        if (isset($attributes['min'])) {
            $class.=' min[' . $attributes['min'] . ']';
        }

        return trim($class);
    }

    /**
     *
     * @param array $invalid_stuff
     */

    /**
     * Parses the form, removes invalid tags, inserts values, etc.
     * @param	array	$invalid_stuff	Invalid element types and attributes to be stripped
     * @return	String					The valid html4/html5
     */
    private function _getForm(array $invalid_stuff) {
        $rules = $this->getRules();
        $html = $this->html;
        foreach ($rules as $tag_name => $rule) {
            //echo "<pre>\n".__FILE__.': '.__LINE__."\n"; echo htmlentities(print_r($rules,1))."\n\n</pre>";exit;
            $value = $this->getValue($tag_name);
            /**
             * start editing the extracted data
             */
            if (!isset($rule['tag'])) {
                continue 1;
            }

            $new_html = '';
            switch ($rule['tag']) {
                case 'select' :
                    if ($js = self::_getJavascriptClassNameFromRules($rule['attributes'])) {
                        $rule['attributes']['class'] = isset($rule['attributes']['class']) ? $rule['attributes']['class'] . ' ' . $js : $js;
                    }
                    $content = $rule['content'];
                    if ($value !== false) {
                        $value = htmlspecialchars($value, ENT_COMPAT, $this->charset);
                        $content = str_replace(' selected="selected"', '', $content);
                        $content = str_replace('value="' . $value . '"', 'value="' . $value . '" selected="selected"', $content);
                    }
                    $new_html = '<select';
                    foreach ($rule['attributes'] as $key => $val) {
                        if (!in_array($key, $invalid_stuff['invalid_attributes']['select'])) {
                            $new_html .= ' ' . $key . '="' . $val . '"';
                        }
                    }
                    $new_html.='>' . $content . '</select>';
                    break;
                case 'textarea' :
                    if ($js = self::_getJavascriptClassNameFromRules($rule['attributes'])) {
                        $rule['attributes']['class'] = isset($rule['attributes']['class']) ? $rule['attributes']['class'] . ' ' . $js : $js;
                    }
                    $new_html = '<textarea';
                    foreach ($rule['attributes'] as $key => $val) {
                        if (!in_array($key, $invalid_stuff['invalid_attributes']['textarea'])) {
                            $new_html .= ' ' . $key . '="' . $val . '"';
                        }
                    }
                    if ($value == false) {
                        $value = $rule['content'];
                    }
                    $new_html.='>' . htmlspecialchars($value, ENT_COMPAT, $this->charset) . '</textarea>';
                    break;
                case 'input' :
                    switch ($rule['attributes']['type']) {
                        case 'radio' :
                            $first_loop = 1;
                            foreach ($rule['elements'] as $val => $element) {
                                if ($js = self::_getJavascriptClassNameFromRules($rule['attributes'])) {
                                    $element['attributes']['class'] = isset($element['attributes']['class']) ? $element['attributes']['class'] . ' ' . $js : $js;
                                }
                                /**
                                 * If the value is set, but it is not this value
                                 */
                                if ($value !== false) {
                                    if ($value == $val) {
                                        $element['attributes']['checked'] = 'checked';
                                    } else {
                                        unset($element['attributes']['checked']);
                                    }
                                }

                                $new_html = '<input';
                                foreach ($element['attributes'] as $key => $avalue) {
                                    if (!in_array($key, $invalid_stuff['invalid_attributes']['input'])) {
                                        $new_html .= ' ' . $key . '="' . $avalue . '"';
                                    }
                                }
                                $new_html .= ' />';

                                /**
                                 * So the error is only displayed on the first radio
                                 */
                                if (isset($this->errors[$tag_name]) and $first_loop) {
                                    $new_html .= '<label for="' . $tag_name . '" class="error" generated="true">' . $this->errors[$tag_name] . '</label>';
                                }
                                $first_loop = 0;
                                $html = str_replace($element['raw_html'], $new_html, $html);
                            }
                            continue 3; // so we don't try to do all the replacements again.
                        case 'checkbox' :
                            if ($js = self::_getJavascriptClassNameFromRules($rule['attributes'])) {
                                $rule['attributes']['class'] = isset($rule['attributes']['class']) ? $rule['attributes']['class'] . ' ' . $js : $js;
                            }
                            if ($value !== false) {
                                if ($rule['attributes']['value'] == $value) {
                                    $rule['attributes']['checked'] = 'checked';
                                } else {
                                    unset($rule['attributes']['checked']);
                                }
                            }
                            $new_html.= '<input';
                            foreach ($rule['attributes'] as $key => $value) {
                                if (!in_array($key, $invalid_stuff['invalid_attributes']['input'])) {
                                    $new_html .= ' ' . $key . '="' . $value . '"';
                                }
                            }
                            $new_html .= ' />';
                            break;
                        case 'captcha' :
                            $url = $_SERVER['REQUEST_URI'];
                            $url.= (strpos($url, '?') === false ? '?' : '&amp;') . 'jform-captcha&amp;';
                            $new_html.='<img alt="Something has gone wrong with captcha." id="jform-captcha" src="' . $url . '" width="215" height="80" border="0" /><a href="#" onclick="document.getElementById(\'jform-captcha\').src = document.getElementById(\'jform-captcha\').src + Math.random(); return false"><img src="' . $url . 'jform-captcha-refresh-button" alt="Change image" /></a>';
                        default :
                            if ($js = self::_getJavascriptClassNameFromRules($rule['attributes'])) {
                                $rule['attributes']['class'] = isset($rule['attributes']['class']) ? $rule['attributes']['class'] . ' ' . $js : $js;
                            }
                            if ($value !== false) {
                                $rule['attributes']['value'] = htmlspecialchars($value, ENT_COMPAT, $this->charset);
                            }
                            if (in_array($rule['attributes']['type'], $invalid_stuff['invalid_types'])) {
                                $rule['attributes']['type'] = 'text';
                            }
                            $new_html.= '<input';
                            foreach ($rule['attributes'] as $key => $value) {
                                if (!in_array($key, $invalid_stuff['invalid_attributes']['input'])) {
                                    $new_html .= ' ' . $key . '="' . $value . '"';
                                }
                            }
                            $new_html .= ' />';
                            break;
                    }
                    break;
                default :
                    continue 2;
                    break;
            }
            if (isset($this->errors[$tag_name])) {
                $new_html .= '<label for="' . $tag_name . '" class="error" generated="true">' . $this->errors[$tag_name] . '</label>';
            }
            $html = str_replace($rule['raw_html'], $new_html, $html);
        }
        return $html;
    }

    /**
     * Makes sure there are no elements with name of type name="foo[][]"
     * jForm cannot validate empty brackets. I don't think it's even theoretically possible.
     */
    private function _replaceEmptyBracketsInTagNames() {
        $weird_tag_pattern = '@<(input|select|textarea)([^>]*(name="([^"]+)(\[\])+[^"]*"))[^>]*(/>|>)@si'; // tar fucking allt.
        preg_match_all($weird_tag_pattern, $this->html, $weird_tag_matches, PREG_SET_ORDER);

        while (!empty($weird_tag_matches)) {
            foreach ($weird_tag_matches as $match) {
                $counter_name = 'counter_' . $match[4];
                if (!isset($$counter_name)) {
                    $$counter_name = 0;
                }
                $old_tag_name = $match[4] . '[]';
                $new_tag_name = $match[4] . '[' . $$counter_name++ . ']';
                $new_tag_str = str_replace($old_tag_name, $new_tag_name, $match[0]);
                $this->html = preg_replace('/' . preg_quote($match[0], '/') . '/', $new_tag_str, $this->html, 1);
            }
            preg_match_all($weird_tag_pattern, $this->html, $weird_tag_matches, PREG_SET_ORDER);
        }
    }

    /**
     * Parses included files into a string
     * @return	String		The resulting plain html
     */
    private function generateRawHtml() {
        foreach ($this->forms as $key => $file_name) {
            ob_start();
            extract($this->variables);
            include($file_name);
            $this->html.= ob_get_clean();
            unset($this->forms[$key]);
        }
        return $this->html;
    }

    /**
     * Extracts the rules from an html form into a rule array
     *
     * @return array
     */
    public function getDomElements($html) {
        $tags = array();

        $this->_replaceEmptyBracketsInTagNames();
        $tag_pattern = '@<(input|select|textarea)([^>]+)@si';

        /**
         * This may seem like a weird way of doing it, and I agree. But I had a project where the normal
         * way of doing it, with preg_match_all() just failed, for no apparent reason. It returned no matches
         * when there obviously were plenty. I guess a bug somewhere deep down in PHP.
         * But this method worked, so here we are. It has yet to fail. :)
         */
        $results = preg_split($tag_pattern, $this->html, -1, PREG_SPLIT_DELIM_CAPTURE);
        $i = 0;
        $len = sizeof($results);

        $attribute_pattern = '@([a-zA-Z_0-9]+)="([^"]*)"*@si';

        while ($i < $len) {
            $tag = $results[$i];
            if ($tag == 'input' or $tag == 'textarea' or $tag == 'select') {
                $attribute_string = $results[++$i];
                $attributes = array();
                preg_match_all($attribute_pattern, $attribute_string, $attribute_matches, PREG_SET_ORDER);
                if (!empty($attribute_matches)) {
                    $attributes = array();
                    foreach ($attribute_matches as $attribute_matches_value) {
                        $attribute_key = $attribute_matches_value[1];
                        $attribute_value = $attribute_matches_value[2];
                        $attributes[$attribute_key] = $attribute_value;
                    }
                }
                if (isset($attributes['name'])) {
                    switch ($tag) {
                        case 'input':
                            $tags[] = array(
                                'tag' => $tag,
                                'attributes' => $attributes,
                                'raw_html' => '<input' . $attribute_string . '>',
                            );
                            break;
                        case 'textarea':
                        case 'select':
                            $content = $results[++$i];
                            $end_tag_pos = strpos($content, '</' . $tag . '>');
                            $content = substr($content, 1, $end_tag_pos - 1);
                            $tags[] = array(
                                'tag' => $tag,
                                'start_tag' => '<' . $tag . '' . $attribute_string . '>',
                                'end_tag' => '</' . $tag . '>',
                                'attributes' => $attributes,
                                'content' => $content,
                                'raw_html' => '<' . $tag . '' . $attribute_string . '>' . $content . '</' . $tag . '>',
                            );
                            break;
                        default:
                            break;
                    }
                }
            }
            $i++;
        }
        return $tags;
    }

    /**
     * Returns the rules extracted from the form
     * @return Array the rules
     */
    public function &getRules() {
        if (empty($this->rules)) {
            $this->generateRawHtml();
            $this->_replaceEmptyBracketsInTagNames();
            $elements = $this->getDomElements($this->html);
            $rules = array();
            foreach ($elements as $element) {
                $attributes = &$element['attributes'];
                $tag_name = $attributes['name'];
                $tag = $element['tag'];
                /**
                 * If nothing is set, the input is a text-input.
                 */
                if ($tag == 'input' and empty($attributes['type'])) {
                    $attributes['type'] = 'text';
                }

                /**
                 * if it's a radio button, merge it with the other buttons
                 */
                if ($tag == 'input' and ($attributes['type'] == 'range' or $attributes['type'] == 'number') and isset($attributes['step'])) {
                    $element['enum'] = array();
                    for ($i = $attributes['min']; $i <= $attributes['max']; $i = $i + $attributes['step']) {
                        $element['enum'][] = $i;
                    }
                }
                if ($tag == 'input' and $attributes['type'] == 'radio') {
                    $this_val = $attributes['value'];
                    /**
                     * If there already is an enum, add this element's attributes to it.
                     */
                    if (!isset($rules[$tag_name]['enum'])) {
                        $rules[$tag_name]['enum'] = array();
                    }

                    $rules[$tag_name] = array_merge($rules[$tag_name], $element);
                    $rules[$tag_name]['elements'][$this_val] = $element;
                    $rules[$tag_name]['enum'][$this_val] = $this_val;
                    continue 1;
                }
                /**
                 * Fetch all the possible values of the select, put in $attributes['enum']
                 * Makes sure only values from the select can be posted
                 *
                 * @todo Hmm. makes javascript-populated lists impractical. Maybe I should ditch this?
                 * then again, the form must be generated to evaluate, so even if something has been
                 * posted, it must be rebuilt first.
                 *
                 */
                if ($tag == 'select') {
                    $options = $element['content'];
                    $option_value_pattern = '@value="([^"]+)"@si';
                    preg_match_all($option_value_pattern, $options, $option_matches);
                    $element['enum'] = $option_matches[1]; // @bugfix version 1.2.1 wrong variable name -> enum was not populated.
                }
                $rules[$tag_name] = $element;
            }
            $this->rules = $rules;
        }
        foreach ($this->added_rules as $key => $rule) {
            foreach ($rule as $element_name => $attribute) {
                $this->rules[$key]['attributes'][$element_name] = $attribute;
            }
        }
        return $this->rules;
    }

    /**
     * Gets the form html, in valid html5
     * @return	String		The html
     */
    public function html5() {
        $html = $this->_getForm($this->invalid_stuff['html5']);
        return $html;
    }

    /**
     * Gets the form html, in valid html4
     * @return	String		The html
     */
    public function html4() {
        $html = $this->_getForm($this->invalid_stuff['html4']);
        return $html;
    }

    /**
     * A function used in the provided example and that's it. It's not important.
     * @param	String	$value	The value to be validated
     * @return	String			An error string if invalid, otherwise an empty string
     */
    private function testCallback($value) {
        $str = '';
        if ($value !== 'text') {
            $str = 'Please enter the word "text". (Error generated by callback)';
        }
        return $str;
    }

    /**
     * Executes a callback function
     * If you are using namespaces, make sure to include them in the function name
     *
     * @param	String	$function_name	The name of the function to be executed
     * @param	String	$value		The value to validate
     * @return	String				The value returned by the executed callback function
     *
     * @version 1.2.1 : renamed doCallback to executeCallback
     */
    private function executeCallback($function, $value) {
        $pattern = '/(.*?)\s*::\s*(\w+)$/';
        if (preg_match($pattern, $function, $matches)) {
            $function = array($matches[1], $matches[2]);
        }
        return call_user_func($function, $value);
    }

    /**
     * Generates images used by captcha. Must be called before any output is sent to the browser.
     */
    public static function init() {
        if (isset($_GET['jform-captcha'])) {
            @ob_end_clean();
            if (isset($_GET['jform-captcha-refresh-button'])) {
                $name = dirname(__FILE__) . '/securimage/images/refresh.png';
                $fp = fopen($name, 'rb');
                header("Content-Type: image/png");
                header("Content-Length: " . filesize($name));
                fpassthru($fp);
                exit;
            } else {
                include_once('securimage/securimage.php');
                $img = new securimage();
                $img->image_height = 80;                                // width in pixels of the image
                $img->image_width = $img->image_height * M_E;          // a good formula for image size
                $img->show();  // outputs the image and content headers to the browser
                exit;
            }
        }
    }

}

jForm::init();
