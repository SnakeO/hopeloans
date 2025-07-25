<?php
/**
* Smart Footer System - Settings Class
*/
class SfsSettings {
	/**
	 * Get settings
	 * @return array of data settings
	 */
	public static function get() {
		return get_option(SFS_OPTIONS_KEY, [
			"hide_footer" => false,
			"classes"	  => ""
		]);
	}
	/**
	 * Set settings
	 * @param array $data $_POST data with settings
	 * @return boolean
	 */
	public static function set($data = []) {
		return update_option(SFS_OPTIONS_KEY, $data);
	}
}