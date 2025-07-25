<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @since 3.0
 */
class ACA_WC_Column_User_CustomerSince extends ACA_WC_Column_UserOrder {

	public function __construct() {
		parent::__construct();

		$this->set_type( 'column-wc-user-customer_since' );
		$this->set_label( __( 'Customer Since', 'codepress-admin-columns' ) );
	}

	// Display
	public function get_raw_value( $customer_id ) {
		$order_id = $this->get_order_by_user_id( $customer_id );

		if ( ! $order_id ) {
			return false;
		}

		$order = new WC_Order( $order_id );

		return $order->get_date_completed()->format( 'Y-m-d' );
	}

	public function get_order_by_user_id( $id ) {
		return $this->get_order_for_user( $id, array( 'order' => 'ASC' ) );
	}

	public function register_settings() {
		$this->add_setting( new AC_Settings_Column_Date( $this ) );
	}

}
