<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Main ACF Addon plugin class
 *
 * @since 1.0
 */
final class ACA_WC_Plugin extends AC_Plugin {

	protected function get_file() {
		return ACA_WC_MAIN_FILE;
	}

	public function get_prefix() {
		return 'ACA_WC_';
	}

	protected function get_version_key() {
		return 'aca_wc_version';
	}

	public function get_plugin_dir() {
		return plugin_dir_path( ACA_WC_FILE );
	}

	public function get_plugin_url() {
		return plugin_dir_url( ACA_WC_FILE );
	}

	/**
	 * Register hooks
	 */
	public function register() {
		add_action( 'ac/list_screen_groups', array( $this, 'register_list_screen_groups' ) );
		add_action( 'ac/column_groups', array( $this, 'register_column_groups' ) );
		add_action( 'ac/list_screens', array( $this, 'register_list_screens' ) );
		add_action( 'ac/column_types', array( $this, 'register_columns' ) );
		add_action( 'init', array( $this, 'install' ) );

		new ACA_WC_TableScreen();

		// Variation List Table
		if ( $this->is_version_gte( '3.3' ) ) {
			new ACA_WC_PostType_ProductVariation();
		}
	}

	public function install() {
		parent::install();

		if ( $this->is_version_gte( '3.3' ) ) {
			$update = new ACA_WC_Update_V3300();

			if ( ! $update->is_applied() ) {
				$update->run();
			}
		}
	}

	/**
	 * @param string $version
	 *
	 * @return bool
	 */
	public function is_version_gte( $version ) {
		return version_compare( WC()->version, $version, '>=' );
	}

	/**
	 * Register list screens
	 */
	public function register_list_screens() {
		AC()->register_list_screen( new ACA_WC_ListScreen_ShopOrder );
		AC()->register_list_screen( new ACA_WC_ListScreen_ShopCoupon );
		AC()->register_list_screen( new ACA_WC_ListScreen_Product );

		if ( $this->is_version_gte( '3.3' ) ) {
			AC()->register_list_screen( new ACA_WC_ListScreen_ProductVariation );
		}
	}

	/**
	 * @param AC_ListScreen $list_screen
	 */
	public function register_columns( $list_screen ) {
		if ( $list_screen instanceof AC_ListScreen_User ) {
			$list_screen->register_column_types_from_dir( $this->get_plugin_dir() . 'classes/Column/User', $this->get_prefix() );
		}

		if ( $list_screen instanceof AC_ListScreen_Comment ) {
			$list_screen->register_column_types_from_dir( $this->get_plugin_dir() . 'classes/Column/Comment', $this->get_prefix() );
		}
	}

	/**
	 * @param AC_Groups $groups
	 */
	public function register_list_screen_groups( $groups ) {
		$groups->register_group( 'woocommerce', 'WooCommerce', 7 );
	}

	/**
	 * @param AC_Groups $groups
	 */
	public function register_column_groups( $groups ) {
		$groups->register_group( 'woocommerce', __( 'WooCommerce', 'codepress-admin-columns' ), 15 );
	}

}
