<?php  

class JConfig {

	public static $config = array();

	public static function init()
	{
		// load in config
		foreach( glob(JMVC . 'config/*.php') as $config_file ) {
			require_once $config_file;
		}
	}

	public static function set($what, $val)
	{
		self::$config[$what] = $val;
	}

	// JConfig::get('array/path/to/item');
	public static function get($what_path)
	{
		$what_parts = explode('/', $what_path);
		$val = @self::$config[array_shift($what_parts)];
		foreach($what_parts as $what_part) {
			$val = @$val[$what_part];
		}

		return @$val;
	}
}
