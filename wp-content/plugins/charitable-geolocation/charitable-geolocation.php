<?php
/**
 * Plugin Name: 		Charitable - Geolocation
 * Plugin URI:          https://www.wpcharitable.com/extensions/charitable-geolocation/
 * Description:			Adds a Location field to Charitable campaigns.
 * Version: 			1.1.4
 * Author: 				WP Charitable
 * Author URI: 			https://www.wpcharitable.com
 * Requires at least: 	4.2
 * Tested up to: 		4.9.4
 *
 * Text Domain: 		charitable-geolocation
 * Domain Path: 		/languages/
 *
 * @package 			Charitable Geolocation
 * @category 			Core
 * @author 				WP Charitable
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Load plugin class, but only if Charitable is found and activated.
 *
 * @return 	void
 * @since 	1.0.0
 */
function charitable_geolocation_load() {
	require_once( 'includes/class-charitable-geolocation.php' );

	$has_dependencies = true;

	/* Check for Charitable */
	if ( ! class_exists( 'Charitable' ) ) {

		if ( ! class_exists( 'Charitable_Extension_Activation' ) ) {

			require_once 'includes/class-charitable-extension-activation.php';

		}

		$activation = new Charitable_Extension_Activation( plugin_dir_path( __FILE__ ), basename( __FILE__ ) );
		$activation = $activation->run();

		$has_dependencies = false;

	} else {

		new Charitable_Geolocation( __FILE__ );

	}
}

add_action( 'plugins_loaded', 'charitable_geolocation_load', 1 );
