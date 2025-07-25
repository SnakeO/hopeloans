<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @since 2.0
 */
class ACA_WC_Column_ShopOrder_Customer extends AC_Column_Meta
	implements ACP_Export_Column {

	public function __construct() {
		$this->set_label( 'Customer' );
		$this->set_type( 'column-wc-order_customer' );
		$this->set_group( 'woocommerce' );
	}

	// Meta

	public function get_meta_key() {
		return '_customer_user';
	}

	// Display

	public function get_value( $id ) {
		$customer_id = $this->get_raw_value( $id );
		$value = $this->get_formatted_value( $customer_id, $id );

		if ( ! $value ) {
			return $this->get_empty_char();
		}

		return $value;
	}

	public function register_settings() {
		$this->add_setting( new ACA_WC_Settings_Customer( $this ) );
	}

	public function export() {
		return new ACP_Export_Model_StrippedValue( $this );
	}

}
