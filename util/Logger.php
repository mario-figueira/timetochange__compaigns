<?php

class Logger {

	public static function debug($this, $message) {
		if (DEBUGLOG) {
			error_log(date("Y-m-d H:i:s") . ': ' . get_class($this) . ' DEBUG -> ' . $message . PHP_EOL, 3, DEBUGFILE);
		}
	}

	public static function error($this, $message) {
		error_log(date("Y-m-d H:i:s") . ': ' . get_class($this) . ' EXCEPTION -> ' . $message . PHP_EOL, 3, ERRORFILE);
	}

	public static function exception($this, $exception) {
		error_log(date("Y-m-d H:i:s") . ': ' . get_class($this) . ' EXCEPTION -> ' . $exception . PHP_EOL, 3, ERRORFILE);
	}

	public static function htmlComment($this, $message) {
		if (DEBUG) {
			echo '<!--' . (date("Y-m-d H:i:s") . ': ' . get_class($this) . ' DEBUG -> ' . $message . PHP_EOL) . '-->';
		}
	}

}