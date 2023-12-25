<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Component {

/**
 * ### Usage:
 *
 * ```
 * echo $style(array('margin' => '10px', 'padding' => '10px'), true);
 *
 * // creates
 * 'margin:10px;padding:10px;'
 * ```
 *
 */
    public function style($data, $oneline = true) {
		if (!is_array($data)) {
			return $data;
		}
		$out = array();
		foreach ($data as $key => $value) {
			$out[] = $key . ':' . $value . ';';
		}
		if ($oneline) {
			return implode(' ', $out);
		}
		return implode("\n", $out);
	}


}