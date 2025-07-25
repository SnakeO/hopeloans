<?php

/**
 *  This class holds data between template parts. The magic accessor is
 *  T::data('var')
 *
 * 	It also allows a sort of 'controller' paradigm when loading in wordpress templates.
 *  Data is gathered from classes prior to showing the template. 
 *  Those are stored inside the loaders/ folder.
 */
class T 
{
	static $data = array();

	/**
	 * Method to access data
	 * @param  string $var var to access
	 * @return mixed    The value
	 */
	public static function data($var)
	{
		return T::$data[$var];
	}

	/**
	 * Conveniece function (as a plus, the code looks kind of like "Tada!")
	 */
	public static function da($var)
	{
		return T::$data[$var];
	}

	public static function init()
	{
		// this allows us to get the current template later on
		add_action('template_include', array('T', 'define_current_template'), 1000);

		// template_init will hold the necessary data for the template
		add_action('template_include', array('T', 'template_init'), 2000);
	}

	/**
	 * URL to the current template directory
	 */
	public static function url()
	{
		return get_stylesheet_directory_uri();
	}

	/**
	 * wordpress hook: this action fires off when a template is about to load in. 
	 * It preps the 'view data' that we want available;
	 * @return void
	 */
	public static function template_init($template)
	{
		// the theme name will be used as the controller class
		$theme_name = ucfirst(strtolower(get_stylesheet()));					// standardize by making it lower case, with first letter uppercase
		$theme_name = preg_replace('/[^0-9a-zA-Z_]/', '_', $theme_name);		// replace special chars with _

		// the template name (without extension) will be used as the method name. 
		// special characters are replaced with underscores. Everything is lowercase
		// So 'front-page.php' becomes 'front_page()' function
		$template_name = strtolower(substr(T::get_current_template(), 0, -4));		// remove extension
		$template_name = preg_replace('/[^0-9a-zA-Z_]/', '_', $template_name);	// replace special chars with _

		//include_once(__DIR__ . "/loaders/$theme_name.php"); -- this is now handled by the autoloader
		$template_class = '\templatedata\loaders\\' . $theme_name;

		if( class_exists($template_class) ) {
			$theme_controller = new $template_class();
		}

		echo "<!-- Template Class: $template_class -->";

		// verify the controller + function exists
		if( !$theme_controller ) 
		{
			// controller not found
			return $template;
		}

		echo "<!-- Template Method Name: $template_name -->";

		if( !method_exists($theme_controller, $template_name) )
		{
			// method not found
			return $template;
		}

		// further filtering w/post slug (if available)
		global $post;

		// get the data
		T::$data = $theme_controller->$template_name(@$post->post_name);

		return $template;
	}

	/**
	 * Get Current Theme Template Filename
	 *
	 * Get's the name of the current theme template file being used
	 *
	 * @global $current_theme_template Defined using define_current_template()
	 * @param $echo Defines whether to return or print the template filename
	 * @return The name of the template filename, including .php
	 */
	public static function get_current_template( $echo = false ) 
	{
		if ( !isset( $GLOBALS['current_theme_template'] ) ) {
			trigger_error( '$current_theme_template has not been defined yet', E_USER_WARNING );
			return false;
		}
		if ( $echo ) {
			echo $GLOBALS['current_theme_template'];
		}
		else {
			return $GLOBALS['current_theme_template'];
		}
	}

	/**
	 * Define current template file
	 *
	 * Create a global variable with the name of the current
	 * theme template file being used.
	 *
	 * @param $template The full path to the current template
	 */
	// http://www.kevinleary.net/get-current-theme-template-filename-wordpress/
	public static function define_current_template( $template ) 
	{
		$GLOBALS['current_theme_template'] = basename($template);
		return $template;
	}
}

?>