<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'ACA_WC_FILE', __FILE__ );

require_once 'classes/Dependencies.php';

function ac_addon_wc_helper() {
	return new ACA_WC_Helper();
}

function aca_wc_loader() {
	$dependencies = new ACA_WC_Dependencies( plugin_basename( ACA_WC_MAIN_FILE ) );

	if ( ! class_exists( 'WooCommerce', false ) ) {
		$dependencies->add_missing( 'WooCommerce', $dependencies->get_search_url( 'WooCommerce' ) );

		return;
	}

	if ( $dependencies->is_missing_acp( '4.2.4' ) ) {
		return;
	}

	AC()->autoloader()->register_prefix( 'ACA_WC_', plugin_dir_path( __FILE__ ) . 'classes/' );

	ac_addon_wc()->register();
}

add_action( 'after_setup_theme', 'aca_wc_loader' );

function ac_addon_wc() {
	return new ACA_WC_Plugin();
}
