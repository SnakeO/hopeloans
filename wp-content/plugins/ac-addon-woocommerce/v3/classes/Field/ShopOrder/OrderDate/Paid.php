<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @since 3.0
 */
class ACA_WC_Field_ShopOrder_OrderDate_Paid extends ACA_WC_Field_ShopOrder_OrderDate {

	public function set_label() {
		$this->label = __( 'Paid', 'codepress-admin-columns' );
	}

	public function get_date( WC_Order $order ) {
		return $order->get_date_paid();
	}

	public function get_meta_key() {
		return '_date_paid';
	}

	public function filtering() {
		return new ACA_WC_Filtering_ShopOrder_MetaDate( $this->column );
	}

}
