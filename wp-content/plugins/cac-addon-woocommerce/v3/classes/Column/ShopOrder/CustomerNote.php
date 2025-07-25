<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @since 3.0
 */
class ACA_WC_Column_ShopOrder_CustomerNote extends ACP_Column_Post_Excerpt {

	public function __construct() {
		parent::__construct();

		$this->set_type( 'column-wc-order_customer_note' );
		$this->set_label( __( 'Customer Note', 'codepress-admin-columns' ) );
		$this->set_group( 'woocommerce' );
	}

	public function get_raw_value( $id ) {
		return ac_helper()->post->get_raw_field( 'post_excerpt', $id );
	}

	public function register_settings() {
		$this->add_setting( new ACA_WC_Settings_UseIcon( $this ) );
	}

	public function filtering() {
		return new ACA_WC_Filtering_ShopOrder_CustomerMessage( $this );
	}

	public function export() {
		return new ACA_WC_Export_ShopOrder_CustomerMessage( $this );
	}

}
