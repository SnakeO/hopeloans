<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @since 3.0
 */
class ACA_WC_Field_ShopOrder_OrderDate_Completed extends ACA_WC_Field_ShopOrder_OrderDate {

	public function set_label() {
		$this->label = __( 'Completed', 'codepress-admin-columns' );
	}

	public function get_date( WC_Order $order ) {
		return $order->get_date_completed();
	}

	public function get_meta_key() {
		return '_date_completed';
	}

	public function filtering() {
		return new ACA_WC_Filtering_ShopOrder_MetaDate( $this->column );
	}

}
