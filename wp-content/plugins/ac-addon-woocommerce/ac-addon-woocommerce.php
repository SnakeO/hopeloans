<?php
/*
Plugin Name: 		    Admin Columns Pro - WooCommerce
Version: 			    3.0.3
Description: 		    Powerful columns for the WooCommerce Product, Orders and Coupon overview screens
Author: 			    Admin Columns
Author URI: 		    https://www.admincolumns.com
Plugin URI: 		    https://www.admincolumns.com
Text Domain: 		    codepress-admin-columns
WC tested up to:        3.4
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! is_admin() ) {
	return;
}

define( 'ACA_WC_MAIN_FILE', __FILE__ );

function aca_wc_main_loader() {
	$current_version = defined( 'WC_VERSION' ) && WC_VERSION ? WC_VERSION : 3;

	$versions = array(
		'3',
		'2',
	);

	foreach ( $versions as $version ) {
		if ( version_compare( $current_version, $version, '>=' ) ) {
			require_once plugin_dir_path( __FILE__ ) . sprintf( 'v%s/wc.php', str_replace( '.', '', $version ) );

			return;
		}
	}
}

add_action( 'after_setup_theme', 'aca_wc_main_loader', 9 );