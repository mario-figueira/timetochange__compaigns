<?php

class HTMLUtil {

	/**
	 * Get and array as input outputs html table with keys for colum names and values for cell values
	 */
	static function arrayToTable($inputArray, $headClass) {
		if (is_array($inputArray)) {
			print '<table>' . PHP_EOL;
			$first = true;
			foreach ($inputArray as $row) {
				if ($first) {
					$first = false;
					print '	<tr class=' . $headClass . '>' . PHP_EOL;
					foreach ($row as $key => $value) {
						print'		<td>' . $key . '</td>' . PHP_EOL;
					}
					print '	</tr>' . PHP_EOL;
				}
				print '	<tr>' . PHP_EOL;
				foreach ($row as $key => $value) {
					print '		<td>' . gettype($value) . $value . '</td>' . PHP_EOL;
				}
				print '	</tr>' . PHP_EOL;
			}
			print '</table>' . PHP_EOL;
		}
	}

}

