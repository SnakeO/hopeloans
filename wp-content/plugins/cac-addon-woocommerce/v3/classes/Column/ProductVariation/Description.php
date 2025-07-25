<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @since 3.0
 */
class ACA_WC_Column_ProductVariation_Description extends AC_Column_Meta
	implements ACP_Column_EditingInterface {

	public function __construct() {
		$this->set_type( 'column-wc-product_description' );
		$this->set_label( __( 'Description', 'woocommerce' ) );
		$this->set_group( 'woocommerce' );
	}

	public function get_meta_key() {
		return '_variation_description';
	}

	public function register_settings() {
		$this->add_setting( new AC_Settings_Column_StringLimit( $this ) );
	}

	public function editing() {
		return new ACA_WC_Editing_ProductVariation_Description( $this );
	}

}
