<?php

class TextUtil {

	/**
	 * Suports array
	 */
	public static function toString($input, $result = '') {
		if (is_array($input)) {
			foreach ($input as $key => $value) {
				$result .= $key . '->[' . TextUtil::toString($value, $result) . ']';
			}
		} else {
			$result = $input;
		}
		return $result;
	}

	public static function replaceUnderscoreWithSpaces($input) {
		$output = str_replace("_", " ", $input);
		return $output;
	}

}