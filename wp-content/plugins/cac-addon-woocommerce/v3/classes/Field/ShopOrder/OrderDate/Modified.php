<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @since 3.0
 */
class ACA_WC_Field_ShopOrder_OrderDate_Modified extends ACA_WC_Field_ShopOrder_OrderDate {

	public function set_label() {
		$this->label = __( 'Modified', 'codepress-admin-columns' );
	}

	public function get_date( WC_Order $order ) {
		return $order->get_date_modified();
	}

}
