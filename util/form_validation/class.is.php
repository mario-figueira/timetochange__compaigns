<?php

/**
 * class is
 *
 * A collection of functions that validate stuff.
 *
 * Feel free to use it any way you like.
 * (Most patterns come from http://www.regexlib.com)
 *
 * @version 1.1
 * @author Jonas Lagerwall
 * @example echo is::Email('john@doe.com'); // returns true
 * @changelog
 * 1.1	- altered $zipcode_patterns so that auto-transformation would be possible in class.jForm.php
 * 		- added "gb" to the zipcode patterns.
 *
 */
Class is {

	public static $zipcode_patterns = array(
		'se' => array('pattern' => '^(s-|S-){0,1}[0-9]{3}\s?[0-9]{2}$'), // Sweden @author Tommy Ullberg
		'us' => array('pattern' => '^(?!0{5})(\d{5})(?!-?0{4})(-?\d{4})?$'), // USA @author Justin Elsberry
		'nl' => array('pattern' => '^[1-9][0-9]{3}[ ]?(([a-rt-zA-RT-Z]{2})|([sS][^dasDAS]))$'), // Netherlands @author "Erik"
		'ch' => array('pattern' => '^[1-9][0-9][0-9][0-9]$'), // Switzerland @author Michael Freiermuth
		'gb' => array('pattern' => '^[a-z A-Z]{2}[0-9]{1,2}[a-z A-Z]{0,1}[ ]{1,2}[0-9][a-z A-Z]{2}$', 'transform' => 'uppercase'), // United Kingdom @author Tony Coombe
	);
	public static $named_colors = array('AliceBlue', 'AntiqueWhite', 'Aqua', 'Aquamarine', 'Azure', 'Beige', 'Bisque', 'Black', 'BlanchedAlmond', 'Blue', 'BlueViolet', 'Brown', 'BurlyWood', 'CadetBlue', 'Chartreuse', 'Chocolate', 'Coral', 'CornflowerBlue', 'Cornsilk', 'Crimson', 'Cyan', 'DarkBlue', 'DarkCyan', 'DarkGoldenRod', 'DarkGray', 'DarkGrey', 'DarkGreen', 'DarkKhaki', 'DarkMagenta', 'DarkOliveGreen', 'Darkorange', 'DarkOrchid', 'DarkRed', 'DarkSalmon', 'DarkSeaGreen', 'DarkSlateBlue', 'DarkSlateGray', 'DarkSlateGrey', 'DarkTurquoise', 'DarkViolet', 'DeepPink', 'DeepSkyBlue', 'DimGray', 'DimGrey', 'DodgerBlue', 'FireBrick', 'FloralWhite', 'ForestGreen', 'Fuchsia', 'Gainsboro', 'GhostWhite', 'Gold', 'GoldenRod', 'Gray', 'Grey', 'Green', 'GreenYellow', 'HoneyDew', 'HotPink', 'IndianRed', 'Indigo', 'Ivory', 'Khaki', 'Lavender', 'LavenderBlush', 'LawnGreen', 'LemonChiffon', 'LightBlue', 'LightCoral', 'LightCyan', 'LightGoldenRodYellow', 'LightGray', 'LightGrey', 'LightGreen', 'LightPink', 'LightSalmon', 'LightSeaGreen', 'LightSkyBlue', 'LightSlateGray', 'LightSlateGrey', 'LightSteelBlue', 'LightYellow', 'Lime', 'LimeGreen', 'Linen', 'Magenta', 'Maroon', 'MediumAquaMarine', 'MediumBlue', 'MediumOrchid', 'MediumPurple', 'MediumSeaGreen', 'MediumSlateBlue', 'MediumSpringGreen', 'MediumTurquoise', 'MediumVioletRed', 'MidnightBlue', 'MintCream', 'MistyRose', 'Moccasin', 'NavajoWhite', 'Navy', 'OldLace', 'Olive', 'OliveDrab', 'Orange', 'OrangeRed', 'Orchid', 'PaleGoldenRod', 'PaleGreen', 'PaleTurquoise', 'PaleVioletRed', 'PapayaWhip', 'PeachPuff', 'Peru', 'Pink', 'Plum', 'PowderBlue', 'Purple', 'Red', 'RosyBrown', 'RoyalBlue', 'SaddleBrown', 'Salmon', 'SandyBrown', 'SeaGreen', 'SeaShell', 'Sienna', 'Silver', 'SkyBlue', 'SlateBlue', 'SlateGray', 'SlateGrey', 'Snow', 'SpringGreen', 'SteelBlue', 'Tan', 'Teal', 'Thistle', 'Tomato', 'Turquoise', 'Violet', 'Wheat', 'White', 'WhiteSmoke', 'Yellow', 'YellowGreen');

	// http://www.regular-expressions.info/email.html
	public static function Email($s) {
		return preg_match('@' . addcslashes('^[a-z0-9!#$%&\'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&\'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+(?:[a-z]{2}|com|org|net|gov|mil|biz|info|mobi|name|aero|jobs|museum)$', '@') . '@si', $s);
	}

	public static function Url($s) {
		return preg_match('@(^http://|https://)([a-zA-Z0-9]+\.[a-zA-Z0-9\-]+|[a-zA-Z0-9\-]+)\.[a-zA-Z\.]{2,6}(/[a-zA-Z0-9\.\?=/#%&\+-]+|/|)@', $s);
	}

	public static function Integer($s) {
		return preg_match('/^-?[0-9]*$/si', $s);
	}

	public static function Number($s) {
		return preg_match('/^[-+]?[0-9]+[.]?[0-9]*([eE][-+]?[0-9]+)?$/si', $s);
	}

	public static function Float($s) {
		return self::Number($s);
	}

	public static function Numeric($s) {
		return self::Number($s);
	}

	public static function Alphabetic($s) {
		return preg_match('/^[a-zA-Z]+$/si', $s);
	}

	public static function AlphaNumeric($s) {
		return preg_match('/^[a-zA-Z0-9_]+$/si', $s);
	}

	public static function DateTime($s) {
		return preg_match('/^((((19|20)(([02468][048])|([13579][26]))-02-29))|((20[0-9][0-9])|(19[0-9][0-9]))-((((0[1-9])|(1[0-2]))-((0[1-9])|(1\d)|(2[0-8])))|((((0[13578])|(1[02]))-31)|(((0[1,3-9])|(1[0-2]))-(29|30)))))(T| )(([0-1][0-9])|([1-2][0-3]))(:|\.)([0-5][0-9])((:|\.)[0-9][0-9])*(Z|[+-]+([0-1][0-9]|[2][0-3]):([0-5][0-9]))$/si', $s);
	}

	public static function DateTimeLocal($s) {
		return preg_match('/^((((19|20)(([02468][048])|([13579][26]))-02-29))|((20[0-9][0-9])|(19[0-9][0-9]))-((((0[1-9])|(1[0-2]))-((0[1-9])|(1\d)|(2[0-8])))|((((0[13578])|(1[02]))-31)|(((0[1,3-9])|(1[0-2]))-(29|30)))))(T| )(([0-1][0-9])|([1-2][0-3]))(:|\.)([0-5][0-9])((:|\.)[0-9][0-9])*$/si', $s);
	}

	public static function Interval($s) {
		return preg_match('/^-?[0-9]+ (minute|hour|second|month|day|year)s*$/si', $s);
	}

	public static function CreditCard($s) {
		include_once('creditcard.inc.php');
		$obj = new CCVAL();
		return $obj->isVAlidCreditCard($s);
	}

	public static function Month($s) {
		if (preg_match('/^([0-9]{4})-([0-9]{2})$/', $s, $matches)) {
			return checkdate($matches[2], '01', $matches[1]);
		}
		return false;
	}

	public static function Week($s) {
		if (preg_match('/^([0-9]{4})-(W(0[1-9]|[1-4][0-9]|5[0-3]))$/', $s, $matches)) {
			return checkdate('12', '01', $matches[1]); // make sure it's a valid year
		}
		return false;
	}

	public static function Date($s, $format = 'yyyy-mm-dd') {
		switch ($format) {
			case 'yyyy-mm-dd' :
				if (preg_match('/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/', $s, $matches)) {
					return checkdate($matches[2], $matches[3], $matches[1]);
				}
				return false;
			case 'mm/dd/yyyy' :
				if (preg_match('@^([0-9]{2})/([0-9]{2})/([0-9]{4})$@', $s, $matches)) {
					return checkdate($matches[1], $matches[2], $matches[3]);
				}
				return false;
		}
		return false;
	}

	public static function Zipcode($s, $country) {
		if (!isset(self :: $zipcode_patterns[$country])) {
			return true;
		} // validation not possible, return true
		return preg_match('@' . self :: $zipcode_patterns[$country]['pattern'] . '@', $s);
	}

	public static function Time($s) {
		return (
			/* 24 hours */ preg_match('/^(([0-1][0-9])|([1-2][0-3]))(:|\.)([0-5][0-9])((:|\.)[0-9][0-9])*$/si', $s)
			or
			/* 12 hours */ preg_match('@^([1-9]|1[0-2]|0[1-9]){1}(:|\.)([0-5][0-9](\s{0,1})[aApP][mM]){1}$@si', $s)
			);
	}

	public static function Color($s) {
		return
			preg_match('/^rgb\(([01]?\d\d?|2[0-4]\d|25[0-5])\,([01]?\d\d?|2[0-4]\d|25[0-5])\,([01]?\d\d?|2[0-4]\d|25[0-5])\)$/si', $s)
			or
			preg_match('/^\#?[A-Fa-f0-9]{3}([A-Fa-f0-9]{3})?$/si', $s)
			or
			in_array(strtolower($s), array_map('strtolower', self :: $named_colors));
	}

	public static function Luhn($s) {
		$s = str_replace('-', '', $s);
		$l = strlen($s);
		$k = '';
		while ($l--) {
			$k.= substr($s, $l, 1) * (($l + 1) % 2 + 1);
		}
		$l = strlen($k);
		$s = 0;
		while ($l--) {
			$s+= substr($k, $l, 1);
		}
		return !($s % 10);
	}

	/**
	 * Swedish "social security number"
	 */
	public static function PersonNummer($s) {
		$pattern = "/^(\d{2})((\d{2})(\d{2})(\d{2})-\d{4})$/";
		if (preg_match($pattern, $s, $matches)) {
			if (checkdate($matches[4], $matches[5], $matches[1] . $matches[3])) {
				return is::Luhn($matches[2]);
			}
		}
		return false;
	}

	/**
	 * Swedish "social security number" for corporations
	 */
	public static function OrganisationsNummer($s) {
		$pattern = "/^(\d{2})(\d{2})(\d{2})-\d{4}$/";
		if (preg_match($pattern, $s, $matches)) {
			if (!checkdate($matches[2], $matches[3], $matches[1])) { // orgnr cannot be a date
				return is::Luhn($matches[0]);
			}
		}
		return false;
	}

}
