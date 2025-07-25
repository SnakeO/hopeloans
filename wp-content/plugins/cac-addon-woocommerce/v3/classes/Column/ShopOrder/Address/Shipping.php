<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @since 3.0
 */
class ACA_WC_Column_ShopOrder_Address_Shipping extends ACA_WC_Column_ShopOrder_Address {

	public function __construct() {
		$this->set_type( 'column-wc-order_shipping_address' );
		$this->set_label( __( 'Shipping Address', 'codepress-admin-columns' ) );
		$this->set_group( 'woocommerce' );
	}

	public function get_meta_key() {
		if ( ! $this->get_address_property() ) {
			return false;
		}

		return '_shipping_' . $this->get_address_property();
	}

	protected function get_formatted_address( WC_Order $order ) {
		return $order->get_formatted_shipping_address();
	}

	public function get_setting_address_object() {
		return new ACA_WC_Settings_ShopOrder_Address( $this );
	}

}
